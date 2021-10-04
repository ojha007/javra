<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Lesson::factory()
            ->count(40)
            ->create();
        User::factory()
            ->count(10)
            ->create();
        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            ['name' => 'User', 'password' => bcrypt('123456')
            ]);

        $av = DB::table('achievements_rules')->count('id');
        if (!$av) {
            DB::table('achievements_rules')
                ->insert([
                    [
                        'type' => 'LESSON',
                        'title' => 'First Lesson Watched',
                        'rule' => 1,
                    ],
                    [
                        'type' => 'LESSON',
                        'title' => '5 Lessons Watched',
                        'rule' => 5,
                    ],
                    [
                        'type' => 'LESSON',
                        'title' => '10 Lessons Watched',
                        'rule' => 10,
                    ],
                    [
                        'type' => 'LESSON',
                        'title' => '25 Lessons Watched',
                        'rule' => 25,
                    ],
                    [
                        'type' => 'LESSON',
                        'title' => '50 Lessons Watched',
                        'rule' => 50,
                    ],
                    [
                        'type' => 'COMMENT',
                        'title' => 'First Comment Written',
                        'rule' => 1,
                    ], [
                        'type' => 'COMMENT',
                        'title' => '3 Comments Written',
                        'rule' => 3,
                    ],
                    [
                        'type' => 'COMMENT',
                        'title' => '5 Comments Written',
                        'rule' => 5,
                    ],
                    [
                        'type' => 'COMMENT',
                        'title' => '10 Comment Written',
                        'rule' => 10,
                    ],
                    [
                        'type' => 'COMMENT',
                        'title' => '20 Comment Written',
                        'rule' => 20,
                    ],
                ]);
        }
        $br = DB::table('badge_rules')->count('id');
        if (!$br) {
            DB::table('badge_rules')
                ->insert([
                    [
                        'title' => 'Beginner',
                        'rule' => 0,
                        'sequence' => 1
                    ],
                    [
                        'title' => 'Intermediate',
                        'rule' => 4,
                        'sequence' => 2
                    ],
                    [
                        'title' => 'Advanced',
                        'rule' => 8,
                        'sequence' => 3
                    ],
                    [
                        'title' => 'Master',
                        'rule' => 10,
                        'sequence' => 4
                    ]
                ]);
        }

    }
}
