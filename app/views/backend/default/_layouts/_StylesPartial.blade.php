<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="{{ URL::to("assets/backend/default/plugins/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" />
<link href="{{ URL::to("assets/backend/default/plugins/bootstrap/css/bootstrap-responsive.min.css") }}" rel="stylesheet" />
<link href="{{ URL::to("assets/backend/default/plugins/font-awesome/css/font-awesome.css") }}" rel="stylesheet" />
<link href="{{ URL::to("assets/backend/default/css/style.css") }}" rel="stylesheet" />
<link href="{{ URL::to("assets/backend/default/css/style-responsive.css") }}" rel="stylesheet" />
<link href="{{ URL::to("assets/backend/default/css/themes/default.css") }}" rel="stylesheet" id="style_color" />
<link href="{{ URL::to("assets/backend/default/plugins/uniform/css/uniform.default.css") }}" rel="stylesheet" type="text/css" />
@if(ends_with(Request::url(), 'create') || ends_with(Request::url(), 'edit'))
    <link href="{{ URL::to('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="{{ URL::to('assets/backend/default/plugins/chosen-bootstrap/chosen/chosen.css') }}" />
@endif
<link href="#" rel="stylesheet" id="style_metro" />
<!-- END GLOBAL MANDATORY STYLES -->
@section('styles')
    {{-- Here goes the page level styles --}}
@show
