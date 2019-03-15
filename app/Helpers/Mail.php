<?php

/*
 *  Mail - Send an HTML email with a blade template to a recipient via laravel Mail facade.
 */
if (!function_exists('sendMail')) {

    function sendMail($recipientAddress, $recipientName, $subject, $view, $parameters)
    {
        $fromAddress    = env('MAIL_FROM_ADDRESS');
        $fromName       = env('MAIL_FROM_NAME');

        Mail::send('emails.' . $view, $parameters, function ($message) use (
            $fromAddress,
            $fromName,
            $recipientAddress,
            $recipientName,
            $subject
        ) {
            $message->from($fromAddress, $fromName);
            $message->to($recipientAddress, $recipientName)
                ->subject($subject);
        });
    }
}
