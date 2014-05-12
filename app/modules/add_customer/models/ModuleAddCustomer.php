<?php

class ModuleAddCustomer extends Eloquent {

	protected $table = 'module_add_customer';

	protected $fillable = array('customer_name','customer_email','customer_phone','customer_address',);
	protected $guarded = array();


}
