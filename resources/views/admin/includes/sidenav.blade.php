<div class="card card-sidebar-mobile">
    <ul class="nav nav-sidebar" data-nav-type="accordion">

        <!-- Main -->
        <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{Request::is('home') ? 'active' : ''}}">
                <i class="icon-home4"></i>
                <span>
					Dashboard
                </span>
            </a>
        </li>
       <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{Request::is(['users','users/*']) ? 'active' : ''}}">
                <i class="icon-user"></i>
                <span>
					User Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('products.index') }}" class="nav-link {{Request::is(['products','products/*']) ? 'active' : ''}}">
                <i class="icon-user"></i>
                <span>
                    Products Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('places.index') }}" class="nav-link {{Request::is(['places','places/*']) ? 'active' : ''}}">
                <i class="icon-user"></i>
                <span>
                    Places Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link {{Request::is(['categories','categories/*']) ? 'active' : ''}}">
                <i class="icon-user"></i>
                <span>
                    Category Management
                </span>
            </a>
        </li>
    </ul>
</div>
