<?php
/**
 * Created by PhpStorm.
 * User: Josh
 * Date: 9/6/2015
 * Time: 3:16 μμ
 */

namespace Application\Service;


use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;

class Application extends BaseService{

    public function sendMail($data){
        $contentRepository = $this->getRepository('application','content');
        $email = $contentRepository->findOneBy(array("target" => "contactEmail"))->getContent();
        $password = $contentRepository->findOneBy(array("target" => "contactPassword"))->getContent();
        $message = new Message();
        $body = "From: " . $data['contact']['sender'] . "

                {$data['contact']['body']}
                ";
        $message->addTo('info@infolightingco.com')
            ->addFrom($data['contact']['sender'])
            ->setSubject($data['contact']['subject'])
            ->addReplyTo($data['contact']['sender'])
            ->setBody($body)
            ->setEncoding("UTF-8");

        $transport = new SmtpTransport();
        $options = new SmtpOptions(array(
            'name' => 'infolightingco.com',
            'host' => 'mail.infolightingco.com',
            'port' => '25',
            'connection_class' => 'login',
            'connection_config' => array(
                // 'ssl' => 'tls',
                'username' => empty($email) ? 'info@infolightingco.com' : $email, //info@infolightingco.com
                'password' => empty($password) ? '7jhuP%KP' : $password, //7jhuP%KP
            )
        ));
        try {
            $transport->setOptions($options);
            $transport->send($message);

            return true;
        }catch (\Exception $e){
            $this->message = $e->getMessage();
        }
        return false;
    }
}