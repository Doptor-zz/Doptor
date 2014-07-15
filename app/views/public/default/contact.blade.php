@section('styles')
@stop

@section('content')
    <div class="indent">

        @if (isset($post->extras['contact_coords']))
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

            <div class="grid_8">
                <h4 class="alt-title">send us mail:</h4>

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
                            </ul>
                        </div>
                    @endif
                </div>

                <!-- BEGIN CONTACT FORM -->
                {{ Form::open(array('url'=>'contact', 'id'=>'contact-form', 'class'=>'contact-form')) }}
                    <div class="grid_5 alpha">
                        <div class="field clearfix">
                            {{ Form::textarea('comments', Input::old('comments'), array('id'=>'comments', 'cols'=>'30', 'rows'=>'10', 'placeholder'=>'your comment...')) }}
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

            @if ($post->content != '')
                <div class="grid_4">
                    <div class="prefix_1_2">
                        <h4 class="alt-title">contacts:</h4>

                        {{ $post->content }}

                    </div>
                </div>
            @endif

        </div>

    </div>
@stop

@section('scripts')
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    {{ HTML::script('assets/public/default/js/jquery.ui.map.js') }}

    @if (isset($post->extras['contact_coords']))
        <script type="text/javascript">
            $(document).ready(function(){
                var zoom= $('#map_canvas').gmap('option', 'zoom');

                $('#map_canvas').gmap().bind('init', function(ev, map) {
                    $('#map_canvas').gmap('addMarker', {'position': '{{ $post->extras['contact_coords'] }}', 'bounds': true});
                    $('#map_canvas').gmap('option', 'zoom', 12);
                });
            });
        </script>
    @endif
@stop
