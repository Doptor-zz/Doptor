@section('styles')
    {!! HTML::style("assets/public/$current_theme/js/form/sky-forms.css") !!}
@stop

@section('content')

    <div class="container">

        <div class="content_fullwidth">

            <div class="two_third">
                <h1>Contact {!! $contact->name !!}</h1>

                @if ($contact->location != '')
                    <div class="one_full">
                        <!-- BEGIN GOOGLE MAP -->
                        <div class="map-wrapper">
                            <div id="map_canvas" class="google-map3"></div>
                        </div>
                        <!-- END GOOGLE MAP -->
                    </div>
                    <br><br>
                @endif
                <div class="cforms">

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
                                    {!! $errors->first('message', '<li>:message</li>') !!}
                                </ul>
                            </div>
                        @endif
                    </div>

                    <!-- BEGIN CONTACT FORM -->
                    {!! Form::open(array('url'=>"contact/{$contact->alias}/send", 'id'=>'sky-form', 'class'=>'sky-form')) !!}
                        <header>Send mail:</header>
                        <fieldset>
                            <div class="row">
                                <section class="col col-6">
                                    <label class="label">Name</label>
                                    <label class="input"> <i class="icon-append icon-user"></i>
                                    {!! Form::text('name', Input::old('name'), array('id'=>'name', 'placeholder'=>'Name...')) !!}
                                    </label>
                                </section>
                                <section class="col col-6">
                                    <label class="label">E-mail</label>
                                    <label class="input"> <i class="icon-append icon-envelope-alt"></i>
                                        {!! Form::text('email', Input::old('email'), array('id'=>'email', 'placeholder'=>'Email...')) !!}
                                    </label>
                                </section>
                            </div>
                            <section>
                                <label class="label">Subject</label>
                                <label class="input"> <i class="icon-append icon-tag"></i>
                                {!! Form::text('subject', Input::old('subject'), array('id'=>'subject', 'placeholder'=>'Subject...')) !!}
                                </label>
                            </section>
                            <section>
                                <label class="label">Message</label>
                                <label class="textarea"> <i class="icon-append icon-comment"></i>
                                    {!! Form::textarea('message', Input::old('message'), array('id'=>'message', 'cols'=>'30', 'rows'=>'10', 'placeholder'=>'Message...')) !!}
                                </label>
                            </section>

                        </fieldset>
                    {!! Form::close() !!}
                    <!-- END CONTACT FORM -->

                </div>

            </div>
            <div class="one_third last">
                <div class="address_info two">
                    <h3>Contact Info:</h3>
                    <ul>
                        @foreach ($fields as $field_name => $field)
                            <li>
                                <strong>{!! $field_name !!}</strong>
                                @if ($field == 'image')
                                    <span>{!! HTML::image($contact->{$field}) !!}</span>
                                @elseif ($field == 'location')
                                    {{-- Display contact location in map instead --}}
                                @else
                                    <span>{!! $contact->{$field} !!}</span>
                                @endif
                                <br>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
@stop

@section('scripts')
    @if ($contact->location != '')

        {!! HTML::script("assets/public/$current_theme/js/jquery.ui.map.js") !!}
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                var zoom= $('#map_canvas').gmap('option', 'zoom');

                $('#map_canvas').gmap().bind('init', function(ev, map) {
                    $('#map_canvas').gmap('addMarker', {
                        'position': '{!! $contact->location['latitude'] !!}, {!! $contact->location['longitude'] !!}',
                        'bounds': true
                    });
                    $('#map_canvas').gmap('option', 'zoom', 12);
                });
            });
        </script>
    @endif
@stop
