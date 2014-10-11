@section('style')
@stop

@section('content')
    <section class="indent">
        <div class="container">
            <div class="grid_12">
                <?php $link_type = ($link_type=="public") ? "" : $link_type . "." ?>
                {{ Form::open(array("route"=>"{$link_type}form.store", "method"=>"POST", "class"=>"form-horizontal")) }}

                    <div id="errors-div">
                        @if (Session::has('error_message'))
                            <div class="alert alert-error">
                                <button data-dismiss="alert" class="close">×</button>
                                <strong>Error!</strong> {{ Session::get('error_message') }}
                            </div>
                        @endif
                        @if (Session::has('success_message'))
                            <div class="alert alert-success">
                                <button data-dismiss="alert" class="close">×</button>
                                <strong>Success!</strong> {{ Session::get('success_message') }}
                            </div>
                        @endif
                        @if ($errors->has())
                             <div class="alert alert-error hide" style="display: block;">
                               <button data-dismiss="alert" class="close">×</button>
                               You have some form errors. Please check below.
                            </div>
                        @endif
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
    </section>
@stop

@section('scripts')
    <script>
        $(function() {
            // Repopulate input fields with old data, in case of validation error(s)
            var old_inputs = {{ json_encode(Input::old()) }};
            delete(old_inputs._token);
            delete(old_inputs.input_name);
            delete(old_inputs.captcha);

            $('input, textarea, select').each(function() {
                var input_name = $(this).attr('name');
                if (old_inputs[input_name] !== undefined) {
                    $(this).val(old_inputs[input_name]);
                }
            });
        }());
    </script>
@stop
