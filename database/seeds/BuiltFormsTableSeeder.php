<?php

use Illuminate\Database\Seeder;

class BuiltFormsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('built_forms')->delete();
        
		\DB::table('built_forms')->insert(array (
			0 => 
			array (
				'id' => '8',
				'name' => 'Client Data',
				'hash' => '',
				'category' => '1',
				'description' => '',
				'show_captcha' => '0',
				'data' => '[{"title":"Form Name","fields":{"name":{"label":"Form Name","type":"input","value":"Client Data","name":"name"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"client32nn","name":"id"},"label":{"label":"Label Text","type":"input","value":"Client Name","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Text Area","fields":{"id":{"label":"ID / Name","type":"input","value":"clientaddress9mm","name":"id"},"label":{"label":"Label Text","type":"input","value":"Address","name":"label"},"textarea":{"label":"Starting Text","type":"textarea","value":"","name":"textarea"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"phone8089","name":"id"},"label":{"label":"Label Text","type":"input","value":"Phone","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"email232","name":"id"},"label":{"label":"Label Text","type":"input","value":"Email ","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Text Input","fields":{"id":{"label":"ID / Name","type":"input","value":"website9808","name":"id"},"label":{"label":"Label Text","type":"input","value":"Website","name":"label"},"placeholder":{"label":"Placeholder","type":"input","value":"","name":"placeholder"},"helptext":{"label":"Help Text","type":"input","value":"","name":"helptext"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Select Basic","fields":{"id":{"label":"ID / Name","type":"input","value":"country009ms","name":"id"},"label":{"label":"Label Text","type":"input","value":"Country","name":"label"},"options":{"label":"Options","type":"textarea-split","value":["Bangladesh","Malaysia","Singapore","USA","Canada","Australia","UK","Japan"],"name":"options"},"inputsize":{"label":"Input Size","type":"select","value":[{"value":"input-mini","selected":false,"label":"Mini"},{"value":"input-small","selected":false,"label":"Small"},{"value":"input-medium","selected":false,"label":"Medium"},{"value":"input-large","selected":false,"label":"Large"},{"value":"input-xlarge","selected":true,"label":"Xlarge"},{"value":"input-xxlarge","selected":false,"label":"Xxlarge"}],"name":"inputsize"}}},{"title":"Multiple Radios","fields":{"name":{"label":"Group Name","type":"input","value":"status98nm","name":"name"},"label":{"label":"Label Text","type":"input","value":"Status","name":"label"},"required":{"label":"Required","type":"checkbox","value":false,"name":"required"},"radios":{"label":"Radios","type":"textarea-split","value":["Active","Inactive"],"name":"radios"}}},{"title":"Single Button","fields":{"id":{"label":"ID / Name","type":"input","value":"singlebutton44d","name":"id"},"label":{"label":"Label Text","type":"input","value":"","name":"label"},"buttonlabel":{"label":"Button Label","type":"input","value":"Submit","name":"buttonlabel"},"buttontype":{"label":"Button Type","type":"select","value":[{"value":"btn-default","selected":false,"label":"Default"},{"value":"btn-primary","selected":true,"label":"Primary"},{"value":"btn-info","selected":false,"label":"Info"},{"value":"btn-success","selected":false,"label":"Success"},{"value":"btn-warning","selected":false,"label":"Warning"},{"value":"btn-danger","selected":false,"label":"Danger"},{"value":"btn-inverse","selected":false,"label":"Inverse"}],"name":"buttontype"}}}]',
				'rendered' => '<form class="form-horizontal">
<fieldset>

<!-- Form Name -->
<legend>Client Data</legend>

<!-- Text input-->
<div class="control-group">
<label class="control-label" for="client32nn">Client Name</label>
<div class="controls">
<input id="client32nn" name="client32nn" type="text" placeholder="" class="input-xlarge">

</div>
</div>

<!-- Textarea -->
<div class="control-group">
<label class="control-label" for="clientaddress9mm">Address</label>
<div class="controls">                     
<textarea id="clientaddress9mm" name="clientaddress9mm"></textarea>
</div>
</div>

<!-- Text input-->
<div class="control-group">
<label class="control-label" for="phone8089">Phone</label>
<div class="controls">
<input id="phone8089" name="phone8089" type="text" placeholder="" class="input-xlarge">

</div>
</div>

<!-- Text input-->
<div class="control-group">
<label class="control-label" for="email232">Email </label>
<div class="controls">
<input id="email232" name="email232" type="text" placeholder="" class="input-xlarge">

</div>
</div>

<!-- Text input-->
<div class="control-group">
<label class="control-label" for="website9808">Website</label>
<div class="controls">
<input id="website9808" name="website9808" type="text" placeholder="" class="input-xlarge">

</div>
</div>

<!-- Select Basic -->
<div class="control-group">
<label class="control-label" for="country009ms">Country</label>
<div class="controls">
<select id="country009ms" name="country009ms" class="input-xlarge">
<option>Bangladesh</option>
<option>Malaysia</option>
<option>Singapore</option>
<option>USA</option>
<option>Canada</option>
<option>Australia</option>
<option>UK</option>
<option>Japan</option>
</select>
</div>
</div>

<!-- Multiple Radios -->
<div class="control-group">
<label class="control-label" for="status98nm">Status</label>
<div class="controls">
<label class="radio" for="status98nm-0">
<input type="radio" name="status98nm" id="status98nm-0" value="Active" checked="checked">
Active
</label>
<label class="radio" for="status98nm-1">
<input type="radio" name="status98nm" id="status98nm-1" value="Inactive">
Inactive
</label>
</div>
</div>

<!-- Button -->
<div class="control-group">
<label class="control-label" for="singlebutton44d"></label>
<div class="controls">
<button id="singlebutton44d" name="singlebutton44d" class="btn btn-primary">Submit</button>
</div>
</div>

</fieldset>
</form>
',
				'redirect_to' => 'list',
				'extra_code' => '',
				'email' => '',
				'created_at' => '2014-03-28 05:18:25',
				'updated_at' => '2014-03-28 05:18:25',
			),
		));
	}

}
