<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class MaintenanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = ["sql/users.sql","sql/services.sql","sql/members.sql","sql/ministries.sql","sql/commitments.sql"];
        foreach($datas as $data){
            $path = public_path($data);
            $sql = file_get_contents($path);
            DB::unprepared($sql);
        }
    }
}
