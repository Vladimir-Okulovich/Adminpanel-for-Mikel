<?php

namespace App\Http\Controllers\Api\v1;

use App\Models\Category;
use App\Models\Sex;
use App\Models\Modality_competition;
use App\Models\Modality;
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
            $temp = Modality_competition::where('competition_id', $competition->id)->where('modality_id', $modality->id);
            // array_push($all_ranking_data, $competition);
            if (empty($temp)) {
                echo("false");
            } else {
                echo("true");
            }
        }
        return response()->json([
            'message' => 'success',
            'all_ranking_data' => $all_ranking_data
        ], 200);
    }
}
