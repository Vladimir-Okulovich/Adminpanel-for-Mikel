<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Models\Participant;
use App\Models\Club;
use App\Models\Sex;
use App\Http\Controllers\Controller;
use Validator;

class ParticipantController extends Controller
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
        $participants = Participant::all();
        foreach ($participants as $participant) {
            $participant->sex;
            $participant->club;
        }
        return response()->json([
            'message' => 'success',
            'participants' => $participants
        ], 200);
    }

    /**
     * Response one data by id
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getById(Request $request, $participantId)
    {
        $participant = Participant::find($participantId);
        $participant->sex;
        $participant->club;
        return response()->json([
            'message' => 'success',
            'participant' => $participant
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
            'surname' => 'required|string',
            'dni_ficha' => 'required|string',
            'birthday' => 'required',
            'sex' => 'required|string',
            'club' => 'required',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $sex = Sex::where('name', $request->sex)->first();
        $club = Club::where('name', $request->club)->first();
        $participant = new Participant;
        $participant->name = $request->name;
        $participant->surname = $request->surname;
        $participant->dni_ficha = $request->dni_ficha;
        $participant->birthday = $request->birthday;
        $participant->sex()->associate($sex);
        $participant->club()->associate($club);
        $participant->save();

        return response()->json([
            'message' => 'Participant successfully registered',
            'participant' => $participant
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
        // Update participant
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:1,100',
            'surname' => 'required|string',
            'dni_ficha' => 'required|string',
            'birthday' => 'required',
            'sex' => 'required|string',
            'club' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        
        $sex = Sex::where('name', $request->sex)->first();
        $club = Club::where('name', $request->club)->first();
        var_dump($club);
        $participant = Participant::find($request->id);
        $participant -> update([
            'name' => $request->name,
            'surname' => $request->surname,
            'dni_ficha' => $request->dni_ficha,
            'birthday' => $request->birthday,
            'sex_id' => $sex->id,
            'club_id' => $club->id,
        ]);

        return response()->json([
            'message' => 'Participant successfully updated',
            'participant' => $participant
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $participantId)
    {
        //delete participant
        $participant = Participant::find($participantId);
        $participant -> delete();
        $participants = Participant::all();
        foreach ($participants as $participant) {
            $participant->sex;
            $participant->club;
        }

        return response()->json([
            'message' => 'success',
            'participants' => $participants
        ], 200);
    }
}
