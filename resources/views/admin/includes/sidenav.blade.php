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
            <a href="{{ route('posts.index') }}" class="nav-link {{Request::is(['posts','posts/*']) ? 'active' : ''}}">
                <i class="fas fa-sticky-note"></i>
                <span>
                    Blog Post Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('services.index') }}" class="nav-link {{Request::is(['services','services/*']) ? 'active' : ''}}">
                <i class="fa fa-archive" aria-hidden="true"></i>
                <span>
                    All Services Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pending_services.index') }}" class="nav-link {{Request::is(['pending_services','pending_services/*']) ? 'active' : ''}}">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <span>
                    Pending Services Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('places.index') }}" class="nav-link {{Request::is(['places','places/*']) ? 'active' : ''}}">
                <i class="fa fa-map-marker" aria-hidden="true"></i>
                <span>
                    All Places Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pending_places.index') }}" class="nav-link {{Request::is(['pending_places','pending_places/*']) ? 'active' : ''}}">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <span>
                    Pending Places Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link {{Request::is(['categories','categories/*']) ? 'active' : ''}}">
                <i class="fa fa-list-alt" aria-hidden="true"></i>
                <span>
                    Category Management
                </span>
            </a>
        </li>
    </ul>
</div>
