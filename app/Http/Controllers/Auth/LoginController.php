<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function show() {
        return View::make("Login");
    }
}
