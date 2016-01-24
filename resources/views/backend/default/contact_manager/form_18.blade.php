<?php $link_type = ($link_type=="public") ? "" : $link_type . "." ?>
@if (!isset($entry))
{!! Form::open(array("route"=>"{$link_type}contact-manager.store", "method"=>"POST", "class"=>"form-horizontal", "files"=>true)) !!}
@else
{!! Form::open(array("route" => array("{$link_type}contact-manager.update", $entry->id), "method"=>"PUT", "class"=>"form-horizontal", "files"=>true)) !!}
@endif
{!! Form::hidden('form_id', 18) !!}


<ul class="nav nav-tabs">
   <li class="active"><a href="#tab_1_1" data-toggle="tab">{!! trans('fields.contact') !!} {!! trans('fields.details') !!}</a></li>
   <li><a href="#tab_1_2" data-toggle="tab">{!! trans('form_messages.display_options') !!}</a></li>
</ul>
<div class="tab-content">
   <div class="tab-pane active" id="tab_1_1">
        <fieldset>
            <!-- Text input-->
            <div class="control-group {!! $errors->has('name') ? 'error' : '' !!}">
                <label class="control-label" for="name">{!! trans('fields.name') !!}</label>
                <div class="controls">
                    {!! Form::text('name', (isset($entry) ? $entry->name : Input::old('name')), array('id'=>'name', 'class'=>'input-xlarge')) !!}

                    {!! $errors->first('name', '<span class="help-inline">:message</span>') !!}
                </div>
            </div>

            <div class="control-group {!! $errors->has('alias') ? 'error' : '' !!}">
                <label class="control-label" for="alias">{!! trans('fields.alias') !!}</label>
                <div class="controls">
                    {!! Form::text('alias', (isset($entry) ? $entry->alias : Input::old('alias')), array('id'=>'alias', 'class'=>'input-xlarge')) !!}
                    <div class="help-inline">{!! trans('form_messages.blank_for_automatic_alias') !!}</div>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('image') ? 'error' : '' !!}">
                <label class="control-label" for="image">{!! trans('fields.image') !!}</label>
                <div class="controls">
                    {!! Form::hidden('image') !!}
                    <a class="btn btn-primary insert-media" id="insert-main-image" href="#"> {!! trans('form_messages.select_image') !!}</a>
                    <span class="file-name">
                        {!! $entry->image or '' !!}
                    </span>

                </div>
            </div>

            <div class="control-group {!! $errors->has('email') ? 'error' : '' !!}">
                <label class="control-label" for="email">{!! trans('cms.category') !!}</label>
                <div class="controls">
                    {!! Form::select('category_id', $categories, (isset($entry) ? $entry->category_id : Input::old('category_id')), array('class'=>'chosen')) !!}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('email') ? 'error' : '' !!}">
                <label class="control-label" for="email">{!! trans('fields.email') !!}</label>
                <div class="controls">
                    {!! Form::text('email', (isset($entry) ? $entry->email : Input::old('email')), array('id'=>'email', 'class'=>'input-xlarge')) !!}
                </div>
            </div>

            <!-- Textarea -->
            <div class="control-group {!! $errors->has('address') ? 'error' : '' !!}">
                <label class="control-label" for="address">{!! trans('fields.address') !!}</label>
                <div class="controls">
                    {!! Form::textarea('address', (isset($entry) ? $entry->address : Input::old('address')), array('id'=>'address', 'rows'=>2, 'class'=>'input-xlarge')) !!}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('city') ? 'error' : '' !!}">
                <label class="control-label" for="city">{!! trans('fields.city') !!}</label>
                <div class="controls">
                    {!! Form::text('city', (isset($entry) ? $entry->city : Input::old('city')), array('id'=>'city', 'class'=>'input-xlarge')) !!}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('state') ? 'error' : '' !!}">
                <label class="control-label" for="state">{!! trans('fields.state') !!}</label>
                <div class="controls">
                    {!! Form::text('state', (isset($entry) ? $entry->state : Input::old('state')), array('id'=>'state', 'class'=>'input-xlarge')) !!}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('zip_code') ? 'error' : '' !!}">
                <label class="control-label" for="zip_code">{!! trans('fields.postal_code') !!}</label>
                <div class="controls">
                    {!! Form::text('zip_code', (isset($entry) ? $entry->zip_code : Input::old('zip_code')), array('id'=>'zip_code', 'class'=>'input-xlarge')) !!}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('country') ? 'error' : '' !!}">
                <label class="control-label" for="country">{!! trans('fields.country') !!}</label>
                <div class="controls">
                    {!! Form::text('country', (isset($entry) ? $entry->country : Input::old('country')), array('id'=>'country', 'class'=>'input-xlarge')) !!}
                </div>
            </div>

            <div class="control-group {!! $errors->has('location') ? 'error' : '' !!}">
                <label class="control-label" for="location">{!! trans('fields.location') !!}</label>
                <div class="controls">
                    <input type="hidden" name="location-lat" id="location-lat">
                    <input type="hidden" name="location-lon" id="location-lon">
                    <input type="hidden" name="location-name" id="location-name">
                    <button href="#map-selection" data-toggle="modal" class="demo btn btn-primary">{!! trans('form_messages.select_location') !!}</button>
                    <span id="location-coordinates">
                        {!! $entry->location['latitude'] or '' !!},
                        {!! $entry->location['longitude'] or '' !!}
                    </span>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('telephone') ? 'error' : '' !!}">
                <label class="control-label" for="telephone">{!! trans('fields.telephone') !!}</label>
                <div class="controls">
                    {!! Form::text('telephone', (isset($entry) ? $entry->telephone : Input::old('telephone')), array('id'=>'telephone', 'class'=>'input-xlarge')) !!}

                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('mobile') ? 'error' : '' !!}">
                <label class="control-label" for="mobile">{!! trans('fields.mobile') !!}</label>
                <div class="controls">
                    {!! Form::text('mobile', (isset($entry) ? $entry->mobile : Input::old('mobile')), array('id'=>'mobile', 'class'=>'input-xlarge')) !!}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('fax') ? 'error' : '' !!}">
                <label class="control-label" for="fax">{!! trans('fields.fax') !!}</label>
                <div class="controls">
                    {!! Form::text('fax', (isset($entry) ? $entry->fax : Input::old('fax')), array('id'=>'fax', 'class'=>'input-xlarge')) !!}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {!! $errors->has('website') ? 'error' : '' !!}">
                <label class="control-label" for="website">{!! trans('fields.website') !!}</label>
                <div class="controls">
                    {!! Form::text('website', (isset($entry) ? $entry->website : Input::old('website')), array('id'=>'website', 'class'=>'input-xlarge')) !!}
                </div>
            </div>

        </fieldset>
    </div>
    <div class="tab-pane" id="tab_1_2">
        @include("contact_manager::display_options")
    </div>

    <div id="map-selection" class="modal hide fade" tabindex="-1" data-width="760" data-keyboard="false">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>{!! trans('form_messages.select_location') !!}</h3>
        </div>
        <div class="modal-body">
            <div class="control-group hide">
                <label class="col-sm-1 control-label">{!! trans('fields.location') !!}:</label>

                <div class="col-sm-5">
                    <input type="text" id="map-address" placeholder="Enter a location" autocomplete="off">
                </div>
            </div>
            <!--/span-->
            <div id="location-picker" style="width: 530px; height: 400px;"></div>

            <div class="row-fluid hide">
                <div class="span6">
                    <label class="p-r-small col-sm-1 control-label">{!! trans('fields.latitude') !!}:</label>

                    <div class="col-sm-2">
                        <input type="text" id="map-lat" name="map-lat" style="width: 110px" class="form-control" value="{!! $entry->location['latitude'] or '' !!}">
                    </div>
                </div>
                <div class="span6">
                    <label class="p-r-small col-sm-1 control-label">{!! trans('fields.longitude') !!}:</label>

                    <div class="col-sm-2">
                        <input type="text" id="map-lon" name="map-lon" style="width: 110px" class="form-control" value="{!! $entry->location['longitude'] or '' !!}">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn">{!! trans('options.close') !!}</button>
            <button type="button" class="btn btn-primary" id="save-changes">{!! trans('options.save') !!} changes</button>
        </div>
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary" name="form_save">{!! trans('options.save') !!}</button>
    <button type="submit" class="btn btn-success" name="form_save_new">{!! trans('options.save') !!} &amp;  New</button>
    <button type="submit" class="btn btn-primary btn-danger" name="form_close">{!! trans('options.close') !!}</button>
</div>
{!! Form::close() !!}
