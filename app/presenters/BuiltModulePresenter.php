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
     * Get the form name(s) associated with the module
     */
    public function form_name()
    {
        $selected_forms = explode(", ", $this->form_id);

        $form_names = array();
        foreach ($selected_forms as $form_id) {
            $form = BuiltForm::find($form_id);
            if ($form) {
                $form_names[] = $form->name;
            }
        }

        return implode(", ", $form_names);
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

}
