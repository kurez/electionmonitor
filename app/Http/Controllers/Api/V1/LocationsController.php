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

     /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchPolling()
    {
        
        try {
            return $results = DB::select('select p.polling_name,p.id, w.ward_name, c.constituency_name, b.county_name  FROM polling AS p INNER JOIN ward AS w ON p.ward_id=w.id INNER JOIN constituency AS c ON p.constituency_id=c.id INNER JOIN county AS b ON c.county_id=b.id ORDER BY county_name LIMIT 500;');
            // return $results = DB::select('select p.polling_name, w.ward_name FROM polling AS p INNER JOIN ward AS w ON p.ward_id=w.id INNER JOIN consituency AS c ON p.constituency_id=c.id ORDER BY polling_name;');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());

            return response()->json(['message' => 'Sorry, something went wrong!'], 422);
        }
    }

}
