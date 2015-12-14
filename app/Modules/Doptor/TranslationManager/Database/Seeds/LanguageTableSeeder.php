<?php namespace Modules\Doptor\TranslationManager\Database\Seeds;

use App;
use DB;

use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    public function run()
    {
        $module = [
            'name' => 'English',
            'code' => 'en',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ];

        DB::table('translation_languages')->insert($module);

        $translation_manager = App::make('Barryvdh\TranslationManager\Manager');
        $translation_manager->importTranslations();
    }
}
