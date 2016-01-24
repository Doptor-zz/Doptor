@section('content')
    @if ($errors->any())
        <div class="alert alert-error">
            <button class="close" data-dismiss="alert">×</button>
            <strong>{!! trans('cms.error') !!}</strong><br> {!! implode('<br>', $errors->all()) !!}
        </div>
    @endif
    <!-- BEGIN LOGIN FORM -->
    {!! Form::open(array('url'=>'login/backend', 'method'=>'POST', 'class'=>'form-vertical no-padding no-margin')) !!}
        <p class="center">{!! trans('users.enter_username_pw') !!}</p>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-user"></i></span>
                    {!! Form::text('username', Input::old('username'), array('id'=>'input-username', 'placeholder' => 'Username')) !!}
                </div>
            </div>
        </div>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    {!! Form::password('password', array('id'=>'input-password', 'placeholder' => 'Password')) !!}
                </div>
            </div>
        </div>
        <div class="control-group remember-me">
            <div class="controls">
                <label class="checkbox">
                    {!! Form::checkbox('remember', 'checked', true) !!}
                    {!! trans('users.remember_me') !!}
                </label>
                <a href="javascript:;" class="pull-right" id="forget-password">{!! trans('users.forgot_pw') !!}</a>
            </div>
        </div>
        <input type="submit" id="login-btn" class="btn btn-block btn-inverse" value="{!! trans('users.login') !!}" />
    {!! Form::close() !!}
    <!-- END LOGIN FORM -->

    <!-- BEGIN FORGOT PASSWORD FORM -->
    {!! Form::open(array('url'=>'forgot_password', 'method'=>'POST', 'id'=>'forgotform', 'class'=>'form-vertical no-padding no-margin hide')) !!}
        <p class="center">{!! trans('users.reset_pw_email') !!}</p>
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
@stop
