<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function store()
    {
        $role = Role::all();

        return response()->json([
            'role' => $role,
            'status'=> 200
        ], 200);
    }
}
