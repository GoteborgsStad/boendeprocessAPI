<?php

namespace App\Http\Controllers\ContactUser;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserRolesController extends Controller
{
    public function index()
    {
        $userRoles = \App\UserRole::get();

        return response()->json($userRoles, 200);
    }
}
