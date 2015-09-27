<!-- BEGIN TOP BAR -->
<div class="pre-header">
    <div class="container">
        <div class="row">
            <!-- BEGIN TOP BAR LEFT PART -->
            <div class="col-md-6 col-sm-6 additional-shop-info">
                {!! Services\MenuManager::generate('public-small-menu-left', 'list-unstyled list-inline') !!}
            </div>
            <!-- END TOP BAR LEFT PART -->
            <!-- BEGIN TOP BAR MENU -->
            <div class="col-md-6 col-sm-6 additional-nav">
                {!! Services\MenuManager::generate('public-small-menu-right', 'list-unstyled list-inline pull-right') !!}
            </div>
            <!-- END TOP BAR MENU -->
        </div>
    </div>
</div>
<!-- END TOP BAR -->
<!-- BEGIN HEADER -->
<div class="header">
  <div class="container">
    <a class="site-logo" href="{!! url('/') !!}">
        @if (Setting::value('website_logo'))
            <img src="{!!URL::to(Setting::value('website_logo'))!!}" alt="Logo" height="40" />
        @else
            <img src="{!!URL::to("assets/public/$current_theme/img/logo.png")!!}" alt="Logo" height="40" />
        @endif
    </a>

    <a href="javascript:void(0);" class="mobi-toggler"><i class="fa fa-bars"></i></a>

    <!-- BEGIN NAVIGATION -->
    <div class="header-navigation pull-right font-transform-inherit">
        @include("public.$current_theme._layouts._TopMenuPartial")
    </div>
    <!-- END NAVIGATION -->
  </div>
</div>
<!-- Header END -->
