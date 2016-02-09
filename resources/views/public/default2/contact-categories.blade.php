@section('styles')
@stop

@section('content')
<div class="container">
    <div class="row margin-bottom-40">
        <!-- BEGIN CONTENT -->
        <div class="col-md-12">
            <div class="content-page">
                <div class="row">

                    <div class="col-md-12">
                        <h1>{!! trans('public.contacts_category') !!}: {!! $category->name !!}</h1>
                        <!-- BEGIN GALLERY 4 COLS -->
                        <ul class="gallery cols4 clearfix">

                        @foreach ($category->contacts as $contact)
                            <li class="grid_3">
                                <figure class="thumb-holder">
                                    <a href='{!! url("contact/{$category->alias}/{$contact->alias}") !!}'>
                                        {!! HTML::image($contact->image(), $contact->name, array("width"=>"456", "height"=>"302", "border"=>"0")) !!}
                                    </a>
                                </figure>
                                <div class="desc">
                                    <h4><a href='{!! url("contact/{$category->alias}/{$contact->alias}") !!}'>{!! $contact->name !!}</a></h4>
                                </div>
                            </li>
                        @endforeach

                        </ul>
                        <!-- END GALLERY 4 COLS -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
@stop
