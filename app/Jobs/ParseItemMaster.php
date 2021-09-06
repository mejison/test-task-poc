<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Item;

class ParseItemMaster implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $path;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $path = "/xml/SyncItemMaster.xml")
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
        $full_path = storage_path("app" . $this->path);
        $data = [];

        if (file_exists($full_path)) {
            $xml = simplexml_load_string(file_get_contents($full_path));

            $applicationArea = $xml->children('http://www.openapplications.org/oagis/9');
            $dataArea = $xml->children('http://www.ussco.com/oagis/0');

            if ( ! empty($itemMasters = $dataArea->DataArea)) {
                $index = 0;
                foreach($itemMasters->ItemMaster as $item) {
                    if (empty($data[$index])) {
                        $data[$index] = [];
                    }
                    $data[$index]['ItemMasterHeader'] = $this->getItemMasterHeader($item->ItemMasterHeader);
                    $data[$index]['ItemLocation'] = $this->getItemLocation($item->ItemLocation);
                    $data[$index]['GlobalItem'] = $this->getGlobalItem($item->GlobalItem);
                    $data[$index]['ItemList'] = $this->getItemList($item->ItemList);
                    $data[$index]['WarrantyInfo'] = $this->getWarrantyInfo($item->WarrantyInfo);
                    $data[$index]['HUBSupplier'] = "" . $item->HUBSupplier;
                    $data[$index]['ContentQualityClassCode'] = "" . $item->ContentQualityClassCode;
                    $index ++;
                }
            }

            $this->storeToDB($data);
        }
    }

    public function storeToDB($data) {
       collect($data)->each(function($item) {
        Item::create([
            'ItemMasterHeader' => $item['ItemMasterHeader'],
            'ItemLocation' => $item['ItemLocation'],
            'GlobalItem' => $item['GlobalItem'],
            'ItemList' => $item['ItemList'],
            'WarrantyInfo' => $item['WarrantyInfo'],
            'HUBSupplier' => $item['HUBSupplier'],
            'ContentQualityClassCode' => $item['ContentQualityClassCode'],
        ]);
       });
    }

    public function getItemMasterHeader($node) {
        $freightClassification = $node->FreightClassification->children('http://www.openapplications.org/oagis/9');
        $itemMasterHeader = $node->children('http://www.openapplications.org/oagis/9');
        $packaging = $node->Packaging->children('http://www.openapplications.org/oagis/9');
        $manufacturerItemID = $itemMasterHeader->ManufacturerItemID->children('http://www.openapplications.org/oagis/9');
        
        $itemIds = [];
        foreach($itemMasterHeader->ItemID as $itemId) {
            $itemIds[] = "" . $itemId->ID;
        }

        return [
            'ItemID' => $itemIds,
            'ManufacturerItemID' => [
                'schemeAgencyName' => '' . $manufacturerItemID->Attributes()['schemeAgencyName'],
                'schemeAgencyID' => '' . $manufacturerItemID->Attributes()['schemeAgencyID'],
                'value' => '' . $itemMasterHeader->ManufacturerItemID->ID
            ],
            'Packaging' => [
                'ID' => '' . $packaging->ID,
                'PerPackageQuantity' => '' . $packaging->PerPackageQuantity,
            ],
            'ItemStatus' => [
                'Code' => '' . $itemMasterHeader->ItemStatus->Code,
            ],
            'DrawingAttachment' => [
                'FileName' => '' . $itemMasterHeader->DrawingAttachment->FileName,
            ],
            'Attachment' => [
                'FileName' => '' . $itemMasterHeader->Attachment->FileName,
            ],
            'FreightClassification' => [
                'Codes' => [
                    'Code' => [
                        'sequence' => "" . ($freightClassification->Codes->Code->Attributes() ? $freightClassification->Codes->Code->Attributes()['sequence'] : ''),
                        'name' => "" . ($freightClassification->Codes->Code->Attributes() ? $freightClassification->Codes->Code->Attributes()['name'] : ''),
                        'value' => "" . $freightClassification->Codes->Code,
                    ]
                ]
            ],
            'Keywords' => "" . $node->Keywords,
            'BrandId' => "" . $node->BrandId,
        ];
    }

    public function getItemLocation($node) {
        $packaging = $node->Packaging->children('http://www.openapplications.org/oagis/9');
        $dimensions = $node->Packaging->Dimensions->children('http://www.openapplications.org/oagis/9');

        $unitPackaging = $node->UnitPackaging->children('http://www.openapplications.org/oagis/9');
        $unitDimensions = $node->UnitPackaging->Dimensions->children('http://www.openapplications.org/oagis/9');

        $codes = $node->Classification->Codes->children('http://www.openapplications.org/oagis/9');

        return [
            'Classification' => [
                'type' => "" . ($node->Classification->Attributes() ? $node->Classification->Attributes()['type'] : ''),
                'Codes' => [
                    'Code' => [
                        'sequence' => '' . ($codes->Code->Attributes() ? $codes->Code->Attributes()['sequence'] : ''),
                        'value' => '' . $codes->Code,
                    ]
                ]
            ],
            'Packaging' => [
                'ID' => "" . $packaging->ID,
                'Dimensions' => [
                    'WidthMeasure' => [
                        'unitCode' => "" . ($dimensions->WidthMeasure->Attributes() ? $dimensions->WidthMeasure->Attributes()['unitCode'] : ''),
                        'value' => '' . $dimensions->WidthMeasure,
                    ],
                    'LengthMeasure' => [
                        'unitCode' => "" . ($dimensions->LengthMeasure->Attributes() ? $dimensions->LengthMeasure->Attributes()['unitCode'] : ''),
                        'value' => '' . $dimensions->LengthMeasure,
                    ],
                    'HeightMeasure' => [
                        'unitCode' => "" . ($dimensions->HeightMeasure->Attributes() ? $dimensions->HeightMeasure->Attributes()['unitCode'] : ''),
                        'value' => '' . $dimensions->HeightMeasure,
                    ],
                    'Weight' => [
                        'unitCode' => "" . ($node->Packaging->Dimensions->Weight->Attributes() ? $node->Packaging->Dimensions->Weight->Attributes()['unitCode'] : ''),
                        'value' => "" . $node->Packaging->Dimensions->Weight,
                    ],
                    'WeightMeasure' => [
                        'unitCode' => "" . ($node->Packaging->Dimensions->WeightMeasure->Attributes() ? $node->Packaging->Dimensions->WeightMeasure->Attributes()['unitCode'] : ''),
                        'value' => "" . $node->Packaging->Dimensions->WeightMeasure,
                    ],
                ],
                'PerPackageQuantity' => [
                    'unitCode' => "" . ($packaging->PerPackageQuantity->Attributes() ? $packaging->PerPackageQuantity->Attributes()['unitCode'] : ''),
                    'value' => "" . $packaging->PerPackageQuantity,
                ]
            ],
            'UnitPackaging' => [
                'ID' => "" . $unitPackaging->ID,
                'Dimensions' => [
                    'WidthMeasure' => [
                        'unitCode' => "" . ($unitDimensions->WidthMeasure->Attributes() ? $unitDimensions->WidthMeasure->Attributes()['unitCode'] : ''),
                        'value' => '' . $unitDimensions->WidthMeasure,
                    ],
                    'LengthMeasure' => [
                        'unitCode' => "" . ($unitDimensions->LengthMeasure->Attributes() ? $unitDimensions->LengthMeasure->Attributes()['unitCode'] : ''),
                        'value' => '' . $unitDimensions->LengthMeasure,
                    ],
                    'HeightMeasure' => [
                        'unitCode' => "" . ($unitDimensions->HeightMeasure->Attributes() ? $unitDimensions->HeightMeasure->Attributes()['unitCode'] : ''),
                        'value' => '' . $unitDimensions->HeightMeasure,
                    ],
                    'WeightMeasure' => [
                        'unitCode' => "" . ($node->UnitPackaging->Dimensions->WeightMeasure->Attributes() ? $node->UnitPackaging->Dimensions->WeightMeasure->Attributes()['unitCode'] : ''),
                        'value' => "" . $node->UnitPackaging->Dimensions->WeightMeasure,
                    ],
                ],
                'PerPackageQuantity' => [
                    'unitCode' => "" . ($unitPackaging->PerPackageQuantity->Attributes() ? $unitPackaging->PerPackageQuantity->Attributes()['unitCode'] : ''),
                    'value' => "" . $unitPackaging->PerPackageQuantity,
                ]
            ],
        ];
    }

    public function getItemList($node) {
        return [
            "CountryCode" => "" . $node->CountryCode,
            "ListStartDate" => "" . $node->ListStartDate,
            "ListEndDate" => "" . $node->ListEndDate,
            "FacilityNumber" => "" . $node->FacilityNumber,
            "VendorNumber" => "" . $node->VendorNumber,
            "VendorShortName" => "" . $node->VendorShortName,
            "ListAmount" => [
                "currencyID" => "" . ($node->ListAmount->Attributes() ? $node->ListAmount->Attributes()['currencyID'] : ''),
                "value" => "" . "" . $node->ListAmount,
            ],
            "ListUnitCode" => "" . $node->ListUnitCode,
        ];
    }

    public function getWarrantyInfo($node) {
        return [
            'WarrantyIndicator' => "" . $node->WarrantyIndicator,
        ];
    }

    public function getGlobalItem($node) {
        return [
            "InventoryUnitCode" => "" .$node->InventoryUnitCode,
            "ItemWeight"  =>  [
                "unitCode"  =>  "" . ($node->ItemWeight->Attributes() ? $node->ItemWeight->Attributes()['unitCode'] : ''),
                "ItemWeight"  =>  "" . $node->ItemWeight,
            ],
            "ItemDimensions" => (function() use ($node) {
                $dimensions = $node->ItemDimensions->children('http://www.openapplications.org/oagis/9');

                return [
                    'WidthMeasure' => [
                        'unitCode' => "" . ($dimensions->WidthMeasure->Attributes() ? $dimensions->WidthMeasure->Attributes()['unitCode'] : ''),
                        'value' => "" . $dimensions->WidthMeasure
                    ],
                    'LengthMeasure' => [
                        'unitCode' => "" . ($dimensions->LengthMeasure->Attributes() ? $dimensions->LengthMeasure->Attributes()['unitCode'] : ''),
                        'value' => "" . $dimensions->LengthMeasure
                    ],
                    'HeightMeasure' => [
                        'unitCode' => "" . ($dimensions->HeightMeasure->Attributes() ? $dimensions->HeightMeasure->Attributes()['unitCode'] : ''),
                        'value' => "" . $dimensions->HeightMeasure
                    ],
                    'WeightMeasure' => [
                        'unitCode' => "" . ($node->ItemDimensions->WeightMeasure->Attributes() ? $node->ItemDimensions->WeightMeasure->Attributes()['unitCode'] : ''),
                        'value' => "" . $node->ItemDimensions->WeightMeasure
                    ],
                ];
            })(),
            "GTINItem"  =>  "" . $node->GTINItem,
            "GTINCarton"  =>  "" . $node->GTINCarton,
            "GTINBox"  =>  "" . $node->GTINBox,
            "GTINPallet"  =>  "" . $node->GTINPallet,
            "UPCRetail"  =>  "" . $node->UPCRetail,
            "UPCCarton"  =>  "" . $node->UPCCarton,
            "CountryOriginCode"  =>  "" . $node->CountryOriginCode,
        ];
    }
}
