@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box light-gray tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        @if (!isset($menu_cat))
                            <span class="hidden-480">Create New Menu Category</span>
                        @else
                            <span class="hidden-480">Edit Existing Menu Category</span>
                        @endif
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                @if (!isset($menu_cat))
                                {{ Form::open(array('route'=>$link_type . '.menu-categories.store', 'method'=>'POST', 'class'=>'form-horizontal')) }}
                                @else
                                {{ Form::open(array('route' => array($link_type . '.menu-categories.update', $menu_cat->id), 'method'=>'PUT', 'class'=>'form-horizontal')) }}
                                @endif

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           You have some form errors. Please check below.
                                        </div>
                                    @endif


                                    <div class="control-group {{{ $errors->has('name') ? 'error' : '' }}}">
                                        <label class="control-label">Name <span class="red">*</span></label>
                                        <div class="controls">
                                            {{ Form::text('name', (!isset($menu_cat)) ? Input::old('name') : $menu_cat->name, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('name', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('menu_type') ? 'error' : '' }}}">
                                        <label class="control-label">Menu Location <span class="red">*</span></label>
                                        <div class="controls">
                                            {{ Form::select('menu_type', MenuCategory::menu_positions(), (!isset($menu_cat)) ? Input::old('menu_type') : $menu_cat->menu_type, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('menu_type', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="control-group {{{ $errors->has('description') ? 'error' : '' }}}">
                                        <label class="control-label">Description</label>
                                        <div class="controls">
                                            {{ Form::text('description', (!isset($menu_cat)) ? Input::old('description') : $menu_cat->description, array('class' => 'input-xlarge'))}}
                                            {{ $errors->first('description', '<span class="help-inline">:message</span>') }}
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> Save</button>
                                    </div>
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
