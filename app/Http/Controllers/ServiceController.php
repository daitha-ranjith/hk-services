<?php

namespace App\Http\Controllers;

use Log;
use Exception;
use App\Service;

class ServiceController extends Controller
{
    public function statusUpdate()
    {
        $service = request('service');
        $status = request('status');

        try {
            if ($status) {
                exec('sudo supervisorctl start:hk-queue');
            } else {
                exec('sudo supervisorctl stop:hk-queue');
            }
        } catch (Exception $e) {
            Log::error('Queue Error: ' . $e->getMessage());
        }

        Service::where('name', $service)->update([
            'active' => $status
        ]);

        return redirect()->back();
    }
}
