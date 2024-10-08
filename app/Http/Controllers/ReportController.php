<?php

namespace App\Http\Controllers;

use App\Enum\TypeReport;
use App\Helpers\FileHelper;
use App\Http\Requests\Report\ReportRequest;
use App\Http\Requests\Report\ReportputRequest;
use App\Models\Report;
use App\Services\ReportServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{

    private $loggedUser;
    protected ReportServices $reportServices;
    // use FileHelper;
    public function __construct(
        ReportServices $reportServices
    ) {
        $this->loggedUser = Auth::user('api');
        $this->reportServices = $reportServices;
    }
    public function index(int $report)
    {
        $get = Report::where('id', $report)->first();
        if(!$get){
            return response()->json([
                'message' => 'Relátorio não encontrado!',
                'status'=> 402
            ], 402);
        }
        return response()->json([
            'status'=> '200',
            'message'=> 'Relátorio encontrado!',
            'report' => $get
        ], 200);
    }
    public function store()
    {
        $report = Report::clientOrAdmin($this->loggedUser->role_id)->get();

        return response()->json([
            'reports' => $report,
            'status'=> 200
        ], 200);

    }
    public function last()
    {
        return response()->json([
            'crypto'=> Report::where('type', TypeReport::CRYPTO)->clientOrAdmin($this->loggedUser->role_id)->get()->last(),
            'classic'=> Report::where('type', TypeReport::CLASSIC)->clientOrAdmin($this->loggedUser->role_id)->get()->last(),
            'status' => 200
        ],200);
    }
    public function create(ReportRequest $request)
    {
        // dd($request->document);
        $report = $this->reportServices->createAllData(
            $this->loggedUser->id,
            $request->title,
            $request->type,
            $request->document,
            $request->audio,
            $request->display_date_at,
            $request->description,
        );
        if($report->exception){
            return response()->json([
                'message' => 'error na criação do relatorio, 402.',
                'status'=> 402
            ], 402);
        }
        // return response()->json([
        //     'reports' => $report,
        //     'status'=> 200
        // ], 200);
        return $report;

    }
    public function update(ReportputRequest $request)
    {
        $resp = $this->reportServices->update(
            $request->report_id,
            $this->loggedUser->id,
            $request->title,
            $request->description,
            $request->type,
            $request->display_date_at,
        );
        if($resp){
            return response()->json([
                'message' => 'Relatorio atualizado!',
                'reports' => $resp,
                'status'=> 200
            ], 200);
        }
        return response()->json([
            'message' => 'error na atualização do relatório, 402.',
            'status'=> 402
        ], 402);
    }
    public function delete(int $report)
    {
        $get = Report::where('id', $report)->deleteOnly($this->loggedUser->role_id)->first();
        if(!$get){
            return response()->json([
                'message' => 'Relátorio não encontrado!',
                'status'=> 402
            ], 402);
        }
        $get->delete();
        return response()->json(['status'=> '200','message'=> 'Relátorio excluido do sistema!'], 200);
    }
    public function updateDoc(Request $request)
    {

        $request->validate([
            'report_id' => 'required',
            'document' => 'required|file|mimes:pdf|max:59240',
        ]);


        $get = Report::where('id', $request->report_id)->first();
        if(!$get){
            return response()->json([
                'message' => 'Relátorio não encontrado!',
                'status'=> 402
            ], 402);
        }

        $response = $this->reportServices->updateDocument($get->id, $request->document);
        // return response()->json(['message'=>  $response->document, 'tem' => $this->getNameFile($response->document) ], 200);

        if(!$response){
            response()->json([
                'message' => 'error na atualização do relatório, 402.',
                'status'=> 402
            ], 402);
        }
        return response()->json([
            'message' => 'Documento atualizado com sucesso!',
            'report' => $response,
            'status'=> 200
        ], 200);
    }
    public function updateAudio(Request $request)
    {

        // 59MB em kilobytes
        $request->validate([
            'report_id' => 'required',
            'audio' =>'required|file|mimes:aac,aiff,amr,flac,m4a,ogg,opus,wav,wma,mp4,mpeg,mp3|max:59240'
        ]);
        $get = Report::where('id', $request->report_id)->first();
        if(!$get){
            return response()->json([
                'message' => 'Relátorio não encontrado!',
                'status'=> 402
            ], 402);
        }

        $response = $this->reportServices->updateAudio($get->id, $request->audio);
        // return response()->json(['message'=>  $response->document, 'tem' => $this->getNameFile($response->document) ], 200);

        if(!$response){
            response()->json([
                'message' => 'error na atualização do relatório, 402.',
                'status'=> 402
            ], 402);
        }
        return response()->json([
            'message' => 'Documento atualizado com sucesso!',
            'report' => $response,
            'status'=> 200
        ], 200);
    }
    public function deleteAudio(Request $request)
    {

        // 59MB em kilobytes
        $request->validate([
            'report_id' => 'required',
        ]);
        $get = Report::where('id', $request->report_id)->first();
        if(!$get->audio){
            return response()->json([
                'message' => 'Audio não encontrado no relatório!',
                'status'=> 402
            ], 402);
        }

        $response = $this->reportServices->audioDelete($get->id);
        // return response()->json(['message'=>  $response->document, 'tem' => $this->getNameFile($response->document) ], 200);

        if(!$response){
            response()->json([
                'message' => 'error na atualização do relatório, 402.',
                'status'=> 402
            ], 402);
        }
        return response()->json([
            'message' => 'Documento atualizado com sucesso!',
            'report' => $response,
            'status'=> 200
        ], 200);
    }
}
