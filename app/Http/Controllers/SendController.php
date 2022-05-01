<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use Mail;

class SendController extends Controller
{
 /*  public function send(Request $request) { 

        $this->validate($request, [
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required'
        ]);

        Mail::send('email', [
                'email' => $request->get('email'),
                'comment' => $request->get('message') ],
                function ($message) {
                        $message->from('dev@twm.ec');
                        $message->to($request->get('email'), $request->get('email'))
                                ->subject($request->get('subject'));
        });

        return back()->with('success', 'Notificacion enviada correctamente');
        
    } */

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
