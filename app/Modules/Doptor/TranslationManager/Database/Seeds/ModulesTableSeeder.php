<?php namespace Modules\Doptor\TranslationManager\Database\Seeds;

use DB;

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
    public function run()
    {
        $module = [
            'name' => 'Translation Manager',
            'alias' => 'translation_manager',
            'hash' => 'module_07375626f6468',
            'table' => '',
            'version' => '1.0',
            'author' => 'Doptor',
            'vendor' => 'Doptor',
            'website' => 'http://doptor.net',
            'description' => NULL,
            'form_fields' => NULL,
            'target' => 'backend',
            'models' => 'NULL',
            'links' => '[{"alias": "translation_manager", "name": "Translation Manager"}]',
            'migrations' => '["2015_12_01_144018_create_translation_languages_table"]',
            'enabled' => '1',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ];

        DB::table('modules')->insert($module);
    }
}
