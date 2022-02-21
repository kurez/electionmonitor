<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;

/**
 * To Do Controller.
 */
class LocationsController extends APIController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchCounty()
    {
        try {
            return $results = DB::select('select county_name from county');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());

            return response()->json(['message' => 'Sorry, something went wrong!'], 422);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchConstituency()
    {
        try {
            return $results = DB::select('select constituency_name from constituency');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());

            return response()->json(['message' => 'Sorry, something went wrong!'], 422);
        }
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchWard()
    {
        try {
            return $results = DB::select('select ward_name from ward');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());

            return response()->json(['message' => 'Sorry, something went wrong!'], 422);
        }
    }

}
