<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function all(Request $request) {
        $per_page = 15;
        $sortField = 'client_name';
        $sortType = 'asc';
        $filterField = 'client_name';
        $filterValue = '';
        $fieldsForSearching = ['client_name', 'address1', 'address2', 'city', 'state', 'country', 'phone_no1', 'phone_no2'];

        $data = $request->only(['per_page', 'sortType', 'sortField', 'filterField', 'filterValue']);
        extract($data);
        $accounts = Client::query();
        $accounts = $accounts->where(function($query) use ($filterField, $filterValue, $fieldsForSearching) {
            if ($filterValue) {
                if (in_array($filterField, $fieldsForSearching)) {
                    $query->where($filterField, 'like', '%' . $filterValue . '%');
                } else {
                    $query->where($filterField, $filterValue);
                }
            }
        });
        if (in_array($sortType, ['asc', 'desc'])) {
            $accounts = $accounts->orderBy($sortField, $sortType);
        }
        return response()->json($accounts->paginate($per_page));
    }
}
