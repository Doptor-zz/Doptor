@section('styles')
@stop

@section('content')
    <div class="indent">

        <div class="container">
            <h1>Contacts Category: {{ $category->name }}</h1>
            <!-- BEGIN GALLERY 4 COLS -->
            <ul class="gallery cols4 clearfix">

            @foreach ($category->contacts as $contact)
                <li class="grid_3">
                    <figure class="thumb-holder">
                        <a href='{{ url("contact/{$category->alias}/{$contact->alias}") }}' title="Mauris ut velit non dolor">
                            {{ HTML::image($contact->image(), $contact->name, array("width"=>"456", "height"=>"302", "border"=>"0")) }}
                        </a>
                    </figure>
                    <div class="desc">
                        <h4><a href='{{ url("contact/{$category->alias}/{$contact->alias}") }}'>{{ $contact->name }}</a></h4>
                    </div>
                </li>
            @endforeach

            </ul>
            <!-- END GALLERY 4 COLS -->

        </div>

    </div>
@stop

@section('scripts')

@stop
