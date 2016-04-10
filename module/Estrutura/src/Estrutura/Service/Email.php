<?php

namespace Estrutura\Service;


class Email{
//    protected $email;

//    public function __construct(){
//        parent::__construct('alexmedeiros', 'alex2011');
//        $this->email = new \SendGrid\Email();
//
////        $sendgrid = new \SendGrid('alexleandrom', "alexleandrom");
////        $email    = new \SendGrid\Email();
//
////        $email->addTo('brunotlove@gmail.com')->
////            setFrom('brunotlove@gmail.com')->
////            setSubject('Teste')->
////            setText('Teste!')->
////            setHtml('<strong>Hello World!</strong>');
////
////        debug($sendgrid->send($email));
//    }
//
//    public function __call($name, $arguments){
//        $this->email->$name($arguments);
//        return $this;
//    }
//
    public function enviar($para, $assunto, $mensagem){
        $sendgrid = new \SendGrid('alexmedeiros', "alex2011");
        $email    = new \SendGrid\Email();

        $email->addTo($para)->
            setFrom('email@teste.com')->
            setSubject($assunto)->
            setText($mensagem)->
            setHtml("<strong>$mensagem</strong>");


        return $sendgrid->send($email);
    }

} 