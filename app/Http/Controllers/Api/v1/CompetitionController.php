<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Competition;
use App\Models\Competition_type;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class CompetitionController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
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
        $competitions = Competition::all();
        foreach ($competitions as $competition) {
            $competition->competition_type;
            $competition->status;
        }
        return response()->json([
            'message' => 'success',
            'competitions' => $competitions
        ], 200);
    }

    /**
     * Response one data by id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getById(Request $request, $competitionId)
    {
        $competition = competition::find($competitionId);
        $competition->competition_type;
        $competition->status;
        return response()->json([
            'message' => 'success',
            'competition' => $competition,
        ], 200);
    }

    /**
     * Create new data
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|between:1,100',
            'competition_type' => 'required|string',
            'description' => 'required|string',
            'place' => 'required|string',
            'date' => 'required',
            'time' => 'required',
            'ranking_score' => 'required',
            'status' => 'required',
            'lycra' => 'required',
            'modality' => 'required',
            'category' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if($request->file('logo')){
            $result = $request->file('logo')->store('public');
        } else {
            $result = null;
        }

        $competition_type = Competition_type::where('name', $request->competition_type)->first();
        $status = Status::where('name', $request->status)->first();

        $competition = new Competition;
        $competition->title = $request->title;
        $competition->description = $request->description;
        $competition->place = $request->place;
        $competition->date = $request->date;
        $competition->time = $request->time;
        $competition->ranking_score = $request->ranking_score;
        $competition->competition_type()->associate($competition_type);
        $competition->status()->associate($status);
        $competition->logo = $result;
        $competition->save();

        return response()->json([
            'message' => 'Participant successfully registered',
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
        //
        //
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|between:1,100',
            'competition_type' => 'required|string',
            'description' => 'required|string',
            'place' => 'required|string',
            'date' => 'required',
            'time' => 'required',
            'ranking_score' => 'required',
            'status' => 'required',
            'lycra' => 'required',
            'modality' => 'required',
            'category' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        if($request->file('logo')){
            $result = $request->file('logo')->store('public');
        } else {
            $result = null;
        }

        $competition_type = Competition_type::where('name', $request->competition_type)->first();
        $status = Status::where('name', $request->status)->first();

        $competition = Competition::find($request->id);
        $competition -> update([
            'title' => $request->title,
            'description' => $request->description,
            'place' => $request->place,
            'date' => $request->date,
            'time' => $request->time,
            'ranking_score' => $request->ranking_score,
            'competition_type_id' => $competition_type->id,
            'status_id' => $status->id,
            'logo' => $result,
        ]);

        return response()->json([
            'message' => 'Participant successfully updated',
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $competitionId)
    {
        //delete competition
        $competition = Competition::find($competitionId);
        $competition -> delete();
        $competitions = Competition::all();
        foreach ($competitions as $competition) {
            $competition->competition_type;
            $competition->status;
        }
        return response()->json([
            'message' => 'successfully deleted',
            'competitions' => $competitions
        ], 200);
    }
}
