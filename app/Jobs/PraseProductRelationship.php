<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\ProductRelationship;
use Illuminate\Support\Facades\DB;

class PraseProductRelationship implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $path = "/xml/SyncProductRelationship.xml")
    {
        $this->path = $path;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);

        $full_path = storage_path("app" . $this->path);
        $data = [];
        
        DB::beginTransaction();

        try {
            if (file_exists($full_path)) {
                $xml = simplexml_load_string(file_get_contents($full_path));
                $dataArea = $xml->children('http://www.ussco.com/oagis/0');
                
                $index = 0;
                foreach($dataArea->DataArea->ProductRelationship as $productRelationship) {
                    $data[$index] = [
                        'MPN' =>  "" . $productRelationship->MPN,
                        'PrefixNumber' => "" . $productRelationship->PrefixNumber,
                        'StockNumberButted' => trim("" . $productRelationship->StockNumberButted),
                        'Relationship' => [
                            'Name' => "" . $productRelationship->Name,
                            'RelationshipMember' => json_decode(json_encode($productRelationship->Relationship), true)
                        ]
                    ];
                    
                    $index ++;
                }
            }
        
            ProductRelationship::truncate();
            collect($data)->each(function($item) {
                ProductRelationship::create($item);
            });

            DB::commit();

            return true;
        } catch (\Exception $e) {
            DB::rollback();
            return false;
        }

        return true;
    }
}
