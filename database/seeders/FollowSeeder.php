<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Follow;


class FollowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // \App\Models\Follow::factory(45)->create();

        $userIds = DB::table('users')->pluck('id');

        foreach ($userIds as $followerId) {
            foreach ($userIds as $followingId) {
                if ($followerId !== $followingId) {
                    Follow::factory()->create([
                        'follower_id' => $followerId,
                        'following_id' => $followingId,
                    ]);
                }
            }
        }
    }
}
