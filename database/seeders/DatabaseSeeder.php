<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Models;
use App\Services\MigrationDataService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $data = MigrationDataService::getData();

        DB::beginTransaction();
        try {
            foreach ($data as $brands ) {
                foreach ($brands as $key => $brandModels) {
                    $brand = Brand::create([
                        'brand_name' => $key
                    ]);
        
                    foreach ($brandModels as $brandModel) {
                        Models::create([
                            'model_name' => $brandModel,
                            'brand_id' => $brand->id
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
