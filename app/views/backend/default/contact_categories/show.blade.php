@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="widget-title">
                    <h4><i class="icon-table"></i> All Contacts in Category "{{ $category->name }}"</h4>
                </div>
                <div class="widget-body">
                    <table class="table table-striped table-hover table-bordered" id="sample_1">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Country</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($category->contacts as $contact)
                                <tr>
                                    <td>{{ HTML::link("backend/contact-manager/{$contact->id}/18", $contact->name) }}</td>
                                    <td>{{ $contact->address }}</td>
                                    <td>{{ $contact->country }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop
