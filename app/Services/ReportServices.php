<?php

namespace App\Services;

use App\Enum\TypeReport;
use App\Helpers\FileHelper;
use App\Models\Account;
use App\Models\Report;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReportServices
{
    use FileHelper;
    public function report_create(
        $document,
        int $user_id,
        String $title,
        String $type,
        String $description =null,
        $audio =null
        )
    {
        // $doc = ;
        // dd($user_id);
        try{
            // dd($doc);
            $report = Report::create([
                'user_id' =>  $user_id,
                'document'=> $this->setDocOrAudio($document,$type, 'document', 'reports' ),
                'title' => $title,
                'description' => $description,
                'audio' => $audio,
                'type' => $type
            ]);
            return $report;
        }catch(Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro ao cria relatorio!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function report_update(
        int $report_id,
        int $user_id,
        String $title,
        String $description,
        String $type
    ){
        try{
            $report = Report::where('id', $report_id)->first();
            $report->user_id = $user_id;
            $report->title = $title;
            $report->type = $type;
            $report->description = $description;
            $report->save();
            return $report;
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro na atualização do relatorio!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function report_update_document(
        int $report_id,
        $document,
    ){
        try{
            $report = Report::where('id', $report_id)->first();
            $report->document = $this->setDocOrAudio($document,$report->type,'document', 'reports' );
            $report->saveOrFail();
            return $report;
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro na atualização do relatorio!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function report_update_audio(
        int $report_id,
        $audio,
    ){
        try{
            $report = Report::where('id', $report_id)->first();
            $report->audio = $this->setDocOrAudio($audio,$report->type,'audio', 'reports' );
            $report->saveOrFail();
            return $report;
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro na atualização do relatorio!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
    public function report_audio_delete(
        int $report_id,
    ){
        try{
            $report = Report::where('id', $report_id)->first();
            $report->audio = null;
            $report->saveOrFail();
            return $report;
        }catch( Exception $e){
            Log::error('exception ->'.$e);
            return response()->json([
                'message' => 'Erro na atualização do relatorio!',
                'exception' => $e,
                'status'=> 500
            ], 500);
        }
    }
}
