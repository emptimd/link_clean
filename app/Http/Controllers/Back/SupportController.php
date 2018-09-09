<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SupportController extends Controller
{

    public function showSupport()
    {
        $tickets = Ticket::all()->where('user_id', Auth::user()->id);

        return view('support.support', ['tickets' => $tickets]);
    }

    public function createSupport(Request $request)
    {
        if($request->isMethod('post'))
        {
            $this->validate($request, ['subject' => 'required|min:3', 'message' => 'required|min:10']);

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
            return redirect('support')->with('status', 'Ticket created successfully.');
        }

        return view('support.ticket_new');
    }

    public function viewSupport($id, Request $request)
    {
        $ticket = Ticket::where('id', $id)->where('user_id', Auth::user()->id)->first();
        if(!$ticket) return redirect('dashboard')->with('error', 'Something is wrong.');

        if($request->isMethod('post'))
        {
            if($ticket->status == 'closed') redirect('support/'.$ticket->id)->with('error', 'You can not post in closed in ticket.');

            $ticket->status = 'open';
            $ticket->save();

            TicketMessage::create([
                'date'		=> Carbon::now(),
                'ticket_id' => $ticket->id,
                'user_id' 	=> Auth::user()->id,
                'message' 	=> $request->message
            ]);
            return redirect('support/'.$ticket->id)->with('status', 'Message added successfully.');
        }

        return view('support.ticket', ['ticket' => $ticket]);
    }
}