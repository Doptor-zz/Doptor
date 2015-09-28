@extends("public.$current_theme._layouts._layout")

@section('content')
    <div class="container">
        <!-- BEGIN SIDEBAR & CONTENT -->
        <div class="row margin-bottom-40">
            <!-- BEGIN CONTENT -->
            <div class="col-md-12 col-sm-12">
                <div class="content-page page-404">
                    <div class="number">
                        404
                    </div>
                    <div class="details">
                        <h3>Oops!  You're lost.</h3>
                        <p>
                            We can not find the page you're looking for.<br>
                            <a href="index.html" class="link">Return home</a> or try the search bar below.
                        </p>
                    </div>
                </div>
            </div>
            <!-- END CONTENT -->
        </div>
        <!-- END SIDEBAR & CONTENT -->
    </div>
@stop
