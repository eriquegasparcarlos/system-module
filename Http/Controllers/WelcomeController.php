<?php

namespace Modules\System\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('system::welcome.index');
    }
}
