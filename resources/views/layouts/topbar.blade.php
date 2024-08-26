
<header>
    <div class="header-menu">
        <a class="header-drawer-toggle hidden">
            <i class="fa-solid fa-bars fa-xl menu-icon"></i><span>s</span>
        </a>
        <a class="logo" href="/"><img alt="Logo"></a>
        <a class="topnav" href="/">Products</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>

        <a href="{{ route('logout') }}" 
        onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="user-btn"><i class="fa fa-sign-out" aria-hidden="true"></i> Log out</a>
        <a href="{{ url('/profile') }}" class="user-btn"><i class="fa-solid fa-user" aria-hidden="true"></i> {{ auth()->user()->name }}</a>

        <a class="header-search hidden">
            <span>s</span><i class="fa-solid fa-search fa-xl menu-icon"></i>
        </a>
        <a class="header-search-close">
            <span>s</span><i class="fa-solid fa-times fa-xl menu-icon"></i>
        </a>

        <form id="search-form" action="{{ url('/search') }}" method="get" name="searchpim">
            <label for="fname">Search:</label>
            <input type="text" id="search-field" name="val" placeholder="Type in SKU or Product Name">
            <input type="submit" value="Search">
        </form>
    </div>
</header>
<div style="height:50px"></div>
