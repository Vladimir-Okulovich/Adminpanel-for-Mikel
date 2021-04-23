<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use App\Models\Sex;
use App\Models\Club;
use Illuminate\Support\Facades\DB;
use App\Models\Modality;
use App\Models\Participant;
use App\Models\Heat_configuration;
use App\Models\Com_cat_mod_participant;
use App\Models\Heat_score;
use App\Models\Round_heat;
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

    public function createFirstCompetitionBoxes(Request $request)
    {
        $com_cat_mod_participants = Com_cat_mod_participant::where('competition_id', $request->competitionId)
                                                            ->where('category_id', $request->categoryId)
                                                            ->where('modality_id', $request->modalityId)->get();
        $round_heats = Round_heat::where('com_cat_mod_participant_id', $com_cat_mod_participants[0]->id)->where('round', 1)->get();
        if (count($round_heats) == 0) {
            $heat_configuration = Heat_configuration::where('participant_number', count($com_cat_mod_participants))->first();
            $s = 0;
            foreach ($heat_configuration->assign_array as $index => $heat_items) {
                for ($i = 1; $i <= $heat_items; $i++) {
                    $round_heat = new Round_heat;
                    $round_heat->round = 1;
                    $round_heat->heat = $index + 1;
                    $round_heat->com_cat_mod_participant_id = $com_cat_mod_participants[$s]->id;
                    $round_heat->save();
                    $s++;
                }
            }
            return response()->json([
                'message' => 'success',
            ], 200);
        }
    }

    public function initCompetitionHeats(Request $request)
    {
        $com_cat_mod_participant_ids = Com_cat_mod_participant::select('id')->where('competition_id', $request->competitionId)
                                                            ->where('category_id', $request->categoryId)
                                                            ->where('modality_id', $request->modalityId)->get();

        $all_round_heats = [];
        for ($i=1; ;$i++) {
            $array_rounds = [];
            $round_heats = Round_heat::whereIn('com_cat_mod_participant_id', $com_cat_mod_participant_ids)->where('round', $i)->get();
            if (count($round_heats) > 0) {
                for ($j=1; ;$j++) {
                    $array_heats = [];
                    $round_heats = Round_heat::whereIn('com_cat_mod_participant_id', $com_cat_mod_participant_ids)->where('round', $i)->where('heat', $j)->get();
                    if (count($round_heats) > 0) {
                        foreach ($round_heats as $round_heat) {
                            $round_heat->com_cat_mod_participant->participant;
                            $round_heat->com_cat_mod_participant->competition;
                            $round_heat->com_cat_mod_participant->category->sex;
                            $round_heat->com_cat_mod_participant->modality;
                            array_push($array_heats, $round_heat);
                        }
                    } else {
                        break;
                    }
                    array_push($array_rounds, $array_heats);
                }
            } else {
                break;
            }
            array_push($all_round_heats, $array_rounds);
        }

        return response()->json([
            'message' => 'success',
            'all_round_heats' => $all_round_heats,
        ], 200);
    }

    public function setProgressStatus(Request $request)
    {
        $com_cat_mod_participant_ids = Com_cat_mod_participant::select('id')->where('competition_id', $request->competitionId)
                                                            ->where('category_id', $request->categoryId)
                                                            ->where('modality_id', $request->modalityId)->get();
        $affected = Round_heat::whereIn('com_cat_mod_participant_id', $com_cat_mod_participant_ids)
                                ->where('round', $request->round)
                                ->where('heat', $request->heat)
                                ->update(['status' => 3]);
        return response()->json([
            'message' => 'success',
            'affected' => $affected,
        ], 200);
    }

    public function initHeatDetails(Request $request)
    {
        $com_cat_mod_participant_ids = Com_cat_mod_participant::select('id')->where('competition_id', $request->competitionId)
                                                            ->where('category_id', $request->categoryId)
                                                            ->where('modality_id', $request->modalityId)->get();
        $round_heats = Round_heat::whereIn('com_cat_mod_participant_id', $com_cat_mod_participant_ids)
                                ->where('round', $request->round)
                                ->where('heat', $request->heat)->get();
        foreach ($round_heats as $round_heat) {
            $round_heat->com_cat_mod_participant->participant;
            $round_heat->com_cat_mod_participant->competition;
            $round_heat->com_cat_mod_participant->category->sex;
            $round_heat->com_cat_mod_participant->modality;
        }
        return response()->json([
            'message' => 'success',
            'round_heats' => $round_heats,
        ], 200);
    }
}
