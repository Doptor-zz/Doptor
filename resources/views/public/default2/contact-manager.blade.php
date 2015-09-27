@section('styles')
@stop

@section('content')
<div class="container">
    <div class="row margin-bottom-40">
        <!-- BEGIN CONTENT -->
        <div class="col-md-12">
            <h1>Contact {!! $contact->name !!}</h1>
            <div class="content-page">
                <div class="row">
                    <div class="col-md-12">
                        <div id="map" class="gmaps margin-bottom-40" style="height:400px;"></div>
                    </div>
                    <div class="col-md-9 col-sm-9">
                        <div id="errors-div">
                            @if (Session::has('error_message'))
                            <div class="alert alert-error">
                                <strong>Error!</strong> {!! Session::get('error_message') !!}
                            </div>
                            @endif
                            @if (Session::has('success_message'))
                            <div class="alert alert-success">
                                <strong>Success!</strong> {!! Session::get('success_message') !!}
                            </div>
                            @endif
                            @if( $errors->count() > 0 )
                            <div class="alert alert-error">
                                <p>The following errors have occurred:</p>
                                <ul id="form-errors">
                                    {!! $errors->first('email', '<li>:message</li>') !!}
                                    {!! $errors->first('name', '<li>:message</li>') !!}
                                </ul>
                            </div>
                            @endif
                        </div>

                        {!! Form::open(array('url'=>"contact/{$contact->alias}/send", 'id'=>'contact-form', 'class'=>'contact-form', 'role'=>'form')) !!}
                            <div class="form-group">
                                <label for="">Name</label>
                                {!! Form::text('name', Input::old('name'), array('id'=>'name', 'class'=>'form-control', 'placeholder'=>'Name...')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                {!! Form::text('email', Input::old('email'), array('id'=>'email', 'class'=>'form-control', 'placeholder'=>'Email...')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Subject</label>
                                {!! Form::text('subject', Input::old('subject'), array('id'=>'subject', 'class'=>'form-control', 'placeholder'=>'Subject...')) !!}
                            </div>
                            <div class="form-group">
                                <label for="">Message</label>
                                {!! Form::textarea('message', Input::old('message'), array('id'=>'message', 'class'=>'form-control', 'cols'=>'30', 'rows'=>'10', 'placeholder'=>'Message...')) !!}
                            </div>
                            <input type="submit" class="btn btn-primary"><i class="icon-ok"></i></input>
                            <div id="response"></div>
                        {!! Form::close() !!}

                    </div>
                    <div class="col-md-3 col-sm-3 sidebar2">
                        <h2>Contact Info:</h2>
                        @foreach ($fields as $field_name => $field)
                            <h4 class="inline">{!! $field_name !!}: </h4>
                            @if ($field == 'image')
                            <span>{!! HTML::image($contact->{$field}) !!}</span>
                            @elseif ($field == 'location')
                            {{-- Display contact location in map instead --}}
                            @else
                            <span>{!! $contact->{$field} !!}</span>
                            @endif
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
</div>
@stop

@section('scripts')

    @if ($contact->location != '')
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        {!! HTML::script("assets/public/$current_theme/plugins/gmaps/gmaps.js") !!}
        <script type="text/javascript">
                var map;
                $(document).ready(function(){
                  map = new GMaps({
                    div: '#map',
                    lat: {!! $contact->location['latitude'] !!},
                    lng: {!! $contact->location['longitude'] !!}
                  });
                   var marker = map.addMarker({
                        lat: {!! $contact->location['latitude'] !!},
                        lng: {!! $contact->location['longitude'] !!},
                        title: '{!! $contact->name !!}',
                        infoWindow: {
                            content: "<b>{!! $contact->name !!}</b> {!! $contact->address !!}<br>{!! $contact->city !!}, {!! $contact->state !!}"
                        }
                    });

                   marker.infoWindow.open(map, marker);
                });
        </script>
    @endif
@stop
