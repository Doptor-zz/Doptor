<?php namespace Modules\Newsletter\Models;

use Eloquent;

class Newsletter extends Eloquent
{
    protected $table = 'mdl_newsletters';

    protected $guarded = array('id');

    protected $fillable = array('subject', 'content');

    public function alias($name, $field_name='alias')
    {
        $alias = Str::slug($name);
        $aliases = $this->whereRaw("{$field_name} REGEXP '^{$alias}(-[0-9]*)?$'");

        if ($aliases->count() === 0) {
            return $alias;
        } else {
            // get reverse order and get first
            $lastAliasNumber = intval(str_replace($alias . '-', '', $aliases->orderBy($field_name, 'desc')->first()->{$field_name}));

            return $alias . '-' . ($lastAliasNumber + 1);
        }
    }
}
