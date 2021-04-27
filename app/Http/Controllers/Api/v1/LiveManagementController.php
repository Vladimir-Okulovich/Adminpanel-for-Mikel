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
use App\Models\Role;
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
                    $round_heat->lycra_id = $i;
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
                            $round_heat->lycra;
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
        $heat_scores = [];
        $judge_role = Role::where('name', 'Judge')->first();
        foreach ($round_heats as $round_heat) {
            $round_heat->com_cat_mod_participant->participant;
            $round_heat->com_cat_mod_participant->competition;
            $round_heat->com_cat_mod_participant->category->sex;
            $round_heat->com_cat_mod_participant->modality;
            $round_heat->lycra;

            $temps = Heat_score::where('round_heat_id', $round_heat->id)->get();
            if (count($temps) == 0) {
                foreach ($judge_role->users as $judge) {
                    $heat_score = new Heat_score;
                    $heat_score->round_heat_id = $round_heat->id;
                    $heat_score->judge_id = $judge->id;
                    $heat_score->save();
                }
            }
            $average =  [
                'round_heat_id' => 0,
                'judge_id' => 'Average',
                'wave_1' => 0,
                'wave_2' => 0,
                'wave_3' => 0,
                'wave_4' => 0,
                'wave_5' => 0,
                'wave_6' => 0,
                'wave_7' => 0,
                'wave_8' => 0,
                'wave_9' => 0,
                'wave_10' => 0,
            ];
            $temps = Heat_score::where('round_heat_id', $round_heat->id)->orderBy('judge_id')->get();
            foreach ($temps as $temp) {
                $temp->round_heat->com_cat_mod_participant->participant;
                $temp->round_heat->com_cat_mod_participant->competition;
                $temp->round_heat->com_cat_mod_participant->category->sex;
                $temp->round_heat->com_cat_mod_participant->modality;
                $temp->round_heat->lycra;

                $average['round_heat_id'] = $temp->round_heat_id;
                $average['wave_1'] = $average['wave_1'] + $temp->wave_1/3;
                $average['wave_2'] = $average['wave_2'] + $temp->wave_2/3;
                $average['wave_3'] = $average['wave_3'] + $temp->wave_3/3;
                $average['wave_4'] = $average['wave_4'] + $temp->wave_4/3;
                $average['wave_5'] = $average['wave_5'] + $temp->wave_5/3;
                $average['wave_6'] = $average['wave_6'] + $temp->wave_6/3;
                $average['wave_7'] = $average['wave_7'] + $temp->wave_7/3;
                $average['wave_8'] = $average['wave_8'] + $temp->wave_8/3;
                $average['wave_9'] = $average['wave_9'] + $temp->wave_9/3;
                $average['wave_10'] = $average['wave_10'] + $temp->wave_10/3;
            }
            // array_push($temps, $average);
            array_push($heat_scores, $temps);
        }
        return response()->json([
            'message' => 'success',
            'round_heats' => $round_heats,
            'heat_scores' => $heat_scores,
        ], 200);
    }
}
