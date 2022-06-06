<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $board_name_list = ["notice", "free", "quot", "qna", "buy", "sell", "school", "anon", "dog", "cat", "inquiry"];
        $board_alias_list = ["공지", "자유", "견적", "QnA", "구매", "판매", "학교", "익명", "강아지", "고양이", "문의"];
        for ($i = 0; $i < count($board_name_list); $i++) {
            $alias = $board_alias_list[$i];
            $name = $board_name_list[$i];
            DB::table('boards')->insert(
                array(
                    'name' => $name,
                    'alias' => $alias,
                    'type' => $name == 'anon' ? 'anonymous' : 'normal',
                    'user_only' => $name != 'unreg'
                )
            );
        }
    }
}
