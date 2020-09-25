<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('configs')->insert([
            'title' => 'HakanEfendi Blog Sitesi',
            'logo' => '',
            'favicon' => '',
            'facebook' => 'https://www.facebook.com/Hakan07ant',
            'youtube' => 'https://www.youtube.com/channel/UCd3mvvSjN3lXIc_Qnm7hvcQ?view_as=subscriber',
            'instagram' => 'https://www.instagram.com/hakanefendii/?hl=tr',
            'twitter' => 'https://twitter.com/hakan07ant',
            'github' => 'https://github.com/hakan07ant',
            'gitlab' => 'https://github.com/hakan07ant',
            'linkedin' => 'https://tr.linkedin.com/',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
