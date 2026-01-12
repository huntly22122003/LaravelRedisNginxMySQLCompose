<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotifyController extends Controller
{
    public function store(Request $request)
    {
        \Log::info('Frontend gửi:', $request->all());

        return response()->json([
            'status' => 'ok',
            'message' => 'đây Chắc chắn là HTML',
            'received' => $request->all()
        ]);
    }
}