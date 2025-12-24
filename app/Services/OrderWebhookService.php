<?php
namespace App\Services;

use Illuminate\Http\Request;
use App\Repositories\OrderWebhookRepository;
use App\Repositories\ShopifyRepository;
use Illuminate\Support\Facades\Log;

class OrderWebhookService
{
   public function __construct(
        protected OrderWebhookRepository $orderWebhookRepo,
        protected ShopifyRepository $shopifyRepo
    ) {}

    public function handleOrderCreate(Request $request): void
    {
        // Verify HMAC
        $rawBody = $request->getContent();
        $hmacHeader = $request->header('X-Shopify-Hmac-Sha256');
        $key = env('SHOPIFY_WEBHOOK_SECRET');
        $calculated = base64_encode(hash_hmac('sha256', $rawBody, $key, true));
            Log::info('Shopify HMAC Header: '.$hmacHeader);
            Log::info('Calculated HMAC: '.$calculated);

        if (!$hmacHeader || !hash_equals($hmacHeader, $calculated)) {
            abort(401, 'Invalid Shopify HMAC');
        }

        // Idempotency
        $webhookId = $request->header('X-Shopify-Webhook-Id');
        if ($this->orderWebhookRepo->existsByWebhookId($webhookId)) {
            return;
        }

        $shopDomain = $request->header('X-Shopify-Shop-Domain');
        $topic      = $request->header('X-Shopify-Topic');

        $shop = $shopDomain
            ? $this->shopifyRepo->getByDomain($shopDomain)
            : $this->shopifyRepo->getFirstShop();

        $payload = $request->json()->all();

        $this->orderWebhookRepo->create([
            'shopify_id'         => $shop->id ?? null,
            'shopify_order_id'   => $payload['id'] ?? null,
            'event'              => $topic ?? 'orders/create',
            'webhook_id'         => $webhookId,
            'email'              => $payload['email'] ?? ($payload['customer']['email'] ?? null),
            'total_price'        => $payload['total_price'] ?? null,
            'currency'           => $payload['currency'] ?? null,
            'financial_status'   => $payload['financial_status'] ?? null,
            'fulfillment_status' => $payload['fulfillment_status'] ?? null,
            'raw_payload'        => $payload,
            'received_at'        => now(),
        ]);
    }

    public function listOrders(int $limit = 50)
    {
        return $this->orderWebhookRepo->getLatestOrders($limit);
    }

}