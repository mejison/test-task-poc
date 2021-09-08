<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Catalog;
use App\Models\CatalogItem;

class ParseCatalog implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $path = "/xml/SyncCatalog.xml")
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

        if (file_exists($full_path)) {
            $xml = simplexml_load_string(file_get_contents($full_path));

            $index = 0;
            foreach($xml->DataArea->Catalog as $catalog) {
                if (empty($data[$index])) {
                    $data[$index] = [];
                }

                $data[$index] = [
                    'Name' => "" . $catalog->CatalogHeader->Name,
                    'DocumentID' => "" . $catalog->CatalogHeader->DocumentID->ID,
                    'ClassificationScheme' => [
                        'ClassificationSchemeID' => [
                            'schemeName' => "" . $catalog->CatalogHeader->ClassificationScheme->ClassificationSchemeID->Attributes()['schemeName'],
                            'value' => "" . $catalog->CatalogHeader->ClassificationScheme->ClassificationSchemeID,
                        ],
                    ],
                    'CatalogLine' => $this->parseCatalogLine($catalog->CatalogLine),
                ];
                $index ++;
            }
            
            $this->storeToDB($data);
        }
        
        dispatch(new \App\Jobs\PraseProductRelationship());
        return true;
    }

    private function storeToDB($catalogs) {
        Catalog::truncate();

        collect($catalogs)->each(function($catalog) {
            $cat = Catalog::create([
                'Name' => $catalog['Name'],
                'DocumentID' => $catalog['DocumentID'],
                'ClassificationScheme' => $catalog['ClassificationScheme'],
            ]);
            

            collect($catalog['CatalogLine'])->each(function($line) use ($cat) {
                $cat->items()->create([
                    'Item' => $line['Item'],
                    'UOMCode' => $line['UOMCode'],
                    'ItemPrice' => $line['ItemPrice'],
                    'Note' => $line['Note']
                ]);
            });
        });
    }

    private function parseCatalogLine($items) {
        $data = [];
        foreach($items as $item) {
            $data[] = [
                'Item' => $this->parseItem($item->Item),
                'UOMCode' => "" . $item->UOMCode,
                'ItemPrice' => [
                    'UnitPrice' => [
                        'Amount' => [
                            'currencyID' => "" . $item->ItemPrice->UnitPrice->Amount->Attributes()['currencyID'],
                            'value' => "" . $item->ItemPrice->UnitPrice->Amount
                        ],
                        'PerQuantity' => [
                            'unitCode' => "" . $item->ItemPrice->UnitPrice->PerQuantity->Attributes()['unitCode'],
                            'value' => "" . $item->ItemPrice->UnitPrice->PerQuantity,
                        ],
                        'Code' => "" . $item->ItemPrice->UnitPrice->Code
                    ]
                ],
                'Note' => [
                    'type' => "" . $item->Note->Attributes()['type'],
                    'value' => "" . $item->Note,
                ]
            ];
        }
        return $data;
    }

    private function parseItem($items) {
        $data = [];
        foreach($items->ItemID as $item) {
            $data[] = [
                'ItemID' => [
                    'agencyRole' => "" . $item->Attributes()['agencyRole'],
                    'ID' => "" . $item->ID,
                ]
            ];
        }
        return $data;
    }
}
