<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailCampaignRecipient extends Model
{
    protected $fillable = ['email_campaign_id', 'email_subscriber_id', 'status', 'error', 'sent_at'];

    protected $casts = ['sent_at' => 'datetime'];

    public function campaign()
    {
        return $this->belongsTo(EmailCampaign::class, 'email_campaign_id');
    }

    public function subscriber()
    {
        return $this->belongsTo(EmailSubscriber::class, 'email_subscriber_id');
    }
}