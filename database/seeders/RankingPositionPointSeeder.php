<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RankingPositionPointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('ranking_position_points')->insert([[
            'ranking_id' => 1,
            'ranking_position' => 1,
            'ranking_points' => 110
        ], [
            'ranking_id' => 1,
            'ranking_position' => 2,
            'ranking_points' => 100
        ], [
            'ranking_id' => 1,
            'ranking_position' => 3,
            'ranking_points' => 92
        ], [
            'ranking_id' => 1,
            'ranking_position' => 4,
            'ranking_points' => 86
        ], [
            'ranking_id' => 1,
            'ranking_position' => 5,
            'ranking_points' => 82
        ], [
            'ranking_id' => 1,
            'ranking_position' => 6,
            'ranking_points' => 78
        ], [
            'ranking_id' => 1,
            'ranking_position' => 7,
            'ranking_points' => 74
        ], [
            'ranking_id' => 1,
            'ranking_position' => 8,
            'ranking_points' => 70
        ], [
            'ranking_id' => 1,
            'ranking_position' => 9,
            'ranking_points' => 68
        ], [
            'ranking_id' => 1,
            'ranking_position' => 10,
            'ranking_points' => 66
        ], [
            'ranking_id' => 1,
            'ranking_position' => 11,
            'ranking_points' => 64
        ], [
            'ranking_id' => 1,
            'ranking_position' => 12,
            'ranking_points' => 62
        ], [
            'ranking_id' => 1,
            'ranking_position' => 13,
            'ranking_points' => 60
        ], [
            'ranking_id' => 1,
            'ranking_position' => 14,
            'ranking_points' => 58
        ], [
            'ranking_id' => 1,
            'ranking_position' => 15,
            'ranking_points' => 56
        ], [
            'ranking_id' => 1,
            'ranking_position' => 16,
            'ranking_points' => 54
        ], [
            'ranking_id' => 1,
            'ranking_position' => 17,
            'ranking_points' => 53
        ], [
            'ranking_id' => 1,
            'ranking_position' => 18,
            'ranking_points' => 52
        ], [
            'ranking_id' => 1,
            'ranking_position' => 19,
            'ranking_points' => 51
        ], [
            'ranking_id' => 1,
            'ranking_position' => 20,
            'ranking_points' => 50
        ]]);
    }
}
