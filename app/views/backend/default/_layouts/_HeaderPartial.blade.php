<div id="header" class="navbar navbar-inverse navbar-fixed-top">
    <!-- BEGIN TOP NAVIGATION BAR -->
    <div class="navbar-inner">
        <div class="container-fluid">
            <!-- BEGIN LOGO -->
            <a class="brand" href="{{ url('backend') }}">
            <img src="{{ url("assets/backend/default/img/logo.png") }}" />
            </a>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a class="btn btn-navbar collapsed" id="main_menu_trigger" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="arrow"></span>
            </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <div class="top-nav">
                <!-- BEGIN QUICK SEARCH FORM -->
                <!-- <form class="navbar-search hidden-phone">
                    <div class="search-input-icon">
                        <input type="text" class="search-query dropdown-toggle" id="quick_search" placeholder="Search" data-toggle="dropdown" />
                        <i class="icon-search"></i>
                    </div>
                </form> -->
                <!-- END QUICK SEARCH FORM -->
                <!-- BEGIN TOP NAVIGATION MENU -->
                @include("backend.default._layouts._TopMenuPartial")
                <!-- END TOP NAVIGATION MENU -->
            </div>
        </div>
    </div>
    <!-- END TOP NAVIGATION BAR -->
</div>
