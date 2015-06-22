<?php namespace App\Facades;

use Illuminate\Support\Facades\Schema as BaseSchema;

class Schema extends BaseSchema {

    protected static $core_tables = [
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

    /**
     * Overload the drop method of Schema to prevent the dropping
     * of core CMS tables
     * @param  $table
     * @return
     */
    public static function drop($table)
    {
        // Drop the table only if it isn't one of the core tables
        if (static::isNotCoreTable($table)) {
            parent::drop($table);
        }
    }

    /**
     * Overload the drop method of Schema to prevent the dropping
     * of core CMS tables
     * @param  $table
     * @return
     */
    public static function dropIfExists($table)
    {
        // Drop the table only if it isn't one of the core tables
        if (static::isNotCoreTable($table)) {
            parent::dropIfExists($table);
        }
    }

    /**
     * Check if the table is not one of the core tables
     * @param  $table
     * @return boolean
     */
    public static function isNotCoreTable($table)
    {
        return !in_array($table, static::$core_tables);
    }

}
