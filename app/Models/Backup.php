<?php
/*
=================================================
CMS Name  :  DOPTOR
CMS Version :  v1.2
Available at :  www.doptor.org
Copyright : Copyright (coffee) 2011 - 2015 Doptor. All rights reserved.
License : GNU/GPL, visit LICENSE.txt
Description :  Doptor is Opensource CMS.
===================================================
*/
class Backup extends Eloquent {
    protected $fillable = ['file', 'includes', 'description'];

    protected $guarded = ['id'];

    protected $table = 'backups';

    public function setIncludesAttribute($includes)
    {
        $this->attributes['includes'] = json_encode($includes);
    }

    public function getIncludesAttribute($includes)
    {
        return json_decode($includes);
    }
}
