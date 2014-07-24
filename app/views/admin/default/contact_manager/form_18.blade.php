<?php $link_type = ($link_type=="public") ? "" : $link_type . "." ?>
@if (!isset($entry))
{{ Form::open(array("route"=>"{$link_type}contact-manager.store", "method"=>"POST", "class"=>"form-horizontal", "files"=>true)) }}
@else
{{ Form::open(array("route" => array("{$link_type}contact-manager.update", $entry->id), "method"=>"PUT", "class"=>"form-horizontal", "files"=>true)) }}
@endif
{{ Form::hidden('form_id', 18) }}


<ul class="nav nav-tabs">
   <li class="active"><a href="#tab_1_1" data-toggle="tab">Contact Details</a></li>
   <li><a href="#tab_1_2" data-toggle="tab">Display Options</a></li>
</ul>
<div class="tab-content">
   <div class="tab-pane active" id="tab_1_1">
        <fieldset>
            <!-- Text input-->
            <div class="control-group {{{ $errors->has('name') ? 'error' : '' }}}">
                <label class="control-label" for="name">Name</label>
                <div class="controls">
                    {{ Form::text('name', (isset($entry) ? $entry->name : Input::old('name')), array('id'=>'name', 'class'=>'input-xlarge')) }}

                    {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
                </div>
            </div>

            <div class="control-group {{{ $errors->has('alias') ? 'error' : '' }}}">
                <label class="control-label" for="alias">Alias</label>
                <div class="controls">
                    {{ Form::text('alias', (isset($entry) ? $entry->alias : Input::old('alias')), array('id'=>'alias', 'class'=>'input-xlarge')) }}
                    <div class="help-inline">Leave blank for automatic alias</div>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('image') ? 'error' : '' }}}">
                <label class="control-label" for="image">Image</label>
                <div class="controls">
                    {{ Form::hidden('image') }}
                    <a class="btn btn-primary insert-media" id="insert-main-image" href="#"> Select image</a>
                    <span class="file-name">
                        {{ $entry->image or '' }}
                    </span>

                </div>
            </div>

            <div class="control-group {{{ $errors->has('email') ? 'error' : '' }}}">
                <label class="control-label" for="email">Category</label>
                <div class="controls">
                    {{ Form::select('category_id', $categories, (isset($entry) ? $entry->category_id : Input::old('category_id')), array('class'=>'chosen')) }}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('email') ? 'error' : '' }}}">
                <label class="control-label" for="email">Email</label>
                <div class="controls">
                    {{ Form::text('email', (isset($entry) ? $entry->email : Input::old('email')), array('id'=>'email', 'class'=>'input-xlarge')) }}
                </div>
            </div>

            <!-- Textarea -->
            <div class="control-group {{{ $errors->has('address') ? 'error' : '' }}}">
                <label class="control-label" for="address">Address</label>
                <div class="controls">
                    {{ Form::textarea('address', (isset($entry) ? $entry->address : Input::old('address')), array('id'=>'address', 'rows'=>2, 'class'=>'input-xlarge')) }}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('city') ? 'error' : '' }}}">
                <label class="control-label" for="city">City</label>
                <div class="controls">
                    {{ Form::text('city', (isset($entry) ? $entry->city : Input::old('city')), array('id'=>'city', 'class'=>'input-xlarge')) }}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('state') ? 'error' : '' }}}">
                <label class="control-label" for="state">State</label>
                <div class="controls">
                    {{ Form::text('state', (isset($entry) ? $entry->state : Input::old('state')), array('id'=>'state', 'class'=>'input-xlarge')) }}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('zip_code') ? 'error' : '' }}}">
                <label class="control-label" for="zip_code">Postal/ZIP code</label>
                <div class="controls">
                    {{ Form::text('zip_code', (isset($entry) ? $entry->zip_code : Input::old('zip_code')), array('id'=>'zip_code', 'class'=>'input-xlarge')) }}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('country') ? 'error' : '' }}}">
                <label class="control-label" for="country">Country</label>
                <div class="controls">
                    {{ Form::text('country', (isset($entry) ? $entry->country : Input::old('country')), array('id'=>'country', 'class'=>'input-xlarge')) }}
                </div>
            </div>

            <div class="control-group {{{ $errors->has('location') ? 'error' : '' }}}">
                <label class="control-label" for="location">Location</label>
                <div class="controls">
                    <input type="hidden" name="location-lat" id="location-lat">
                    <input type="hidden" name="location-lon" id="location-lon">
                    <input type="hidden" name="location-name" id="location-name">
                    <button href="#map-selection" data-toggle="modal" class="demo btn btn-primary">Select location</button>
                    <span id="location-coordinates">
                        {{ $entry->location['latitude'] or '' }},
                        {{ $entry->location['longitude'] or '' }}
                    </span>
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('telephone') ? 'error' : '' }}}">
                <label class="control-label" for="telephone">Telephone</label>
                <div class="controls">
                    {{ Form::text('telephone', (isset($entry) ? $entry->telephone : Input::old('telephone')), array('id'=>'telephone', 'class'=>'input-xlarge')) }}

                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('mobile') ? 'error' : '' }}}">
                <label class="control-label" for="mobile">Mobile</label>
                <div class="controls">
                    {{ Form::text('mobile', (isset($entry) ? $entry->mobile : Input::old('mobile')), array('id'=>'mobile', 'class'=>'input-xlarge')) }}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('fax') ? 'error' : '' }}}">
                <label class="control-label" for="fax">Fax</label>
                <div class="controls">
                    {{ Form::text('fax', (isset($entry) ? $entry->fax : Input::old('fax')), array('id'=>'fax', 'class'=>'input-xlarge')) }}
                </div>
            </div>

            <!-- Text input-->
            <div class="control-group {{{ $errors->has('website') ? 'error' : '' }}}">
                <label class="control-label" for="website">Website</label>
                <div class="controls">
                    {{ Form::text('website', (isset($entry) ? $entry->website : Input::old('website')), array('id'=>'website', 'class'=>'input-xlarge')) }}
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
        <h3>Select Location on Map</h3>
        </div>
        <div class="modal-body">
            <div class="control-group hide">
                <label class="col-sm-1 control-label">Location:</label>

                <div class="col-sm-5">
                    <input type="text" id="map-address" placeholder="Enter a location" autocomplete="off">
                </div>
            </div>
            <!--/span-->
            <div id="location-picker" style="width: 530px; height: 400px;"></div>

            <div class="row-fluid hide">
                <div class="span6">
                    <label class="p-r-small col-sm-1 control-label">Latitude:</label>

                    <div class="col-sm-2">
                        <input type="text" id="map-lat" name="map-lat" style="width: 110px" class="form-control" value="{{ $entry->location['latitude'] or '' }}">
                    </div>
                </div>
                <div class="span6">
                    <label class="p-r-small col-sm-1 control-label">Longitude:</label>

                    <div class="col-sm-2">
                        <input type="text" id="map-lon" name="map-lon" style="width: 110px" class="form-control" value="{{ $entry->location['longitude'] or '' }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn">Close</button>
            <button type="button" class="btn btn-primary" id="save-changes">Save changes</button>
        </div>
    </div>
</div>

<div class="form-actions">
    <button type="submit" class="btn btn-primary" name="form_save">Save</button>
    <button type="submit" class="btn btn-success" name="form_save_new">Save &amp;  New</button>
    <button type="submit" class="btn btn-primary btn-danger" name="form_close">Close</button>
</div>
{{ Form::close() }}
