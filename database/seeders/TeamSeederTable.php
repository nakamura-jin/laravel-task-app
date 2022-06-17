<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Team;
use App\Models\User;
// use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class TeamSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 1; $i <= 10; $i++) {
            $team_id = $i;
            $user_id = User::select('id')->orderByRaw("RAND()")->first()->id;
            $team = Team::find($team_id);

            for ($j = 1; $j <= 3; $j++) {
                $member_array[] = rand(1, 20);
            }

            // チームの担当もメンバーに入れる
            array_push($member_array, $team->user_id);
            // idが重複している場合、重複分削除
            $unique = array_unique($member_array);
            // 配列にindexをつける
            $values = array_values($unique);
            // team_idとuser_idの組み合わせで、すでに同じ組み合わせの値がないかチェック
            $team_user = DB::table('team_user')->where([['team_id', $team_id, ['user_id', $user_id]]])->get();

            // なければ登録
            if($team_user->isEmpty()) {
                foreach ($values as $user) {
                    $team->users()->attach($user);
                }
            }

            // メンバーのidをリセット
            unset($member_array);
        }
    }
}
