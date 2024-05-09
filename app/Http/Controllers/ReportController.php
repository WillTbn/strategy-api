<?php

namespace App\Http\Controllers;

use App\Helpers\FileHelper;
use App\Http\Requests\ReportRequest;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use FileHelper;
    private $loggedUser;
    public function __construct() {
        $this->loggedUser = Auth::user('api');
    }
    public function index()
    {
        $report = Report::all();

        return response()->json([
            'reports' => $report,
            'status'=> 200
        ], 200);

    }
    public function create(ReportRequest $request)
    {
        dd($this->loggedUser);
        $request['user_id'] = $this->loggedUser->id;
        $report = Report::create([
            'document'=> $this->setFileStore($request->document,$request->user_id, 'reports' ),
        ]);
        if(!$report)
        {

        }
    }
}
