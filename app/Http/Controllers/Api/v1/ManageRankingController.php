<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use App\Models\Sex;
use Illuminate\Support\Facades\DB;
use App\Models\Modality;
use App\Models\Participant;
use App\Models\Competition_ranking_result;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class ManageRankingController extends Controller
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
    public function getAllCategoryModality()
    {
        $all_category_modality = [];
        $categories = Category::all();
        $modalities = Modality::all();
        foreach ($categories as $category) {
            $category->sex;
            foreach ($modalities as $modality) {
                array_push($all_category_modality, (object)[
                    'category' => $category->name,
                    'sex' => $category->sex->name,
                    'modality' => $modality->name,
                ]);
            }
        }
        return response()->json([
            'message' => 'success',
            'all_category_modality' => $all_category_modality
        ], 200);
    }

    public function getAllRankingData(Request $request) {
        $all_ranking_data = [];

        $modality = Modality::where('name', $request->modality)->first();
        $sex = Sex::where('name', $request->sex)->first();
        $category = Category::where('name', $request->category)->where('sex_id', $sex->id)->first();
        $category->competitions;
        foreach ($category->competitions as $competition) {
            $temp = DB::table('modality_competition')->where('competition_id', $competition->id)->where('modality_id', $modality->id)->get();
            // array_push($all_ranking_data, $competition);
            if (count($temp) == 0) {
                echo("false");
            } else {
                echo("true");
            }
        }
        return response()->json([
            'message' => 'success',
            'all_ranking_data' => $temp
        ], 200);
    }

    public function participantCreate(Request $request) {
        $participant = Participant::where('dni_ficha', $request->dni_ficha)->get();
        if (count($participant) == 0) {
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

            $categories = [];
            foreach ($request->modality as $modality) {
                foreach ($categories as $category) {
                    $competition_ranking_result = new Competition_ranking_result;
                    $competition_ranking_result->competition_id = $request->competitionId;
                    $competition_ranking_result->participant_id = $participant->id;
                    $competition_ranking_result->modality_id = $modality->id;
                    $competition_ranking_result->category = $category->id;
                    $competition_ranking_result->save();
                }
            }

            return response()->json([
                'message' => 'success',
                'participant' => $participant
            ], 200);
        } else {
            $categories = [];
            foreach ($request->modality as $modality) {
                foreach ($categories as $category) {
                    $competition_ranking_result = new Competition_ranking_result;
                    $competition_ranking_result->competition_id = $request->competitionId;
                    $competition_ranking_result->participant_id = $participant->id;
                    $competition_ranking_result->modality_id = $modality->id;
                    $competition_ranking_result->category = $category->id;
                    $competition_ranking_result->save();
                }
            }
            
            return response()->json([
                'message' => 'success',
                'participant' => $participant
            ], 200);
        }
    }
}
