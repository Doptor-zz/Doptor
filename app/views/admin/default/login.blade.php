@section('content')
    @if ($errors->any())
        <div class="alert alert-error">
            <button class="close" data-dismiss="alert">×</button>
            <strong>Error!</strong><br> {{ implode('<br>', $errors->all()) }}
        </div>
    @endif

    <div class="container">
        {{ Form::open(array('url'=>'login/admin', 'method'=>'POST', 'class'=>'form-signin')) }}
            <h3 class="form-signin-heading">Please sign in</h3>
            <div class="controls input-icon">
                <i class=" icon-user-md"></i>
                {{ Form::text('username', Input::old('username'), array('class'=>'input-block-level', 'placeholder' => 'Username')) }}
            </div>
            <div class="controls input-icon">
                <i class=" icon-key"></i>
                {{ Form::password('password', array('class'=>'input-block-level', 'placeholder' => 'Password')) }}
            </div>
            <label class="checkbox">
                {{ Form::checkbox('remember', 'checked', true) }}
                Remember me
            </label>
            <button class="btn btn-inverse btn-block" type="submit">Sign in</button>
        {{ Form::close() }}
    </div>
@stop
