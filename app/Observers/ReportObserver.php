<?php

namespace App\Observers;

use App\Helpers\FileHelper;
use App\Models\Report;
use Illuminate\Support\Facades\Storage;

class ReportObserver
{
    use FileHelper;
    /**
     * Handle the Report "created" event.
     */
    public function created(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "updated" event.
     */
    public function updated(Report $report): void
    {
        if($report->isDirty('document') && $report->getOriginal('document')){
            $file = $this->getNameFile($report->getOriginal('document'));
            Storage::disk('public')->delete($file);
        }
        if($report->isDirty('audio') && $report->getOriginal('audio')){
            $file = $this->getNameFile($report->getOriginal('audio'));
            Storage::disk('public')->delete($file);

        }
    }

    /**
     * Handle the Report "deleted" event.
     */
    public function deleted(Report $report): void
    {
        if($report->isDirty('document')){
            $file = $this->getNameFile($report->getOriginal('document'));
            Storage::disk('public')->delete($file);
        }
        if($report->isDirty('audio')){
            $file = $this->getNameFile($report->getOriginal('audio'));
            Storage::disk('public')->delete($file);

        }
    }

    /**
     * Handle the Report "restored" event.
     */
    public function restored(Report $report): void
    {
        //
    }

    /**
     * Handle the Report "force deleted" event.
     */
    public function forceDeleted(Report $report): void
    {
        // if($report->isDirty('document')){
        //     if(Storage::disk('public')->exists($report->document))

        // }
    }
}
