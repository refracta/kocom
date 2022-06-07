<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $board_name_list = ["notice", "free", "quot", "qna", "buy", "sell", "school", "anon", "dog", "cat", "inquiry"];

        for ($i = 1; $i <= 200; $i++) {
            DB::table('posts')->insert(
                array(
                    'user_id' => 1,
                    'board_id' => 2,
                    'title' => '자유 게시판 테스트 ' . $i,
                    'content' => "<p>안녕하세요, 이 글은 테스트를 위해 작성되었습니다.</p>",
                    'created_at' => now(),
                    'updated_at' => now(),
                )
            );
        }
    }
}
