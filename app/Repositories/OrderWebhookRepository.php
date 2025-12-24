<?php
namespace App\Repositories;

use App\Models\OrderWebhook;

class OrderWebhookRepository
{
    public function create(array $data): OrderWebhook
    {
        return OrderWebhook::create($data);
    }

    public function existsByWebhookId(?string $webhookId): bool
    {
        return $webhookId ? OrderWebhook::where('webhook_id', $webhookId)->exists() : false;
    }

    public function getLatestOrders(int $limit = 50)
    {
        return OrderWebhook::latest()->take($limit)->get();
    }

}