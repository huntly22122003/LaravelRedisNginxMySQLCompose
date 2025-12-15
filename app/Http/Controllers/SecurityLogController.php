<?php
namespace App\Http\Controllers;

use App\Services\SecurityLogService;

class SecurityLogController extends Controller
{
    protected SecurityLogService $service;

    public function __construct(SecurityLogService $service)
    {
        $this->service = $service;
    }

    // Trang hiển thị log của user hiện tại
    public function index()
    {
        $logs = $this->service->getLogsForCurrentUser();
        return view('security_logs.index', compact('logs'));
    }
}