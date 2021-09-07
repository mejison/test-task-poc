<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Party;

class ParsePartyMaster implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $path;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $path = "/xml/SyncPartyMaster.xml")
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
            $dataArea = $xml->children('http://www.ussco.com/oagis/0');
            $index = 0;
            foreach($dataArea as $master) {
                $node = $master->PartyMaster->children('http://www.openapplications.org/oagis/9');
                if (empty($data[$index])) {
                    $data[$index] = [];
                }

                $data[$index]['PartyIDs'] = [
                    'ID' => "" . $node->PartyIDs->ID,
                ];
                $data[$index]['Name'] = "" . $node->Name;
                $data[$index]['ChildParty'] = $this->parseChildParty($master->PartyMaster->ChildParty);
                $data[$index]['PartnerRoleCodes'] = $this->parsePartnerRoleCodes($node->PartnerRoleCodes);
                $data[$index]['VendorShortName'] = "" . $master->PartyMaster->VendorShortName;
                $data[$index]['VendorAbbreviation'] = "" . $master->PartyMaster->VendorAbbreviation;
                $index ++;
            }

            $this->storeToDB($data);
        }
    }

    private function storeToDB($data) {
        collect($data)->each(function($item) {
           Party::create([
               'PartyIDs' => $item['PartyIDs'],
               'Name' => $item['Name'],
               'ChildParty' => $item['ChildParty'],
               'PartnerRoleCodes' => $item['PartnerRoleCodes'],
               'VendorShortName' => $item['VendorShortName'],
               'VendorAbbreviation' => $item['VendorAbbreviation'],
           ]);
        });
    }

    private function parsePartnerRoleCodes($node) {
        $data = [];
        foreach($node->Code as $code) {
            $data[] = [
                'value' => "" . $code,
                'name' => "" . ($code->Attributes() ? $code->Attributes()['name'] : ''),
            ];
        }
        return $data;
    }

    private function parseChildParty($node) {
        $node = $node->children('http://www.openapplications.org/oagis/9');
        return [
            'PartyIDs' => [
                'ID' => "" . $node->PartyIDs->ID,
            ],
            'Name' => "" . $node->Name,
            'Attachment' => [
                'FileName' => "" . $node->Attachment->FileName
            ],
        ];
    }
}
