<?php
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2014 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
use Robbo\Presenter\Presenter;

class ModulePresenter extends Presenter
{

    /**
     * Get the display targets of the module
     * @return string
     */
    public function targets()
    {
        return explode('|', $this->target);
    }

    /**
     * Get the names of the tables of the module
     * @return string
     */
    public function tables()
    {
        $tables = explode('|', $this->table);

        $tables = array_map(function($table) {
            return 'mdl_' . $table;
        }, $tables);

        return implode(', ', $tables);
    }
}
