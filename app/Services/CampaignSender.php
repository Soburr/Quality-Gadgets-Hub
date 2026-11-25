<?php

namespace App\Services;

use App\Mail\CampaignMail;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignRecipient;
use Illuminate\Support\Facades\Mail;

class CampaignSender
{

    public function sendBatch(EmailCampaign $campaign, int $maxEmails = 25, int $maxSeconds = 20): array
    {

        $campaign->recipients()
            ->where('status', 'sending')
            ->where('updated_at', '<', now()->subMinutes(5))
            ->update(['status' => 'pending']);

        $startedAt = microtime(true);
        $handled = 0;
        $consecutiveFailures = 0;
        $halted = false;
        $lastError = null;

        while ($handled < $maxEmails && (microtime(true) - $startedAt) < $maxSeconds) {
            $recipient = $campaign->recipients()
                ->where('status', 'pending')
                ->with('subscriber')
                ->orderBy('id')
                ->first();

            if (! $recipient) {
                break;
            }

            $claimed = EmailCampaignRecipient::whereKey($recipient->id)
                ->where('status', 'pending')
                ->update(['status' => 'sending']);

            if ($claimed !== 1) {
                continue;
            }

            $subscriber = $recipient->subscriber;

            if (! $subscriber || $subscriber->unsubscribed_at) {
                $recipient->update(['status' => 'skipped']);
                continue;
            }

            try {
                Mail::to($subscriber->email)->send(new CampaignMail($campaign, $subscriber));
                $recipient->update(['status' => 'sent', 'sent_at' => now(), 'error' => null]);
                $consecutiveFailures = 0;
            } catch (\Throwable $e) {
                $lastError = mb_substr($e->getMessage(), 0, 300);
                $recipient->update(['status' => 'failed', 'error' => $lastError]);
                $consecutiveFailures++;
            }

            $handled++;

            // Three in a row almost always means a config problem (wrong
            // SMTP login, host limit hit), not three bad addresses. Stop
            // instead of failing the whole list.
            if ($consecutiveFailures >= 3) {
                $halted = true;
                break;
            }
        }

        $counts = $this->counts($campaign);

        if ($counts['pending'] === 0 && $campaign->status === 'sending') {
            $campaign->update(['status' => 'sent', 'finished_at' => now()]);
        }

        return $counts + ['halted' => $halted, 'error' => $halted ? $lastError : null];
    }

    public function counts(EmailCampaign $campaign): array
    {
        $by = $campaign->recipients()
            ->selectRaw('status, count(*) as c')
            ->groupBy('status')
            ->pluck('c', 'status');

        return [
            'total' => (int) $by->sum(),
            'sent' => (int) ($by['sent'] ?? 0),
            'failed' => (int) ($by['failed'] ?? 0),
            'skipped' => (int) ($by['skipped'] ?? 0),
            'pending' => (int) (($by['pending'] ?? 0) + ($by['sending'] ?? 0)),
        ];
    }
}