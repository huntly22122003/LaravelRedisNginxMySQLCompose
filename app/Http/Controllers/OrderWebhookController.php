<?php
namespace App\Http\Controllers;

use App\Services\OrderWebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class OrderWebhookController extends Controller
{
    public function __construct(protected OrderWebhookService $service) {}

    public function index()
    {
        $orders = $this->service->listOrders();
        return view('shopify.order_webhooks', compact('orders'));
    }

    public function store(Request $request)
    {
        $this->service->handleOrderCreate($request);
        Log::info('ALL HEADERS', $request->headers->all());
        return response()->json(['ok' => true]);
    }
}