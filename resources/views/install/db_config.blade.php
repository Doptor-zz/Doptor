@extends ('install._layout')

@section('content')
    {!! Form::open(array('url'=>'install/configure', 'method'=>'POST')) !!}
        <p>Below you should enter your configuration details. If you&#8217;re not sure about these, contact your host.</p>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="db_database">Database Name</label></th>
                <td><input name="DB_DATABASE" id="db_database" type="text" size="25" value="cms" /></td>
                <td>The name of the database you want to run the system in.</td>
            </tr>
            <tr>
                <th scope="row"><label for="username">User Name</label></th>
                <td><input name="DB_USERNAME" id="username" type="text" size="25" value="root" /></td>
                <td>Your MySQL username</td>
            </tr>
            <tr>
                <th scope="row"><label for="password">Password</label></th>
                <td><input name="DB_PASSWORD" id="password" type="password" size="25" value="" /></td>
                <td>&hellip;and your MySQL password.</td>
            </tr>
            <tr>
                <th scope="row"><label for="db_host">Database Host</label></th>
                <td><input name="DB_HOST" id="db_host" type="text" size="25" value="127.0.0.1" /></td>
                <td>You should be able to get this info from your web host, if <code>localhost</code> does not work.</td>
            </tr>
        </table>
            <p class="step">
                <input type="submit" value="Submit" class="button button-large" />
            </p>
    {!! Form::close() !!}
@stop
