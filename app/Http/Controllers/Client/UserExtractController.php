<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\UserExtractServices;
use Illuminate\Http\Request;

class UserExtractController extends Controller
{
    private UserExtractServices $extractServices;
    public function __construct(
        UserExtractServices $extractServices
    )
    {
        $this->extractServices = $extractServices;
    }
    public function index(int $user_id)
    {
        $extract = $this->extractServices->get($user_id);

        return response()->json([
            'extract' => $extract,
            'status'=> 200
        ], 200);
    }
}
