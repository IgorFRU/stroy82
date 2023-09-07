<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\QuestionMail;

class SendmailController extends Controller
{
    public function question(Request $request) {
        //dd($request);
        $mail_body = '
            <html>
                <head>
                    <title>ЕЩЕ одна ТЕМА!</title>
                </head>
                <body>
                    <p>Имя: '.$request->name.'</p>
                    <p>Телефон: '.$request->phone.'</p>                        
                    <p>Вопрос: '.$request->question.'</p>                        
                </body>
            </html>';
        // <html>Добрый день!<br><br>Пользователь: ';
        // $mail_body.= $request->name .'.<br>Номер телефона: ';
        // $mail_body.= $request->phone .'.<br>Вопрос:<br><br>';
        // $mail_body = 'dsafsdfsfsf';
        $toEmail = "igor.parketmir@gmail.com";
        Mail::to($toEmail)->send(new QuestionMail($mail_body));

        // Mail::send(['text'=>'partials.question'], $comment, function($message) {
        //     $message->to("igor.parketmir@gmail.com", 'Tutorials Point')->subject
        //        ('Laravel Basic Testing Mail');
        //  });
         
        //return 'Сообщение отправлено на адрес '. $toEmail;

        //return redirect()->back()->with('success', 'Сообщение отправлено на адрес '. $toEmail);
        
    }

    public function oneclick(Request $request) {
        $mail_body = '
            <html>
                <body>
                    <p>Имя: '.$request->name.'</p>
                    <p>Телефон: '.$request->phone.'</p>                        
                    <p>Товар: '.$request->product.'</p>                     
                    <p>Количество: '.$request->quantity.'</p>                    
                    <p>Сумма: '.$request->price.'</p>                       
                </body>
            </html>';
        $toEmail = "igor.parketmir@gmail.com";
        Mail::to($toEmail)->send(new QuestionMail($mail_body));
    }
}
