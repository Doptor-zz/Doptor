@section('styles')
@stop

@section('content')
<div class="container">
    <div class="row margin-bottom-40">
        <!-- BEGIN CONTENT -->
        <div class="col-md-12">
            <h1>Contacts</h1>
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

                        <!-- BEGIN CONTACT FORM -->
                        {!! Form::open(array('url'=>'contact', 'id'=>'contact-form', 'class'=>'contact-form')) !!}
                        <div class="grid_5 alpha">
                            <div class="form-group">
                                {!! Form::textarea('comments', Input::old('comments'), array('id'=>'comments', 'cols'=>'30', 'rows'=>'10', 'placeholder'=>'your comment...')) !!}
                            </div>
                        </div>
                        <div class="grid_3 omega">
                            <div class="form-group">
                                {!! Form::text('name', Input::old('name'), array('id'=>'name', 'placeholder'=>'your name...')) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('email', Input::old('email'), array('id'=>'email', 'placeholder'=>'your email...')) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::text('subject', Input::old('subject'), array('id'=>'subject', 'placeholder'=>'your subject...')) !!}
                            </div>
                            <div class="btn-wrapper">
                                <input type="submit" id="submit" value="send"/><i class="btn-marker"></i>
                            </div>
                            <div id="response"></div>
                        </div>
                        {!! Form::close() !!}
                        <!-- END CONTACT FORM -->

                        <div class="col-md-3 col-sm-3 sidebar2">
                            @if ($post->content != '')
                            <h2>Our Contacts:</h2>

                            {!! $post->content !!}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
    </div>
</div>
@stop

@section('scripts')
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    {!! HTML::script('assets/public/default/js/jquery.ui.map.js') !!}

    @if (isset($post->extras['contact_coords']))
        <script type="text/javascript">
            $(document).ready(function(){
                var zoom= $('#map_canvas').gmap('option', 'zoom');

                $('#map_canvas').gmap().bind('init', function(ev, map) {
                    $('#map_canvas').gmap('addMarker', {'position': '{!! $post->extras['contact_coords'] !!}', 'bounds': true});
                    $('#map_canvas').gmap('option', 'zoom', 12);
                });
            });
        </script>
    @endif
@stop
