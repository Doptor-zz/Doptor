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
     * @return array
     */
    public function targets()
    {
        return explode('|', $this->target);
    }

    /**
     * Get the links of the module
     * @return string
     */
    public function getLinks()
    {
        $ret_links = array();
        if ($this->links == '') {
            $alias = Str::slug($this->name, '_');
            $name = $this->name;
            $ret_links[$alias] = $name;
        } else {
            $links = json_decode($this->links);

            foreach ($links as $link) {
                $ret_links[$link->alias] = $link->name;
            }
        }

        return $ret_links;
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
