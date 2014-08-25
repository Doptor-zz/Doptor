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

class FormEntryPresenter extends Presenter {

    public function data()
    {
        $fields = json_decode($this->fields, true);
        $data = json_decode($this->data, true);

        foreach ($fields as $key => $value) {
            // dd($key);
            $data[$value] = $data[$key];
            unset($data[$key]);
        }

        $exported_var = var_export($data, true);
        $exported_var = str_replace("array (", "", $exported_var);
        $exported_var = str_replace("',", "'<br>", $exported_var);
        $exported_var = str_replace(")", "", $exported_var);

        return $exported_var;
    }
}
