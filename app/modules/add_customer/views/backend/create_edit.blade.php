@extends('backend.default._layouts._layout')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="widget-title">
                    <h4>
                        <span>{{ $title }}</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                <?php $link_type = ($link_type=="public") ? "" : $link_type . "." ?>
@if (!isset($entry))
{{ Form::open(array("route"=>"{$link_type}modules.".$module_name.".store", "method"=>"POST", "class"=>"form-horizontal", "files"=>true)) }}
@else
{{ Form::open(array("route" => array("{$link_type}modules.".$module_name.".update", $entry->id), "method"=>"PUT", "class"=>"form-horizontal", "files"=>true)) }}
@endif

<fieldset>

<!-- Form Name -->
<legend>Add Customer</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="customer_name">Customer Name</label>
  <div class="controls">
    <input id="customer_name" name="customer_name" placeholder="Customer Name" class="input-xlarge" type="text">
    <p class="help-block">Customer Name</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="customer_email">Customer Email</label>
  <div class="controls">
    <input id="customer_email" name="customer_email" placeholder="Customer Email" class="input-xlarge" type="text">
    <p class="help-block">Customer Email</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="customer_phone">Customer Phone No.</label>
  <div class="controls">
    <input id="customer_phone" name="customer_phone" placeholder="Customer Phone No." class="input-xlarge" type="text">
    <p class="help-block">Customer Phone No.</p>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label" for="customer_address">Customer Address</label>
  <div class="controls">
    <input id="customer_address" name="customer_address" placeholder="Customer Address" class="input-xlarge" type="text">
    <p class="help-block">Customer Address</p>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label" for="submit">Submit</label>
  <div class="controls">
    <button id="submit" name="submit" type="submit" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>

{{ Form::close() }}
                                <!-- END FORM-->
                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END FORM widget-->
        </div>
    </div>
@stop

@section('scripts')
    @parent

    @if (isset($entry))
        <script>
           jQuery(document).ready(function() {
                @foreach ($fields as $field)
                    $('#{{ $field }} ').val('{{ $entry->{$field} }}');
                @endforeach
           });
        </script>
    @endif
@stop
