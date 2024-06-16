<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function store()
    {
        // $investment = Investment::with(['investmentPerformances'])->get();
        $investment = Investment::get();

        return response()->json([
            'investment' => $investment,
            'status'=> 200
        ], 200);
    }
}
