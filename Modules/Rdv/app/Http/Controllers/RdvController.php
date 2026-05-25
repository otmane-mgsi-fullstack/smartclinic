<?php

namespace Modules\Rdv\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RdvController extends Controller
{
    /**
     * Display a listing of resources.
     */
    public function index()
    {
        return view('rdv::rdv');
    }
}
