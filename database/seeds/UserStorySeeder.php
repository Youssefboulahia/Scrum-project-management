<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UserStorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('userstories')->insert([
            [
                'description' => 'En tant que User Story 1',
                'priority' => 'faible',
                'estimation' => 23,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 2',
                'priority' => 'faible',
                'estimation' => 15,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 3',
                'priority' => 'faible',
                'estimation' => 34,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 4',
                'priority' => 'faible',
                'estimation' => 9,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 5',
                'priority' => 'faible',
                'estimation' => 19,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 6',
                'priority' => 'faible',
                'estimation' => 39,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 7',
                'priority' => 'faible',
                'estimation' => 27,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 8',
                'priority' => 'faible',
                'estimation' => 40,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 9',
                'priority' => 'faible',
                'estimation' => 31,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 10',
                'priority' => 'faible',
                'estimation' => 23,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 11',
                'priority' => 'faible',
                'estimation' => 15,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 12',
                'priority' => 'faible',
                'estimation' => 7,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
            [
                'description' => 'En tant que User Story 13',
                'priority' => 'faible',
                'estimation' => 19,
                'phase' => 'undone',
                'project_id' => 1,
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
