<?php

namespace App\Console\Commands;

use App\Models\EmailCampaign;
use App\Services\CampaignSender;
use Illuminate\Console\Command;

class SendCampaignEmails extends Command
{
    protected $signature = 'campaigns:send {--limit=10}';

    protected $description = 'Send the next batch of every campaign that is in sending status';

    public function handle(CampaignSender $sender): int
    {
        foreach (EmailCampaign::where('status', 'sending')->get() as $campaign) {
            $result = $sender->sendBatch($campaign, (int) $this->option('limit'), 45);
            $this->info("Campaign #{$campaign->id}: sent {$result['sent']}, failed {$result['failed']}, waiting {$result['pending']}");
        }

        return self::SUCCESS;
    }
}