<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Ranking;
use App\Models\Ranking_position_point;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class RankingPointsController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth:api', ['except' => []]);
    }
    /**
     * Response all data
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        $all_ranking_points = Ranking_position_point::all();
        foreach ($all_ranking_points as $ranking_points) {
            $ranking_points->ranking;
        }
        return response()->json([
            'message' => 'success',
            'all_ranking_points' => $all_ranking_points
        ], 200);
    }

    /**
     * Response one data by id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getById(Request $request, $ranking_pointsId)
    {
        $ranking_points = Ranking_position_point::find($ranking_pointsId);
        $ranking_points->ranking;
        return response()->json([
            'message' => 'success',
            'ranking_points' => $ranking_points,
        ], 200);
    }

    /**
     * Create new data
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:1,100',
            'description' => 'required|max:1000',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $ranking_points = Ranking_position_point::create(array_merge(
            $validator->validated(),
        ));
        return response()->json([
            'message' => 'ranking_points successfully registered',
            'ranking_points' => $ranking_points
        ], 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // Update ranking_points
        $request->validate([
            'name' => 'required|string|between:1,100',
            'description' => 'required|max:1000',
        ]);
        $ranking_points = Ranking_position_point::find($request->id);
        $ranking_points -> update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return response()->json([
            'message' => 'ranking_points successfully updated',
            'ranking_points' => $ranking_points
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $ranking_pointsId)
    {
        //delete ranking_points
        $ranking_points = Ranking_position_point::find($ranking_pointsId);
        $ranking_points -> delete();
        $all_ranking_points = Ranking_position_point::all();
        foreach ($all_ranking_points as $ranking_points) {
            $ranking_points->ranking;
        }
        return response()->json([
            'message' => 'successfully deleted',
            'all_ranking_points' => $all_ranking_points
        ], 200);
    }
}
