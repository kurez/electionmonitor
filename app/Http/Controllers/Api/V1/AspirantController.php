<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Aspirant\Aspirant;
use Illuminate\Http\Request;
use JWTAuth;
use Validator;
use Illuminate\Support\Str;

/**
 * Task Controller.
 */
class AspirantController extends APIController
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $aspirants = Aspirant::whereNotNull('id');

            if (request()->has('full_name')) {
                $aspirants->where('full_name', 'like', '%'.request('full_name').'%');
            }

            if (request()->has('political_party')) {
                $aspirants->where('political_party', 'like', '%'.request('political_party').'%');
            }

            if (request()->has('electoral_area')) {
                $aspirants->where('electoral_area', 'like', '%'.request('electoral_area').'%');
            }

            if (request()->has('electoral_position')) {
                $aspirants->where('electoral_position', 'like', '%'.request('electoral_position').'%');
            }

            // if (request()->has('status')) {
            //     $tasks->whereStatus(request('status'));
            // }

            $aspirants->orderBy(request('sortBy'), request('order'));

            return $aspirants->paginate(request('pageLength'));
        } catch (\Exception $ex) {
            // Log::error($ex->getMessage());

            return response()->json(['message' => 'Sorry, something went wrong!'], 422);
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $validation = Validator::make($request->all(), [
                'full_name'       => 'required',
                'political_party' => 'required',
                'electoral_area' => 'required',
                'electoral_position' => 'required',
            ]);

            if ($validation->fails()) {
                return response()->json(['message' => $validation->messages()->first()], 422);
            }

            $user = JWTAuth::parseToken()->authenticate();
            $aspirant = new Aspirant();
            $aspirant->fill(request()->all());
            $aspirant->uuid = Str::uuid()->toString();
            $aspirant->user_id = $user->id;
            $aspirant->save();

            return response()->json(['message' => 'Aspirant added!', 'data' => $aspirant]);
        } catch (\Exception $ex) {
            // Log::error($ex->getMessage());

            return response()->json(['message' => 'Sorry, something went wrong!'], 422);
        }
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $id)
    {
        try {
            $aspirant = Aspirant::find($id);

            if (!$aspirant) {
                return response()->json(['message' => 'Could not find aspirant!'], 422);
            }

            $aspirant->delete();

            return response()->json(['message' => 'Aspirant deleted!']);
        } catch (\Exception $ex) {
            // Log::error($ex->getMessage());

            return response()->json(['message' => 'Sorry, something went wrong!'], 422);
        }
    }

    /**
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $aspirant = Aspirant::whereUuid($id)->first();

            if (!$aspirant) {
                return response()->json(['message' => 'Could not find aspirant!'], 422);
            }

            return $aspirant;
        } catch (\Exception $ex) {
            // Log::error($ex->getMessage());

            return response()->json(['message' => 'Sorry, something went wrong!'], 422);
        }
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $aspirant = Aspirant::whereUuid($id)->first();

            if (!$aspirant) {
                return response()->json(['message' => 'Could not find aspirant!']);
            }

            $validation = Validator::make($request->all(), [
                'full_name'       => 'required',
                'political_party' => 'required',
                'electoral_area' => 'required',
                'electoral_position' => 'required',
            ]);

            if ($validation->fails()) {
                return response()->json(['message' => $validation->messages()->first()], 422);
            }

            $aspirant->full_name = request('full_name');
            $aspirant->political_party = request('political_party');
            $aspirant->electoral_position = request('electoral_position');
            $aspirant->electoral_area = request('electoral_area');
            $aspirant->save();

            return response()->json(['message' => 'Aspirant updated!', 'data' => $aspirant]);
        } catch (\Exception $ex) {
            // Log::error($ex->getMessage());

            return response()->json(['message' => 'Sorry, something went wrong!'], 422);
        }
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function toggleStatus(Request $request)
    // {
    //     try {
    //         $task = Task::find($request->input('id'));

    //         if (!$task) {
    //             return response()->json(['message' => 'Couldnot find task!'], 422);
    //         }

    //         $task->status = !$task->status;
    //         $task->save();

    //         return response()->json(['message' => 'Task updated!']);
    //     } catch (\Exception $ex) {
    //         Log::error($ex->getMessage());

    //         return response()->json(['message' => 'Sorry, something went wrong!'], 422);
    //     }
    // }
}
