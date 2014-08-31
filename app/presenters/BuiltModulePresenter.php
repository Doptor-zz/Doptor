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

class BuiltModulePresenter extends Presenter
{
    /**
     * Get the form(s) associated with the module
     */
    public function forms()
    {
        $selected_forms = explode(", ", $this->form_id);

        $forms = array();
        foreach ($selected_forms as $form_id) {
            $form = BuiltForm::find($form_id);
            if ($form) {
                $forms[] = $form;
            }
        }

        return $forms;
    }

    /**
     * Get all the forms selected for the module
     * @return array
     */
    public function selected_forms($index)
    {
        $forms = explode(", ", $this->form_id);

        if ($index >= sizeof($forms)) {
            return 0;
        }
        return $forms[$index];
    }

    /**
     * Get the names of the tables of the module
     * @return string
     */
    public function tables()
    {
        $tables = explode('|', $this->table_name);

        $tables = array_map(function($table) {
            return 'mdl_' . $table;
        }, $tables);

        return implode(', ', $tables);
    }
}
