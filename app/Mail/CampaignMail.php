<?php

namespace App\Mail;

use App\Models\EmailCampaign;
use App\Models\EmailSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Headers;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;

class CampaignMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public EmailCampaign $campaign, public EmailSubscriber $subscriber)
    {
    }

    private function displayName(): string
    {
        return $this->subscriber->name ?: 'there';
    }

    private function unsubscribeUrl(): string
    {
        return $this->subscriber->exists
            ? URL::signedRoute('unsubscribe.show', ['subscriber' => $this->subscriber->id])
            : url('/');
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: str_replace('{name}', $this->displayName(), $this->campaign->subject),
        );
    }

    public function headers(): Headers
    {
        return new Headers(text: [
            'List-Unsubscribe' => '<'.$this->unsubscribeUrl().'>',
        ]);
    }

    public function content(): Content
    {
        $body = str_replace('{name}', $this->displayName(), $this->campaign->body);

        return new Content(
            view: 'emails.campaign',
            with: [
                'bodyHtml' => nl2br(e($body)),
                'unsubscribeUrl' => $this->unsubscribeUrl(),
            ],
        );
    }
}