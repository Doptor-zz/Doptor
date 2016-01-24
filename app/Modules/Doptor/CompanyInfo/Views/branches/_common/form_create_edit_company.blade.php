<?php $link_type = ($link_type=="public") ? "" : $link_type . "." ?>
@if (!isset($company_branch))
{!! Form::open(array("route"=>"{$link_type}modules.".$module_link.".branches.store", "method"=>"POST", "class"=>"form-horizontal", "files"=>true)) !!}
@else
{!! Form::model($company_branch, array("route" => array("{$link_type}modules.".$module_link.".branches.update", $company_branch->id), "method"=>"PUT", "class"=>"form-horizontal", "files"=>true)) !!}
@endif
  @if ($errors->has())
    <div class="alert alert-error hide" style="display: block;"> <button data-dismiss="alert" class="close">×</button> {!! trans('errors.form_errors') !!} </div>
  @endif
  {!! Form::hidden('form_id', 27) !!}

  <fieldset>

    <legend>Company Branch</legend>

    <!-- Text input-->
    <div class="control-group {{ $errors->has('name') ? 'error' : '' }}">
      <label class="control-label" for="name">Branch Name <span class="red">*</span></label>
      <div class="controls">
        {!! Form::text('name', Input::old('name'), array('class'=>'input-xlarge', 'required')) !!}
        {!! $errors->first('name', '<span class="help-inline">:message</span>') !!}
      </div>
    </div>

    <div class="control-group {{ $errors->has('reg_no') ? 'error' : '' }}">
      <label class="control-label" for="reg_no">Registration Number <span class="red">*</span></label>
      <div class="controls">
        {!! Form::text('reg_no', Input::old('reg_no'), array('class'=>'input-xlarge', 'required')) !!}
        {!! $errors->first('reg_no', '<span class="help-inline">:message</span>') !!}
      </div>
    </div>

    <div class="control-group {{ $errors->has('company_id') ? 'error' : '' }}">
      <label class="control-label" for="company_id">Company <span class="red">*</span></label>
      <div class="controls">
        {!! Form::select('company_id', $companies, Input::old('company_id'), array('class'=>'input-xlarge')) !!}
        {!! $errors->first('company_id', '<span class="help-inline">:message</span>') !!}
      </div>
    </div>

    <!-- Select Basic -->
    <div class="control-group {{ $errors->has('country_id') ? 'error' : '' }}">
      <label class="control-label" for="country_id">Country <span class="red">*</span></label>
      <div class="controls">
        {!! Form::select('country_id', $countries, Input::old('country_id'), array('class'=>'input-xlarge')) !!}
        {!! $errors->first('country_id', '<span class="help-inline">:message</span>') !!}
      </div>
    </div>

    <!-- Textarea -->
    <div class="control-group {{ $errors->has('address') ? 'error' : '' }}">
      <label class="control-label" for="address">Address</label>
      <div class="controls">
        {!! Form::textarea('address', Input::old('address'), array('class'=>'input-xlarge', 'rows'=>2, 'required')) !!}
        {!! $errors->first('address', '<span class="help-inline">:message</span>') !!}
      </div>
    </div>

    <div class="control-group {{ $errors->has('website') ? 'error' : '' }}">
      <label class="control-label" for="website">Website</label>
      <div class="controls">
        {!! Form::text('website', Input::old('website'), array('class'=>'input-xlarge')) !!}
        {!! $errors->first('website', '<span class="help-inline">:message</span>') !!}
      </div>
    </div>

    <div class="control-group {{ $errors->has('email') ? 'error' : '' }}">
      <label class="control-label" for="email">Email</label>
      <div class="controls">
        {!! Form::email('email', Input::old('email'), array('class'=>'input-xlarge')) !!}
        {!! $errors->first('email', '<span class="help-inline">:message</span>') !!}
      </div>
    </div>

    <div class="control-group {{ $errors->has('phone') ? 'error' : '' }}">
      <label class="control-label" for="phone">Phone Number</label>
      <div class="controls">
        {!! Form::text('phone', Input::old('phone'), array('class'=>'input-xlarge')) !!}
        {!! $errors->first('phone', '<span class="help-inline">:message</span>') !!}
      </div>
    </div>

  </fieldset>

  <fieldset>

    <legend>Person in-charge</legend>

    @for ($i = 0; $i < $incharge_count; $i++)
      <div class="person-in-charge form-group span6">
        {!! Form::hidden('incharge[id][]', isset($company) ? $company->incharges[$i]['id'] : '') !!}
        <!-- Text input-->
        <div class="control-group {{ $errors->has('incharge[name][]') ? 'error' : '' }}">
          <label class="control-label" for="incharge[name][]">Name <span class="red">*</span></label>
          <div class="controls">
            {!! Form::text('incharge[name][]', (isset($company_branch) ? $company_branch->incharges[$i]['name'] : Input::old('incharge[name][]')), array('class'=>'input-xlarge', 'required')) !!}
            {!! $errors->first('incharge[name][]', '<span class="help-inline">:message</span>') !!}
          </div>
        </div>

        <!-- Select Basic -->
        <div class="control-group {{ $errors->has('incharge[country_id][]') ? 'error' : '' }}">
          <label class="control-label" for="incharge[country_id][]">Country <span class="red">*</span></label>
          <div class="controls">
            {!! Form::select('incharge[country_id][]', $countries, (isset($company_branch) ? $company_branch->incharges[$i]['country_id'] : Input::old('incharge[country_id][]')), array('class'=>'input-xlarge')) !!}
            {!! $errors->first('incharge[country_id][]', '<span class="help-inline">:message</span>') !!}
          </div>
        </div>

        <!-- Textarea -->
        <div class="control-group {{ $errors->has('incharge[address][]') ? 'error' : '' }}">
          <label class="control-label" for="incharge[address][]">Address</label>
          <div class="controls">
            {!! Form::textarea('incharge[address][]', (isset($company_branch) ? $company_branch->incharges[$i]['address'] : Input::old('incharge[address][]')), array('class'=>'input-xlarge', 'rows'=>2)) !!}
            {!! $errors->first('incharge[address][]', '<span class="help-inline">:message</span>') !!}
          </div>
        </div>

        <div class="control-group {{ $errors->has('incharge[website][]') ? 'error' : '' }}">
          <label class="control-label" for="incharge[website][]">Website</label>
          <div class="controls">
            {!! Form::text('incharge[website][]', (isset($company_branch) ? $company_branch->incharges[$i]['website'] : Input::old('incharge[website][]')), array('class'=>'input-xlarge')) !!}
            {!! $errors->first('incharge[website][]', '<span class="help-inline">:message</span>') !!}
          </div>
        </div>

        <div class="control-group {{ $errors->has('incharge[email][]') ? 'error' : '' }}">
          <label class="control-label" for="incharge[email][]">Email</label>
          <div class="controls">
            {!! Form::email('incharge[email][]', (isset($company_branch) ? $company_branch->incharges[$i]['email'] : Input::old('incharge[email][]')), array('class'=>'input-xlarge')) !!}
            {!! $errors->first('incharge[email][]', '<span class="help-inline">:message</span>') !!}
          </div>
        </div>

        <div class="control-group {{ $errors->has('incharge[phone][]') ? 'error' : '' }}">
          <label class="control-label" for="incharge[phone][]">Phone Number</label>
          <div class="controls">
            {!! Form::text('incharge[phone][]', (isset($company_branch) ? $company_branch->incharges[$i]['phone'] : Input::old('incharge[phone][]')), array('class'=>'input-xlarge')) !!}
            {!! $errors->first('incharge[phone][]', '<span class="help-inline">:message</span>') !!}
          </div>
        </div>

        <div class="buttons pull-right">
          <div class="btn btn-small btn-primary">Add</div>
          <div class="btn btn-small btn-danger">Remove</div>
        </div>
        <div class="clearfix"></div>
      </div>
    @endfor

  </fieldset>

  <div class="form-actions">
  <button type="submit" class="btn btn-primary" name="form_save">Save</button>
  <button type="submit" class="btn btn-success" name="form_save_new">Save &amp;  New</button>
  <button type="submit" class="btn btn-primary btn-danger" name="form_close">Close</button>
  </div>
{!! Form::close() !!}
