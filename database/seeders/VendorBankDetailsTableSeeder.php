<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VendorsBankDetail;
class VendorBankDetailsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    
    public function run()
    {
        //
        $vendorRecords=[
            ['id'=>1,'vendor_id'=>1,'account_holder_name'=>'siham','bank_name'=>'societe generale','bank_RIB'=>'64758293847562009874999'],
        ];
        VendorsBankDetail::insert($vendorRecords);
    }
        
}
