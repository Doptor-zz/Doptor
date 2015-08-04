<?php namespace Modules\Doptor\CompanyInfo\Database\Seeds;

use DB;

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{
    public function run()
    {
        $module = [
            'name' => 'Company Info',
            'alias' => 'CompanyInfo',
            'hash' => 'module_55ad0a9988993',
            'table' => '',
            'version' => '1.0',
            'author' => 'Doptor',
            'vendor' => 'Doptor',
            'website' => 'http://doptor.net',
            'description' => NULL,
            'target' => 'public|admin|backend',
            'links' => '',
            'migrations' => '["2015_07_20_190240_create_mdl_doptor_incharges_table","2015_07_20_201633_create_mdl_doptor_countries_table","2015_07_20_203952_create_mdl_doptor_companies_table","2015_07_21_205437_create_mdl_doptor_company_branches_table"]',
            'enabled' => '1'
        ];

        DB::table('modules')->insert($module);
    }
}
