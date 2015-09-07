@extends ('install._layout')

@section('style')
    <style>
        #loading-wrapper {
            width: 100%;
        }
        #loading {
            font-size: 20px;
            position: fixed;
            top: 50%;
            left: 50%;
            margin-left: -150px;
            margin-top: -41px;
            width: 300px;
            padding: 30px;
            background: #DDD;
            z-index: 99;
        }
        #popup-bg {
            background: rgba(92, 92, 92, 0.9);
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9;
        }
        .overflow-hidden {
            overflow: hidden !important;
        }
    </style>
@stop

@section('content')
<div>

    <h1>Website Configuration</h1>
    <p>Please provide the following information. Don’t worry, you can always change these settings later.</p>
    <p>All the fields are required.</p>

    {!! Form::open(array('url'=>'install/configure/3', 'method'=>'POST', 'id'=>'site-config')) !!}
        <table class="form-table">
            <tbody>
                <tr>
                    <th scope="row"><label for="username">Username</label></th>
                    <td>
                        {!! Form::text('username', Input::old('username')) !!}
                    </td>
                    <td>
                        {!! $errors->first('username', '<span class="red">:message</span>') !!}
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="email">Email Address</label></th>
                    <td>
                        {!! Form::text('email', Input::old('email')) !!}
                    </td>
                    <td>
                        {!! $errors->first('email', '<span class="red">:message</span>') !!}
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="first_name">First Name</label></th>
                    <td>
                        {!! Form::text('first_name', Input::old('first_name')) !!}
                    </td>
                    <td>
                        {!! $errors->first('first_name', '<span class="red">:message</span>') !!}
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="last_name">Last Name</label></th>
                    <td>
                        {!! Form::text('last_name', Input::old('last_name')) !!}
                    </td>
                    <td>
                        {!! $errors->first('last_name', '<span class="red">:message</span>') !!}
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="password">Password</label>
                    </th>
                    <td>
                        <input name="password" type="password" id="pass1" size="25" value="">
                    </td>
                    <td>
                        {!! $errors->first('password', '<span class="red">:message</span>') !!}
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="password">Confirm Password</label>
                    </th>
                    <td>
                        <p><input name="password_confirmation" type="password" id="pass2" size="25" value=""></p>
                    </td>
                    <td>
                        {!! $errors->first('password_confirmation', '<span class="red">:message</span>') !!}
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label>Time Zone</label></th>
                    <td>
                        {!! Form::select('time_zone', timezoneList(), 'UTC') !!}
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row"><label for="">Install Sample Data</label></th>
                    <td>
                        {!! Form::checkbox('sample_data', 'true') !!}
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="step">
            <input type="submit" value="Install" class="button button-large">
        </p>
    {!! Form::close() !!}

    <div id="loading-wrapper" style="display:none;">
        <div id="loading">
            Doptor is installing. Please wait ...
        </div>
    </div>
    <div id="popup-bg" style="display:none;"></div>
</div>
@stop

@section('scripts')
    <script>
        var site_config = document.getElementById('site-config');

        if (site_config.addEventListener) {
            site_config.addEventListener("submit", submitForm, false);
        } else {
            site_config.attachEvent('onsubmit', submitForm);
        }

        function submitForm(e) {
            var loading_div = document.getElementById('loading-wrapper');

            loading_div.removeAttribute('style');

            var popup_bg = document.getElementById('popup-bg');

            popup_bg.removeAttribute('style');

            document.body.className = 'overflow-hidden';
        }
    </script>
@stop
