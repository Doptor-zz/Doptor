@section('style')
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <?php $link_type = ($link_type=="public") ? "" : $link_type . "." ?>
            {{ Form::open(array("route"=>"{$link_type}form.store", "method"=>"POST", "class"=>"form-horizontal")) }}

                <div id="errors-div">
                    @if ($errors->has())
                         <div class="alert alert-error hide" style="display: block;">
                           <button data-dismiss="alert" class="close">×</button>
                           You have some form errors. Please check below.
                        </div>
                    @endif
                </div>
                <div class="btn-group pull-right">
                    <a href="{{ URL::to(str_replace('.', '', $link_type) . '/form/' . $form->id . '/list') }}" class="btn btn-success">
                        View Entries
                    </a>
                </div>
                {{ Form::hidden('form_id', $form->id) }}
                {{ $form->rendered }}

                @if ($form->show_captcha)
                    <div class="control-group {{{ $errors->has("captcha") ? "error" : "" }}}">
                        <label class="control-label">Enter captcha</label>
                        <div class="controls">
                            {{ HTML::image(Captcha::img(), "Captcha image") }}
                            {{ Form::text("captcha", "", array("required", "class"=>"input-medium")) }}
                            {{ $errors->first("captcha", "<span class=\'help-inline\'>:message</span>") }}
                        </div>
                    </div>
                @endif

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Send</button>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@stop

@section('scripts')
@stop
