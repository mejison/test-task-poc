<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AuthSignUpRequest;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Client;

class AuthController extends Controller
{
    public function signup(AuthSignUpRequest $reqeust) {
        $data = $reqeust->all();
        list($latitude, $longitude) = $this->getCoordinatesByAddress($data['city'] . ',' . $data['country']);
        $data['latitude'] = $latitude;
        $data['longitude'] = $longitude;

        DB::beginTransaction();
        try {
            $data['end_validity'] = now()->add('day', 15);
            $client = Client::create($data);
            $client->save();
            $client->user()->create(collect($data['user'])->merge(['client_id' => $client->id])->all());
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage(), 'status' => 'error']);
        }
        return response()->json(['message' => 'Successfuly created.', 'status' => 'success']);
    }

    private function getCoordinatesByAddress($address) {
        $latitude = 0;
        $longitude = 0;

        $results = app("geocoder")
            // ->doNotCache()
            ->geocode($address)
            ->get();

        if( ! empty($results)) {
            $result = $results->first();
            $coordinates = $result->getCoordinates();
            $latitude = $coordinates->getLatitude();
            $longitude = $coordinates->getLongitude();
        }

        return [
            $latitude,
            $longitude
        ];
    }
}
