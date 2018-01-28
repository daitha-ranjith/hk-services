<?php

namespace App\Http\Controllers;

use App\Service;

class AdminController extends Controller
{
    public function dashboard()
    {
        $services = Service::all();

        $interrupted = false;

        foreach ($services as $service) {
            if (! $service->active) {
                $interrupted = true;
                break;
            }
        }

        return view('admin.dashboard')->with(compact('services', 'interrupted'));
    }
}
