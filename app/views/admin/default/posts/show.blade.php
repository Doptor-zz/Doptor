@section('content')
    <div class="row-fluid">
        <div class="span12">
            <!-- BEGIN TABLE widget-->
            <div class="widget box light-grey">
                <div class="blue widget-title">
                    <h4><i class="icon-table"></i> {{ $post->title }}</h4>
                </div>
                <div class="widget-body">

                    <div class="form-horizontal">

                        @if ($post->image != '')
                            <div class="control-group">
                                <div class="controls line">{{ HTML::image($post->image, '', array('width'=> '400')) }}</div>
                            </div>
                        @endif

                        <div class="control-group">
                            <label class="control-label">Alias</label>
                            <div class="controls line">
                                {{ $post->permalink }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Description</label>
                            <div class="controls line">
                                {{ $post->content }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Categories</label>
                            <div class="controls line">
                                {{ implode(', ', $post->selected_categories('name')) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Status</label>
                            <div class="controls line">
                                {{ Str::title($post->status) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Target Display</label>
                            <div class="controls line">
                                {{ Str::title($post->target) }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Featured</label>
                            <div class="controls line">
                                {{ ($post->featured) ? 'Yes' : 'No' }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Publish Start</label>
                            <div class="controls line">
                                {{ ($post->publish_start) ? $post->publish_start : 'Immediately' }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Publish End</label>
                            <div class="controls line">
                                {{ ($post->publish_end) ? $post->publish_end : 'Never' }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Meta Description</label>
                            <div class="controls line">
                                {{ $post->meta_description }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Meta Keywords</label>
                            <div class="controls line">
                                {{ $post->meta_keywords }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Hits</label>
                            <div class="controls line">
                                {{ $post->hits }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Created By</label>
                            <div class="controls line">
                                {{ $post->author() }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Created At</label>
                            <div class="controls line">
                                {{ $post->created_at }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Updated By</label>
                            <div class="controls line">
                                {{ $post->editor() }}
                            </div>
                        </div>

                        <div class="control-group">
                            <label class="control-label">Updated At</label>
                            <div class="controls line">
                                {{ $post->updated_at }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- END TABLE widget-->
        </div>
    </div>
@stop
