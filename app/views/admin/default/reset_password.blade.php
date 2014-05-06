@section('content')
    @if ($errors->any())
        <div class="alert alert-error">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Error!</strong><br> {{ implode('<br>', $errors->all()) }}
        </div>
    @endif
    <!-- BEGIN LOGIN FORM -->
    {{ Form::open(array('url'=>'login/backend', 'method'=>'POST', 'class'=>'form-vertical no-padding no-margin')) }}
        <p class="center">Enter your new password.</p>
        <div class="control-group">
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on"><i class="icon-lock"></i></span>
                    {{ Form::password('password', array('id'=>'input-password', 'placeholder' => 'Password')) }}
                </div>
            </div>
        </div>
        <input type="submit" id="login-btn" class="btn btn-block btn-inverse" value="Reset Password" />
    {{ Form::close() }}
    <!-- END LOGIN FORM -->

@stop
