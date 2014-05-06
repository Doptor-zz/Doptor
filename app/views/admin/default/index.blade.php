@extends('admin.admin._layouts._layout')

@section('content')
    <div class="row-fluid">
        <div class="span12">
            <div class="hero-unit">
                <h2>Welcome</h2>

                @foreach (array_chunk($menu_items->all(), 4) as $row)
                    <div class="row-fluid">
                        @foreach ($row as $menu_item)
                            <div class="span3">
                                <div class="board-widgets bondi-blue small-widget">
                                    <a href="{{ $menu_item->link() }}">
                                        @if ($menu_item->icon != '')
                                            {{ HTML::image($menu_item->icon, 'alt', array('class'=>'widget-icon')) }}
                                        @else
                                            <span class="widget-icon"></span>
                                        @endif
                                        <span class="widget-label">{{ $menu_item->title }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
