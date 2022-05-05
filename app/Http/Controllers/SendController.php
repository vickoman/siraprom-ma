<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Mail;

class SendController extends Controller
{
            public function send(){
                return view('send');
        }

    public function sendPost(Request $request){

        $this->validate($request, [
                        'email' => 'required|email',
                        'subject' => 'required',
                        'comment' => 'required'
                ]);
                $subject =$request->subject;
                $email=$request->email;
                $comment=$request->comment ;

        Mail::send('email', [
                'email' => $email,
                'subject' => $subject,
                'comment' => $comment ],
                function ($message) use ($email, $subject) {
                        $message->from('dev@twm.ec', 'TWM');
                        $message->to($email)
                                ->subject($subject);
        });

        return back()->with('success', 'Notificacion enviada correctamente');

    }
}
