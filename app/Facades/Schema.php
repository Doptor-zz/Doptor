<?php namespace App\Facades;

use Illuminate\Support\Facades\Schema as BaseSchema;

class Schema extends BaseSchema {

    /**
     * Overload the drop method of Schema to prevent the dropping
     * of core CMS tables
     * @param  $table
     * @return
     */
    public static function drop($table)
    {
        $core_tables = [
            'built_forms',
            'built_modules',
            'built_reports',
            'categories',
            'category_post',
            'contact_categories',
            'contact_details',
            'contact_emails',
            'form_categories',
            'form_entries',
            'groups',
            'group_menu',
            'languages',
            'media_entries',
            'menus',
            'menu_categories',
            'menu_positions',
            'migrations',
            'modules',
            'newsletters',
            'newsletter_subscribers',
            'posts',
            'report_generators',
            'settings',
            'slideshow',
            'themes',
            'throttle',
            'users',
            'users_groups'
        ];

        // Drop the table only if it isn't one of the core tables
        if (!in_array($table, $core_tables)) {
            parent::drop($table);
        }
    }

}
