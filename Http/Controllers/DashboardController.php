<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('system::dashboard.index');
    }
}
