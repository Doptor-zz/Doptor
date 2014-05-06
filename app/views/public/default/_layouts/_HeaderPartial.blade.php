<header id="header">

    <div id="top-header">
        <div class="container">
            <div class="grid_12">

                {{ Services\MenuManager::generate('public-small-menu-left', 'top-menu-left inline') }}

                <div class="fright">
                    {{ Services\MenuManager::generate('public-small-menu-right', 'top-menu-right') }}
                </div>
            </div>
        </div>
    </div>

    <!--Main Header-->
    <div id="main-header">
        <div class="container">
            <div class="grid_12">

                <!-- BEGIN LOGO -->
                <div id="logo">
                    <!-- Image based Logo-->
                    <a href="{{ url('/') }}"><img src="{{URL::to("assets/public/default/images/logo.png")}}" alt=""/></a>

                </div>
                <!-- END LOGO -->

                <!-- BEGIN NAVIGATION -->
                @include("public.default._layouts._TopMenuPartial")
                <!-- END NAVIGATION -->

            </div>
        </div>
    </div>

</header>
