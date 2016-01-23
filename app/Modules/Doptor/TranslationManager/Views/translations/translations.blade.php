@section('styles')
    {!! HTML::style('assets/backend/default/plugins/bootstrap/css/bootstrap-modal.css') !!}
    {!! HTML::style('assets/backend/default/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') !!}
@stop

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN FORM widget-->
            <div class="widget box blue tabbable">
                <div class="blue widget-title">
                    <h4>
                        <i class="icon-user"></i>
                        Manage Translations
                        &nbsp;
                    </h4>
                </div>
                <div class="widget-body form">
                    <div class="tabbable widget-tabs">
                        <div class="tab-content">
                            <div class="tab-pane active" id="widget_tab1">
                                <!-- BEGIN FORM-->
                                {!! Form::open(array('route'=>['backend.modules.doptor.translation_manager.post_manage', $language_id, $group], 'method'=>'POST', 'class'=>'form-horizontal', 'id' => 'translation-form', 'files'=>false)) !!}
                                    {!! Form::hidden('_language_id', $language_id) !!}
                                    {!! Form::hidden('_group', $group) !!}

                                    @if ($errors->has())
                                         <div class="alert alert-error hide" style="display: block;">
                                           <button data-dismiss="alert" class="close">×</button>
                                           {!! trans('errors.form_errors') !!}
                                        </div>
                                    @endif

                                    <div class="alert alert-info">
                                        {!! trans('form_messages.translation_note') !!}
                                    </div>

                                    @foreach ($translations as $key => $translation)
                                        <div class="control-group {{ $errors->has('content') ? 'error' : '' }}">
                                            <label class="control-label">{!! $key !!}</label>
                                            <div class="controls line">
                                                @foreach ($locales as $i => $locale)
                                                    <?php $value = isset($translation[$locale]) ? $translation[$locale]->value : null?>
                                                    <strong>{!! $locale !!}</strong>
                                                    @if ($i == 1)
                                                        {!! Form::text($key, $value, ['class'=>'input-xxlarge', ($i==0) ? 'disabled' : '']) !!}
                                                    @else
                                                        <span class="uneditable-input input-xxlarge">{!! $value !!}</span>
                                                    @endif
                                                    <br>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach

                                    <br>

                                    <div class="form-actions">
                                        <button type="submit" class="btn btn-primary"><i class="icon-ok"></i> {!! trans('options.save') !!}</button>
                                    </div>
                                {!! Form::close() !!}
                                <!-- END FORM-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END FORM widget-->
        </div>
    </div>
@stop

@section('scripts')
    {!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modalmanager.js') !!}
    {!! HTML::script('assets/backend/default/plugins/bootstrap/js/bootstrap-modal.js') !!}
    {!! HTML::script("assets/backend/default/plugins/ckeditor/ckeditor.js") !!}
    {!! HTML::script("assets/backend/default/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js") !!}
    {!! HTML::script("assets/backend/default/scripts/media-selection.js") !!}
    @parent
    <script>
        function htmlEscape(str) {
            return String(str)
                    .replace('<script>', '**script**')
                    .replace('<\/script>', '**/script**');
        }

        function htmlUnescape(value){
            return String(value)
                .replace('**script**', '<script>')
                .replace('**/script**', '<\/script>');
        }

        jQuery(document).ready(function() {
            $('#translation-form').find('input').each(function(key, value) {
                field_value = $(value).val();
                field_value = htmlUnescape(field_value);
                $(value).val(field_value);
            });

            $('#translation-form').submit(function(e) {
                var field_value;

                $(this).find('input').each(function(key, value) {
                    field_value = $(value).val();
                    field_value = htmlEscape(field_value);
                    $(value).val(field_value);
                });
            })
        });
    </script>
@stop
