<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile as File;

trait FileHelper
{

    public function setFileStore(File $file, int $id, string $folder)
    {
        $filename = date('Y_m_d_H_m_s');
        $extension = $file->getClientOriginalExtension();
        $nameLast = $id.'/'.$filename.'.'.$extension;
        $file->storeAs($folder, $nameLast);
        return $nameLast;
    }

}
