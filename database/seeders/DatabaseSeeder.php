<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $content = Storage::disk('public')->get('/mark_models.txt');
        //Формат json приводим к корректному виду так как данные в файле не соответствуют формату
        $content = substr($content,1,-1);
        $content = str_replace("{'", '{"', $content);
        $content = str_replace("':", '":', $content); 
        $content = str_replace('\"', '', $content);
        $content = str_replace('\\', '', $content);
        $content = str_replace(", '", ', "', $content);
        $content = str_replace("',", '",', $content);
        $content = str_replace("['", '["', $content);
        $content = str_replace("']", '"]', $content);
        $content = str_replace(' {', ' ', $content);
        $content = str_replace('},', ',', $content); 

        DB::beginTransaction();
        try {
            foreach (json_decode($content) as $key => $models ) {
                $brand = Brand::create([
                    'brand_name' => $key
                ]);
    
                foreach ($models as $model) {
                    Models::create([
                        'model_name' => $model,
                        'brand_id' => $brand->id
                    ]);
                }
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
        
    }
}
