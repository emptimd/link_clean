<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Subscriptions;
use App\Models\User;
use Illuminate\Http\Request;
use Mail;
use App\Http\Requests\ContactFormRequest;

class GuestController extends Controller
{

    public function index()
    {
        return view('landing_new.index');
    }

    public function pricing()
    {
        $plan = [];
        if (auth()->check()) {
            $plan = Subscriptions::where(['user_id' => auth()->id(), 'is_active' => 1])->pluck('id', 'plan')->toArray();
        }

        return view('landing_new.pricing', [
            'plan' => $plan
        ]);
    }

    public function affiliate()
    {
        return view('landing.affiliate');
    }
    public function faq()
    {
        return view('landing_new.faq');
    }
    public function terms()
    {
        return view('landing_new.terms');
    }
    public function refundPolicy()
    {
        return view('landing_new.refund-policy');
    }
    public function contact()
    {
        return view('landing_new.contact');
    }

    public function contactStore(ContactFormRequest $request)
    {
        Mail::send('emails.contact', [
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'subject'   => $request->get('subject'),
            'msg'       => $request->get('message')
        ], function ($m) {
            $m->from(config('mail.from.address'))
            ->to(config('mail.to'), 'Info')
            ->subject('Contact form message');
        });

        return redirect('contact')->with('status', 'Your message was sent. Thanks for contacting us!');
    }

    public function ajaxLoginUser(Request $request)
    {
        $input = $request->all();
        $user = User::whereEmail($input['email'])->first();

        if(!$user) {
            $user = User::create([
                'name' => $input['email'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
            ]);

            \Auth::login($user, true);
            return ['user' => auth()->user()];
        }elseif(\Auth::attempt(['email' => $input['email'], 'password' => $input['password']], true)) {
            return ['user' => auth()->user()];
        }else {
            return response()->json([
                'error' => 'Wrong password',
            ], 422);
        }
    }
}
