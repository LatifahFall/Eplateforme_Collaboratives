<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Vendor;

class VendorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

     
    public function run()
    {
        $vendorRecords=[
            ['id'=>1,'name'=>'test','address'=>'ourika','city'=>'ourika','state'=>'marrakech-safi','country'=>'morocco'
            ,'pincode'=>'40000','mobile'=>'0611111111','email'=>'titbirineouzghar@gmail.com','status'=>0,'image'=>'test.jpg'],
        ];
        Vendor::insert($vendorRecords);
    } 
}
