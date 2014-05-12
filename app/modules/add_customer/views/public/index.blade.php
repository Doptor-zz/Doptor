@section('content')

<section class="indent">
    <div class="container">
        <div class="accordion-wrapper grid_12">

            <h1>{{ $title }}</h1>

            @if (Session::has('error_message'))
                <div class="grid_8">
                    <div class="alert alert-error nomargin">
                        Error! {{ Session::get('error_message') }}
                    </div>
                </div>
                <div class="clearfix"></div>
            @endif
            @if (Session::has('success_message'))
                <div class="grid_8">
                    <div class="alert alert-success nomargin">
                        Success! {{ Session::get('success_message') }}
                    </div>
                </div>
                <div class="clearfix"></div>
            @endif

            <div class="pull-right">
                <a href="{{ url('modules/'.$module_name.'/create') }}" class="pill pill-style1">
                    <span class="pill-inner">Add new</span>
                </a>
            </div>
            <div class="clearfix"></div>
            <br>
            <table class="default-table">
                <thead>
                    <tr>
                        @foreach ($fields as $field)
                            <th>{{ Str::title($field) }}</th>
                        @endforeach
                        <th class="span2"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($entries as $entry)
                        <tr>
                            @foreach ($fields as $field)
                                <td>{{ $entry->{$field} }}</td>
                            @endforeach
                            <td>

                                <a href="{{ URL::to('modules/' . $module_name .'/' . $entry->id . '/edit') }}" class="pill pill-small"><i class="pill-inner">Edit</i></a>

                                <div class="actions inline">
                                    <div class="pill pill-small">
                                        <i class="pill-inner"> Actions</i>
                                    </div>
                                    <ul class="pill pill-small">
                                        <li>
                                            {{ Form::open(array('route' => array('modules.'.$module_name.'.destroy', $entry->id), 'method' => 'delete', 'class'=>'inline')) }}
                                                <button type="submit" class="danger"><i class="icon-trash" onclick="return deleteRecord($(this))"></i> Delete</button>
                                            {{ Form::close() }}
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
</section>

@stop

@section('scripts')
    @parent
    <script>
       function deleteRecord(th) {
           doDelete = confirm("Are you sure you want to delete the entry?");
           if (!doDelete) {
               return false;
           }
       }
    </script>
    <!-- END PAGE LEVEL SCRIPTS -->
@stop
