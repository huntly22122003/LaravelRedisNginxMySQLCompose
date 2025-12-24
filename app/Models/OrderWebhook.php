<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderWebhook extends Model
{
    protected $connection = 'shop';
    protected $table = 'order_webhooks';
    protected $fillable = [
        'shopify_id',
        'shopify_order_id',
        'event',
        'webhook_id',
        'email',
        'total_price',
        'currency',
        'financial_status',
        'fulfillment_status',
        'raw_payload',
        'received_at',
    ];

    protected $casts = [
        'raw_payload' => 'array',
        'received_at' => 'datetime',
    ];

    public function shopify()
    {
        return $this->belongsTo(Shopify::class);
    }
}
