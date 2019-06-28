<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Webhook extends Controller
{
    public function receive(Request $request, \App\Service\Webhook $service)
    {
        $service->receive($request->getContent());
    }
}
