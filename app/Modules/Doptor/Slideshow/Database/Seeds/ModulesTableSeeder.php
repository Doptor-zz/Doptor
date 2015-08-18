<?php namespace Modules\Doptor\Slideshow\Database\Seeds;

use DB;

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
    public function run()
    {
        $module = [
            'name' => 'Slideshow',
            'alias' => 'Slideshow',
            'hash' => 'module_32bc0a7573373',
            'table' => '',
            'version' => '1.0',
            'author' => 'Doptor',
            'vendor' => 'Doptor',
            'website' => 'http://doptor.net',
            'description' => NULL,
            'form_fields' => NULL,
            'target' => 'backend',
            'models' => 'NULL',
            'links' => '[{"alias": "slideshow", "name": "Slideshow"}]',
            'migrations' => '["2014_02_19_175006_create_slideshow_table"]',
            'enabled' => '1',
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s')
        ];

        DB::table('modules')->insert($module);
    }
}
