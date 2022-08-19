<?php

class MailService{

    public function send($to, $subject, $message):bool
    {
        
        try{
            $headers = [
                'MIME-Version' => '1.0',
                'Content-type' => 'text/html; charset=utf8',
                'From' => 'john.doe@example.com',
                'Reply-To' => 'no_reply@example.com',
                'X-Mailer' => 'PHP/' . phpversion()
            ];

            if (mail($to, $subject, $message,  $headers)) {
               return true;
            } else {
                return false;
            }
        }catch( Exception $e ){
            die($e->getMessage());
        }
        
    }

}