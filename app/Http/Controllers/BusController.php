<?php

namespace App\Http\Controllers;

use App\Models\Apilog;
use App\Services\AuthService;
use App\Services\FlightService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BusController extends Controller
{
    protected $tektravels;

    public function __construct(AuthService $tektravels)
    {
        $this->tektravels = $tektravels;
    }

    public function root()
    {
        return view('bus.index-bus');
    }
    
}
