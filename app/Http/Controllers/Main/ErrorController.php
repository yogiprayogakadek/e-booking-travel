<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function forbidden()
    {
        return view('template.partials.error.forbidden');
    }
}
