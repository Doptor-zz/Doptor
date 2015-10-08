<div class="menu_main">

    <nav class="navbar navbar-default fhmm" role="navigation">
        <div class="navbar-header">
            <button type="button" data-toggle="collapse" data-target="#defaultmenu" class="navbar-toggle">Menu <i class="fa fa-bars tbars"></i></button>
        </div><!-- end navbar-header -->

        <div id="defaultmenu" class="navbar-collapse collapse">
            {!! Services\MenuManager::generate('public-top-menu', 'nav navbar-nav', 'dropdown', 'dropdown-menu', 'dropdown-toggle') !!}
        </div><!-- end #navbar-collapse-1 -->

    </nav>

</div>
