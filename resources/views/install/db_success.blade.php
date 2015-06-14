@extends ('install._layout')

@section('content')
    <p>Connection with the database can be established.</p>

    <p>Review the following settings before continuing with the installation.</p>

    <table class="form-table">
        <tr>
            <th scope="row">Database Name</th>
            <td>{!! Config::get('database.connections.mysql.database') !!}</td>
        </tr>
        <tr>
            <th scope="row">User Name</th>
            <td>{!! Config::get('database.connections.mysql.username') !!}</td>
        </tr>
        <tr>
            <th scope="row">Password</th>
            <td>{!! Config::get('database.connections.mysql.password') !!}</td>
        </tr>
        <tr>
            <th scope="row">Database Host</th>
            <td>{!! Config::get('database.connections.mysql.host') !!}</td>
        </tr>
    </table>

    {!! HTML::link('install/3', 'Run the installation', array('class'=>'button button-large')) !!}
@stop
