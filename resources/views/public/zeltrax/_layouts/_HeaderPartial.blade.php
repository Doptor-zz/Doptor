<header id="header">

    <!-- Top header bar -->
    <div id="topHeader">

        <div class="wrapper">

            <div class="top_nav">
                <div class="container">

                    <div class="left">

                        {!! Services\MenuManager::generate('public-small-menu-left') !!}

                    </div><!-- end left links -->

                    <div class="right">

                        {!! Services\MenuManager::generate('public-small-menu-right') !!}

                    </div><!-- end right social links -->

                </div>
            </div>

        </div>

    </div><!-- end top navigation -->


    <div id="trueHeader">

        <div class="wrapper">

            <div class="container">

                <!-- Logo -->

                <div class="logo">
                    <a class="site-logo" href="{!! url('/') !!}">
                        @if (Setting::value('website_logo'))
                            <img src="{!!URL::to(Setting::value('website_logo'))!!}" alt="Logo" height="40" />
                        @else
                            <img src="{!!URL::to("assets/public/$current_theme/images/logo.png")!!}" alt="Logo" height="40" />
                        @endif
                    </a>
                </div>

                <!-- Menu -->
                @include("public.{$current_theme}._layouts._TopMenuPartial")

            </div>

        </div>

    </div>

</header>

<div class="clearfix"></div>
