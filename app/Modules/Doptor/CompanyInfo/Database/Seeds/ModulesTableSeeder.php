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
            'form_fields' => '[{"name": "Name", "reg_no": "Registration Number", "logo": "Logo", "address": "Address", "website": "Website", "phone": "Phone", "email": "Email", "address": "Address"}, {"name": "Name", "reg_no": "Registration Number", "address": "Address", "website": "Website", "phone": "Phone", "fax": "Fax", "mobile": "Mobile", "email": "Email"} ]',
            'target' => 'public|admin|backend',
            'models' => '{"Company": "Companies", "CompanyBranch": "Company Branches"}',
            'links' => '',
            'migrations' => '["2015_07_20_190240_create_mdl_doptor_incharges_table","2015_07_20_201633_create_mdl_doptor_countries_table","2015_07_20_203952_create_mdl_doptor_companies_table","2015_07_21_205437_create_mdl_doptor_company_branches_table"]',
            'enabled' => '1'
        ];

        DB::table('modules')->insert($module);
    }
}
