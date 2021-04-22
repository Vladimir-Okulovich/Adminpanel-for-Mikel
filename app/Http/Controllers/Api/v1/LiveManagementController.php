<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use App\Models\Sex;
use App\Models\Club;
use Illuminate\Support\Facades\DB;
use App\Models\Modality;
use App\Models\Participant;
use App\Models\Com_cat_mod_participant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

class LiveManagementController extends Controller
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
    public function getParticipantsByCompetitionCategoryModality(Request $request)
    {
        $participants = [];
        $str = explode(" ", $request->categoryModality);
        $sex = Sex::where('name', $str[1])->first();
        $category = Category::where('name', $str[0])->where('sex_id', $sex->id)->first();
        $modality = Modality::where('name', $str[2].' '.$str[3])->first();
        $temps = Com_cat_mod_participant::where('competition_id', $request->competitionId)
                                          ->where('category_id', $category->id)
                                          ->where('modality_id', $modality->id)->get();
        foreach ($temps as $temp) {
            $participant = Participant::find($temp->participant_id);
            $participant->club;
            $participant->sex;
            array_push($participants, $participant);
        }
        return response()->json([
            'message' => 'success',
            'participants_competition_category_modality' => $participants,
            'category_id' => $category->id,
            'modality_id' => $modality->id
        ], 200);
    }

    public function unregistParticipantToCompetitionCategoryModality(Request $request)
    {
        $str = explode(" ", $request->categoryModality);
        $sex = Sex::where('name', $str[1])->first();
        $category = Category::where('name', $str[0])->where('sex_id', $sex->id)->first();
        $modality = Modality::where('name', $str[2].' '.$str[3])->first();

        $deleteRows = Com_cat_mod_participant::where('competition_id', $request->competitionId)
                                    ->where('participant_id', $request->participantId)
                                    ->where('category_id', $category->id)
                                    ->where('modality_id', $modality->id)
                                    ->delete();
        $participants = [];
        $temps = Com_cat_mod_participant::where('competition_id', $request->competitionId)
                                          ->where('category_id', $category->id)
                                          ->where('modality_id', $modality->id)->get();
        foreach ($temps as $temp) {
            $participant = Participant::find($temp->participant_id);
            $participant->club;
            $participant->sex;
            array_push($participants, $participant);
        }
        return response()->json([
            'message' => 'Successfully unregistered a participant to a competition',
            'participants_competition_category_modality' => $participants
        ], 200);
    }
}
