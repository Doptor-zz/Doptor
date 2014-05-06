<div class="navbar navbar-inverse top-nav">
    <div class="navbar-inner">
        <div class="container">
            <span class="home-link"><a href="{{ URL::to('admin') }}" class="icon-home"></a></span><a class="brand" href="{{ URL::to('admin') }}"><img src="{{url("assets/admin/default/images/logo.png")}}" alt="Doptor"></a>
            <div class="nav-collapse">
                {{ Services\MenuManager::generate('admin-top-menu', 'nav') }}
            </div>
        </div>
    </div>
</div>
