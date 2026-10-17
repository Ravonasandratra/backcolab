<?php

namespace App\EventSubscriber;

use App\Event\MailingVerificationEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailingVerificationSubscriber implements EventSubscriberInterface
{

    public function __construct(private readonly MailerInterface $mailer)
    {
    }

    public function onAppEventsMailingVerificationEvents(MailingVerificationEvent $event): void
    {

        $data = $event->data;
        $email = new Email()
            ->to($data["to"])
            ->from("support@colab.com")
            ->subject("Email de confirmation")
            ->text("votre code de confirmation est " . $data["code"] . " ne partage jamais cette code!");

        $this->mailer->send($email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            MailingVerificationEvent::class => 'onAppEventsMailingVerificationEvents',
        ];
    }
}
