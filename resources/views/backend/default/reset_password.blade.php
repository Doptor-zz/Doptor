@section('content')
    @if ($errors->any())
        <div class="alert alert-error">
            <button class="close" data-dismiss="alert">×</button>
            <strong>{!! trans('cms.error') !!}</strong><br> {!! implode('<br>', $errors->all()) !!}
        </div>
    @endif

    @if ($errors->has('invalid_reset_code'))
        <!-- BEGIN FORGOT PASSWORD FORM -->
        {!! Form::open(array('url'=>'forgot_password', 'method'=>'POST', 'class'=>'form-vertical no-padding no-margin')) !!}
            <p class="center">{!! trans('password_reset.enter_email') !!}</p>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-envelope"></i></span>
                        <input id="input-email" type="text" placeholder="{!! trans('fields.email') !!}" name="email" />
                    </div>
                </div>
                <div class="space10"></div>
            </div>
            <input type="submit" id="forget-btn" class="btn btn-block btn-inverse" value="Submit" />
        {!! Form::close() !!}
        <!-- END FORGOT PASSWORD FORM -->
    @else
        {!! Form::open(array('url'=>'reset_password', 'method'=>'POST', 'class'=>'form-vertical no-padding no-margin')) !!}
            {!! Form::hidden('id', $id) !!}
            {!! Form::hidden('token', $token) !!}
            {!! Form::hidden('target', $target) !!}

            <h5>{!! trans('password_reset.reset_form') !!}</h5>

            <p class="center">{!! trans('password_reset.username') !!}</p>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-user"></i></span>
                        {!! Form::text('username', Input::old('username'), array('id'=>'input-username', 'placeholder' => trans('fields.username'))) !!}
                    </div>
                </div>
            </div>

            <p class="center">{!! trans('password_reset.security_question') !!}</p>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-question-sign"></i></span>
                        {!! Form::text('security_question', $user->security_question, array('id'=>'input-security_question', 'placeholder' => trans('config.security_question'), 'disabled')) !!}
                    </div>
                </div>
            </div>

            <p class="center">{!! trans('password_reset.security_question') !!}</p>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-question-sign"></i></span>
                        {!! Form::text('security_answer', Input::old('security_answer'), array('id'=>'input-security_answer', 'placeholder' => trans('config.security_answer'))) !!}
                    </div>
                </div>
            </div>

            <p class="center">{!! trans('password_reset.new_password') !!}</p>
            <div class="control-group">
                <div class="controls">
                    <div class="input-prepend">
                        <span class="add-on"><i class="icon-lock"></i></span>
                        {!! Form::password('password', array('id'=>'input-password', 'placeholder' => trans('fields.password'))) !!}
                    </div>
                </div>
            </div>
            <input type="submit" id="login-btn" class="btn btn-block btn-inverse" value="Reset {!! trans('fields.password') !!}" />
        {!! Form::close() !!}
    @endif

@stop
