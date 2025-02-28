<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRecords = [
            ['id'=>1, 'name'=>'Super Admin' , 'type'=>'superadmin' , 'vendor_id'=>0, 'mobile'=>'9800000000'
            ,'email'=>'admin@admin.com','password'=>'$2a$12$49NM0CpdAFZ8Rq4D3JpVZ.TCziOOg.tLh1iXdegq/Z8jewu/r5C3S','image'=>'','status'=>1],
        ];
        Admin::insert($adminRecords);
    }
}
