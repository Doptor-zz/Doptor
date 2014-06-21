@section('styles')
    <link href="{{ URL::to('assets/backend/default/plugins/bootstrap-formbuilder/css/custom.css') }}" rel="stylesheet" />
    <style>
        #styler { top:0; }
    </style>
@stop

@section('content')
    <div class="row-fluid clearfix">
        <!-- Building Form. -->
        <div class="span6">
            <div class="widget box blue clearfix">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-reorder"></i>
                        <span class="hidden-480">Your Form</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body">
                    @if (!isset($form))
                    {{ Form::open(array('route'=>$link_type . '.form-builder.store', 'method'=>'POST', 'class'=>'form-horizontal', 'id'=>'form-builder')) }}
                    @else
                    {{ Form::open(array('route'=>array($link_type . '.form-builder.update', $form->id), 'method'=>'PUT', 'class'=>'form-horizontal', 'id'=>'form-builder')) }}
                    @endif

                        @if ($errors->has())
                             <div class="alert alert-error hide" style="display: block;">
                               <button data-dismiss="alert" class="close">×</button>
                               You have some form errors. Please check below.
                               {{ $errors->first('name', '<br><span>:message</span>') }}
                            </div>
                        @endif

                        <div class="control-group {{{ $errors->has('category') ? 'error' : '' }}}">
                            <label class="control-label">Form Category <span class="red">*</span></label>
                            <div class="controls">

                                {{ Form::hidden('name', '', array('id'=>'form-name')) }}
                                @if (isset($form))
                                {{ Form::select('category', FormCategory::all_categories(), $form->category, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px;')) }}
                                @else
                                {{ Form::select('category', FormCategory::all_categories(), '', array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px;')) }}
                                @endif
                                {{ Form::hidden('rendered', '', array('id'=>'form-data')) }}

                                {{ $errors->first('category', '<span class="help-inline">:message</span>') }}

                                {{ HTML::link("$link_type/form-categories/create", "Add Category", array('class'=>'btn btn-mini')) }}
                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('description') ? 'error' : '' }}}">
                            <label class="control-label">Form Description</label>
                            <div class="controls">

                                @if (isset($form))
                                <textarea name="description" rows="3" class="input-xlarge">{{ $form->description }}</textarea>
                                @else
                                <textarea name="description" rows="3" class="input-xlarge"></textarea>
                                @endif

                                {{ $errors->first('description', '<span class="help-inline">:message</span>') }}

                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('redirect_to') ? 'error' : '' }}}">
                            <label class="control-label">Redirect to after saving</label>
                            <div class="controls">

                                @if (isset($form))
                                {{ Form::select('redirect_to', BuiltForm::redirect_to(), $form->redirect_to, array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px;')) }}
                                @else
                                {{ Form::select('redirect_to', BuiltForm::redirect_to(), '', array('class'=>'chosen span6 m-wrap', 'style'=>'width:285px;')) }}
                                @endif

                                {{ $errors->first('redirect_to', '<span class="help-inline">:message</span>') }}

                            </div>
                        </div>

                        <div class="control-group {{{ $errors->has('extra_code') ? 'error' : '' }}}">
                            <label class="control-label">Extra code</label>
                            <div class="controls">

                                @if (isset($form))
                                <textarea name="extra_code" rows="3" class="input-xlarge">{{ $form->extra_code }}</textarea>
                                @else
                                <textarea name="extra_code" rows="3" class="input-xlarge"></textarea>
                                @endif

                                <span class="help-inline">Write php code within &lt;?php ?&gt; and javascript code within &lt;script&gt;&lt;/script&gt;</span>

                                {{ $errors->first('extra_code', '<span class="help-inline">:message</span>') }}

                            </div>
                        </div>

                        @if (isset($form))
                        <textarea id="json-data" class="hide" name="data">{{ str_replace('\\', '', $form->data) }}</textarea>
                        @else
                        <textarea id="json-data" class="hide" name="data"></textarea>
                        @endif

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save Form</button>
                        </div>

                    {{ Form::close() }}
                    <div id="build">
                        <form id="target" class="form-horizontal">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Building Form. -->

        <!-- Components -->
        <div class="span6">
            <div class="widget light-gray box">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-reorder"></i>
                        <span class="hidden-480">Drag &amp; Drop Components</span>
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body tabbable">
                    <ul class="nav nav-tabs" id="formtabs">
                        <!-- Tab nav -->
                    </ul>
                    <form class="form-horizontal" id="components">
                        <fieldset>
                            <div class="tab-content">
                                <!-- Tabs of snippets go here -->
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <!-- / Components -->

    </div>
@stop

@section('scripts')
    <script data-main="{{ URL::to('assets/backend/default/plugins/bootstrap-formbuilder/js/main-built.js') }}" src="{{ URL::to('assets/backend/default/plugins/bootstrap-formbuilder/js/lib/require.js') }}" ></script>
    @parent
    <script>
        function base64_encode(data) {
            var b64 = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=';
            var o1, o2, o3, h1, h2, h3, h4, bits, i = 0,
            ac = 0,
            enc = '',
            tmp_arr = [];

            if (!data) {
                return data;
            }

            do { // pack three octets into four hexets
                o1 = data.charCodeAt(i++);
                o2 = data.charCodeAt(i++);
                o3 = data.charCodeAt(i++);

                bits = o1 << 16 | o2 << 8 | o3;

                h1 = bits >> 18 & 0x3f;
                h2 = bits >> 12 & 0x3f;
                h3 = bits >> 6 & 0x3f;
                h4 = bits & 0x3f;

            // use hexets to index into b64, and append result to encoded string
            tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4);
            } while (i < data.length);

            enc = tmp_arr.join('');

            var r = data.length % 3;

            return (r ? enc.slice(0, r - 3) : enc) + '==='.slice(r || 3);
        }
        jQuery(document).ready(function () {

            setInterval(function() {
               if ($('#formtabs li').length != 0) {
                    $('#formtabs li').last().html('');
                }
            }, 1000);

            $("#container").addClass("sidebar-closed");
            $("#form-builder").on('submit', function (e) {

                $('#form-builder #form-name').val($('#target legend').html());

                $form_data = $("#render").val();
                {{--Encode the form html to base64, so that firewalls will not detect it as attack--}}
                $('#form-builder #form-data').val(base64_encode($form_data));
                $('[name="extra_code"]').val(base64_encode($('[name="extra_code"]').val()));
            });
        });
    </script>
@stop
