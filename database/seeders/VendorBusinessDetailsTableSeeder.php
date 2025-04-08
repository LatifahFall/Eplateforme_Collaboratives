<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBusinessDetail;

class VendorBusinessDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        $vendorRecords=[
            ['id'=>1,'vendor_id'=>1,'shop_name'=>'titbirine','shop_email'=>'titbirin@gmail.com','shop_address'=>'ourika','shop_city'=>'ourika','shop_state'=>'marrakech-safi','shop_country'=>'morocco',
            'shop_zipcode'=>40000,'shop_mobile'=>0600000000,'shop_website'=>'test.com','address_proof'=>'test',
            'address_proof_image'=>'test.jpg','business_license_number'=>'12344' ],
        ];
        VendorsBusinessDetail::insert($vendorRecords);
    }
}
