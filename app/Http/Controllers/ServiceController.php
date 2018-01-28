<?php

namespace App\Http\Controllers;

use App\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function statusUpdate()
    {
        $service = request('service');
        $status = request('status');

        Service::where('name', $service)->update([
            'active' => $status
        ]);

        return redirect()->back();
    }
}
