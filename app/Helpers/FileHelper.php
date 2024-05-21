<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile as File;
use Illuminate\Support\Facades\Storage;

trait FileHelper
{

    public function setAvatarStore(File $file, int $id, string $folder): string
    {
        $filename = date('Y_m_d_H_m_s');
        $extension = $file->getClientOriginalExtension();
        $nameLast = $id.'/'.$filename.'.'.$extension;
        $file->storeAs($folder, $nameLast, 'public');
        return $nameLast;
    }
    public function setDocOrAudio(File $file, string $type, string $source, string $folder): string
    {
        $filename = date('Y_m_d_H_m_s');
        $extension = $file->getClientOriginalExtension();
        $nameLast = $type.'/'.$source.'/'.$filename.'.'.$extension;
        $file->storeAs($folder, $nameLast,'public');
        return $nameLast;
    }
    public function getNameFile(string $url):string
    {
        // $parseUrl = parse_url($url);
        // $path = ltrim($parseUrl['path'], 'storage/');
        $str = explode('storage',$url);
        $nameFile = end($str);
        // $test = Storage::disk('public')->exists($nameFile);
        return $nameFile;
    }

}
