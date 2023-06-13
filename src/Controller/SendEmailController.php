<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class SendEmailController extends AbstractController
{
    #[Route('/send-email', name: 'app_send_email',methods: ['POST'])]
    public function index(MailerInterface $mailer, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $email = (new Email())
            ->from('email_service@third.com')
            ->to($data['email'])
            ->subject($data['title'])
            ->text($data['content'])
            ->html('User '.$data['name'].' post a new blog');
        $mailer->send($email);
        return new Response('The email has been sent.', 200);
    }

    #[Route('/send-email-new-user', name: 'app_send_email_new_user',methods: ['POST'])]
    public function newUser(MailerInterface $mailer, Request $request): Response
    {
        $data = json_decode($request->getContent(), true);

        $email = (new Email())
            ->from('email_service@third.com')
            ->to($data['email'])
            ->subject('New user')
            ->html('User '.$data['name'].' have been added.');
        $mailer->send($email);
        return new Response('The email has been sent.', 200);
    }
}
