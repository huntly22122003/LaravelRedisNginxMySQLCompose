<?php
namespace App\Http\Controllers;

use App\Services\OrderWebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
class OrderWebhookController extends Controller
{
    public function __construct(protected OrderWebhookService $service) {}

    public function index()
    {
        $orders = $this->service->listOrders();
        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $this->service->handleOrderCreate($request);
        Log::info('ALL HEADERS', $request->headers->all());
        return response()->json(['ok' => true], 200);
    }
}