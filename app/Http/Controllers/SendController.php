<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Contact; 
use Mail;

class SendController extends Controller
{
   public function send(Request $request) { 

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
        
    }
}
