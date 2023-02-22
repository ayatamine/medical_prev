<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Ad::create([
            'title'=>'ads title 1',
            'title_ar'=>'عنوان اعلان',
            'image'=> 'ad-image.png',
            'text' =>'some text for the ads',
            'text_ar'=>'بعض النص لوصف الاعلان',
            'duration'=>5,
            'publish_date'=>Carbon::today()
        ]);
    }
}
