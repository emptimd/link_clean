<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Payments;
use App\Models\RefEvents;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Carbon\Carbon;
use Auth;
use Laracasts\Utilities\JavaScript\JavaScriptFacade;
use Mail;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showClients()
    {
        return view('admin.clients');
    }

    public function showClient($id)
    {
        $client = User::findOrFail($id);
        $campaigns = Campaign::where('user_id', $id);

        return view('admin.client', [
            'client' => $client,
            'campaigns' => $campaigns
        ]);
    }

    public function showSupport()
    {
        return view('admin.support');
    }

    public function createSupport(Request $request)
    {
        if ($request->isMethod('post')) {
            $ticket = Ticket::create([
                'date' => Carbon::now(),
                'user_id' => Auth::user()->id,
                'subject' => $request->subject
            ]);
            TicketMessage::create([
                'date' => Carbon::now(),
                'ticket_id' => $ticket->id,
                'user_id' => Auth::user()->id,
                'message' => $request->message
            ]);
            return redirect('admin/support')->with('status', 'Ticket created successfully.');
        }

        return view('admin.ticket_new');
    }

    public function viewSupport($id, Request $request)
    {
        $ticket = Ticket::where('id', $id)->first();
        if (!$ticket) return redirect('dashboard')->with('error', 'Ticket not found.');

        if ($request->isMethod('post')) {
            $ticket->status = 'replied';
            $ticket->save();

            TicketMessage::create([
                'date' => Carbon::now(),
                'ticket_id' => $ticket->id,
                'user_id' => Auth::user()->id,
                'status' => 'replied',
                'message' => $request->message
            ]);


            // send ticket update email to user
            $user = User::findOrFail($ticket->user_id);
            Mail::send('emails.ticket_update', [
                'name' => $user->name,
                'ticket' => $ticket
            ], function ($m) use ($user, $ticket) {
                $m->from(config('mail.from.address'))
                    ->to($user->email, $user->name)
                    ->subject('Ticket #' . $ticket->id . ' has an update');
            });

            return redirect('admin/support/' . $ticket->id)->with('status', 'Message added successfully.');
        }

        return view('admin.ticket', ['ticket' => $ticket]);
    }

    public function updateSupport($id, Request $request)
    {
        $ticket = Ticket::where('id', $id)->first();
        if (!$ticket) return redirect('admin/support')->with('error', 'Ticket not found.');

        if ($request->isMethod('post') && $request->status) {
            $ticket->status = $request->status;
            $ticket->save();

            return redirect('admin/support/' . $ticket->id)->with('status', 'Ticket updated successfully.');
        }

        return redirect('admin/support/' . $ticket->id)->with('error', 'Something is wrong.');
    }

    public function showPayments()
    {

        $payments = User::select(['id', 'name', 'email', 'balance'])->where('balance', '<>', '0')->get();
        $data = [];
        foreach ($payments as $item) {
            $data[] = [
                $item->id,
                $item->name,
                $item->email,
                $item->balance,
                "<button class=\"btn btn-info btn-xs pay-single\" data-id='" . $item->id . "'>Pay</button>"
            ];
        }

        JavaScriptFacade::put([
            'payments' => $data,
        ]);

        return view('admin.payments');
    }

    public function createPayment($id)
    {
        $user = User::select(['id as user_id', 'balance as amount'])->where('balance', '<>', '0')->where('id', $id)->first();

        $data[] = [
            'user_id' => $user->user_id,
            'amount' => $user->amount,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        Payments::insert($data);

        /** @var User $new_user */
        $new_user = User::find($id);
        $new_user->balance = 0.00;
        $new_user->save();

        return back();
    }


    public function createPayments()
    {
        $users = User::select(['id as user_id', 'balance as amount'])->where('balance', '<>', '0')->get();

        $data = [];
        foreach ($users as $user) {
            $data[] = [
                'user_id' => $user->user_id,
                'amount' => $user->amount,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
        }

        Payments::insert($data);
        User::where('balance', '<>', '0')->update(['balance' => '0.00']);

        return back();
    }

    public function showEvents(Request $request)
    {
        if (!$request->ajax()) return view('admin.events');

        $events = RefEvents::all();
        $data = [];
        foreach ($events as $item) {
            $data[] = [$item->id, strtoupper($item->action), "<a href='" . url('admin/events/' . $item->user_id) . "'>" . $item->user_id . "</a>", $item->created_at->format('d M Y'), strtoupper($item->plan), $item->revenue ? $item->revenue : '-', $item->revenue_status ? $item->revenue_status : '-'];
        }

        return response()->json(["aaData" => $data]);
    }

    public function showEventsUser(Request $request, $id)
    {
        if (!$request->ajax()) return view('admin.events_user');

        $events = RefEvents::where('user_id', $id)->get();
        $data = [];
        foreach ($events as $item) {
            $data[] = [$item->id, strtoupper($item->action), $item->user_id, $item->created_at->format('d M Y'), strtoupper($item->plan), $item->revenue ? $item->revenue : '-', $item->revenue_status ? $item->revenue_status : '-'];
        }

        return response()->json(["aaData" => $data]);
    }

}