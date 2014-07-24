@section('styles')
@stop

@section('content')
    <div class="indent">

        @if ($contact->location != '')
            <div class="container">
                <div class="grid_12">

                    <!-- BEGIN GOOGLE MAP -->
                    <div class="map-wrapper">
                        <div id="map_canvas"></div>
                    </div>
                    <!-- END GOOGLE MAP -->

                </div>
            </div>
        @endif

        <div class="container">
            <h1>Contact {{ $contact->name }}</h1>
            <div class="grid_8">
                <h4 class="alt-title">Send mail:</h4>

                <div id="errors-div">
                    @if (Session::has('error_message'))
                        <div class="alert alert-error">
                            <strong>Error!</strong> {{ Session::get('error_message') }}
                        </div>
                    @endif
                    @if (Session::has('success_message'))
                        <div class="alert alert-success">
                            <strong>Success!</strong> {{ Session::get('success_message') }}
                        </div>
                    @endif
                    @if( $errors->count() > 0 )
                        <div class="alert alert-error">
                            <p>The following errors have occurred:</p>
                            <ul id="form-errors">
                                {{ $errors->first('email', '<li>:message</li>') }}
                                {{ $errors->first('name', '<li>:message</li>') }}
                                {{ $errors->first('message', '<li>:message</li>') }}
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- BEGIN CONTACT FORM -->
                {{ Form::open(array('url'=>"contact/{$contact->alias}/send", 'id'=>'contact-form', 'class'=>'contact-form')) }}
                    <div class="grid_5 alpha">
                        <div class="field clearfix">
                            {{ Form::textarea('message', Input::old('message'), array('id'=>'message', 'cols'=>'30', 'rows'=>'10', 'placeholder'=>'your comment...')) }}
                        </div>
                    </div>
                    <div class="grid_3 omega">
                        <div class="field clearfix">
                            {{ Form::text('name', Input::old('name'), array('id'=>'name', 'placeholder'=>'your name...')) }}
                        </div>
                        <div class="field clearfix">
                            {{ Form::text('email', Input::old('email'), array('id'=>'email', 'placeholder'=>'your email...')) }}
                        </div>
                        <div class="field clearfix">
                            {{ Form::text('subject', Input::old('subject'), array('id'=>'subject', 'placeholder'=>'your subject...')) }}
                        </div>
                        <div class="btn-wrapper">
                            <input type="submit" id="submit" value="send"/><i class="btn-marker"></i>
                        </div>
                        <div id="response"></div>
                    </div>
                {{ Form::close() }}
                <!-- END CONTACT FORM -->

            </div>

            <div class="grid_4">
                <h4 class="alt-title">Contact Info:</h4>
                @foreach ($fields as $field_name => $field)
                    <h4 class="inline">{{ $field_name }}</h4>
                    @if ($field == 'image')
                        <span>{{ HTML::image($contact->{$field}) }}</span>
                    @elseif ($field == 'location')
                        {{-- Display contact location in map instead --}}
                    @else
                        <span>{{ $contact->{$field} }}</span>
                    @endif
                    <br>
                @endforeach
            </div>

        </div>

    </div>
@stop

@section('scripts')
    {{ HTML::script('assets/public/default/js/jquery.ui.map.js') }}

    @if ($contact->location != '')
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var zoom= $('#map_canvas').gmap('option', 'zoom');

                $('#map_canvas').gmap().bind('init', function(ev, map) {
                    $('#map_canvas').gmap('addMarker', {
                        'position': '{{ $contact->location['latitude'] }}, {{ $contact->location['longitude'] }}',
                        'bounds': true
                    });
                    $('#map_canvas').gmap('option', 'zoom', 12);
                });
            });
        </script>
    @endif
@stop
