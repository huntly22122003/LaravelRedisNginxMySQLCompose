<?php
namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Repositories\OrderWebhookRepository;
use App\Repositories\ShopifyRepository;
use App\Repositories\ProductNotifyRepository;
use Illuminate\Support\Facades\Log;

class OrderWebhookService
{
   public function __construct(
        protected OrderWebhookRepository $orderWebhookRepo,
        protected ShopifyRepository $shopifyRepo,
        protected ProductNotifyRepository $ProductNotify
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
            Log::info("Webhook {$webhookId} đã xử lý rồi, bỏ qua. Lần 1");
            Log::info($request);
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
        $this->SendMail($request);
    }

    public function listOrders(int $limit = 50)
    {
        return $this->orderWebhookRepo->getLatestOrders($limit);
    }

    public function SendMail(Request $request)
    {
        $payload = $request->json()->all();
        $item= $payload['line_items'][0] ?? null;
        $id = $item['product_id'] ?? null;
        $title = $item['title'] ??null;
        $mail = $payload['email'] ?? ($payload['customer']['email'] ?? null);
        $productid = $this->ProductNotify->findProduct($id); // Check in repository 
        $quantity = $item['quantity'] ?? 0;
        $date     = isset($payload['created_at'])
        ? \Carbon\Carbon::parse($payload['created_at'])->format('d/m/Y')
        : now()->format('d/m/Y');
        $messageText = "Product {$title} (với id{$id}) đã được mua - số lượng: {$quantity} - ngày: {$date}";
        Log::info("Kiem tra: {$id} ");
        if($productid)
            Mail::raw($messageText, function ($message) use ($mail) {
            $message->to($mail)
                    ->subject('Product Notification');
        });
    }
}