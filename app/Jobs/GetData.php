<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class GetData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $allowedFiles = [
            "/xml/SyncCatalog.xml.gz",
            "/xml/SyncItemMaster.xml.gz",
            "/xml/SyncPartyMaster.xml.gz",
            "/xml/SyncProductRelationship.xml.gz"
        ];
    
        collect($allowedFiles)->each(function($file) {
            if(Storage::disk('sftp')->exists($file)) {
                Storage::put($file, Storage::disk('sftp')->get($file));
            }
        })->each(function($file) {
            $this->readGZ(storage_path('app' . $file));
        });
        
        dispatch(new \App\Jobs\ParseItemMaster());
        dispatch(new \App\Jobs\ParsePartyMaster());
        dispatch(new \App\Jobs\ParseCatalog());
    }

    private function readGZ($file_name) {
        $buffer_size = 4096;
        $out_file_name = str_replace('.gz', '', $file_name); 

        $file = gzopen($file_name, 'rb');
        $out_file = fopen($out_file_name, 'wb'); 
        
        while (!gzeof($file)) {
            fwrite($out_file, gzread($file, $buffer_size));
        }

        fclose($out_file);
        gzclose($file);
    }
}
