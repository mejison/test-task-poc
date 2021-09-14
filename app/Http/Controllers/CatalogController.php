<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Catalog;
use App\Http\Resources\CatalogResource;

class CatalogController extends Controller
{
    public function all(Request $request) {
        $catalogs = Catalog::query()->with(['items' => function($q) {
            $q->take(100);
        }]);
        return response()->json(new CatalogResource($catalogs->paginate()));
    }

    public function one(Catalog $catalog) {
        return response()->json($catalog->load(['items' => function($q) {
            $q->take(100);
        }]));
    }

    public function update(Catalog $catalog, Request $reqeust) {
        $catalog->update(
            ...$request->all()
        );

        return response()->json([
            'data' => $catalog,
            'message' => 'Successfully updated.'
        ]);
    }

    public function delete(Catalog $catalog) {
        $catalog->delete();

        return response()->json([
            'message' => 'Successfully deleted.'
        ]);
    }
}
