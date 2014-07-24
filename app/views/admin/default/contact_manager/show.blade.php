@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="widget-title">
                    <h4><i class="icon-table"></i> {{ $contact->name }}</h4>
                </div>
                <div class="widget-body">
                    <form class="form-horizontal">
                        <ul class="nav nav-tabs">
                           <li class="active"><a href="#tab_1_1" data-toggle="tab">Contact Details</a></li>
                           <li><a href="#tab_1_2" data-toggle="tab">Recent Emails</a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1_1">
                                @for ($i=0; $i<count($fields); $i++)
                                    <div class="control-group">
                                        <label class="control-label">{{ $field_names[$i] }}</label>
                                        <div class="controls">
                                            @if ($fields[$i] == 'image')
                                                {{ HTML::image($contact->{$fields[$i]}) }}
                                            @else
                                                {{ $contact->{$fields[$i]} }}
                                            @endif
                                        </div>
                                    </div>
                                @endfor
                                <div class="control-group">
                                    <label class="control-label">Created At</label>
                                    <div class="controls">
                                        {{ $contact->created_at }}
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Updated At</label>
                                    <div class="controls">
                                        {{ $contact->updated_at }}
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="tab_1_2">
                                <table class="table table-striped table-hover table-bordered" id="sample_{{$i}}">
                                    <thead>
                                        <tr>
                                            <th class="span1"><input type="checkbox" class="select_all" /></th>
                                            <th>Sender Name</th>
                                            <th>Sender Email</th>
                                            <th>Subject</th>
                                            <th>Message</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contact->emails as $contact_email)
                                            <tr>
                                                <td>{{ Form::checkbox($contact_email->id, 'checked', false) }}</td>
                                                <td>{{ $contact_email->name }}</td>
                                                <td>{{ $contact_email->email }}</td>
                                                <td>{{ $contact_email->subject }}</td>
                                                <td>{{ $contact_email->message }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop
