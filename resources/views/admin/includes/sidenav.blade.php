<div class="card card-sidebar-mobile">
    <ul class="nav nav-sidebar" data-nav-type="accordion">

        <!-- Main -->
        <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{Request::is('admin/dashboard') ? 'active' : ''}}">
                <i class="icon-home4"></i>
                <span>
					Dashboard
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('content_settings.index') }}" class="nav-link {{Request::is(['admin/content_settings','admin/content_settings/*']) ? 'active' : ''}}">
                <i class="fa fa-pencil" aria-hidden="true"></i>
                <span>
                    Content Management
                </span>
            </a>
        </li>
       <li class="nav-item">
            <a href="{{ route('users.index') }}" class="nav-link {{Request::is(['admin/users','admin/users/*']) ? 'active' : ''}}">
                <i class="icon-user"></i>
                <span>
					User Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('posts.index') }}" class="nav-link {{Request::is(['admin/posts','admin/posts/*']) ? 'active' : ''}}">
                <i class="fas fa-sticky-note"></i>
                <span>
                    Blog Post Management
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}" class="nav-link {{Request::is(['admin/categories','admin/categories/*']) ? 'active' : ''}}">
                <i class="fa fa-list-alt" aria-hidden="true"></i>
                <span>
                    Category Management
                </span>
            </a>
        </li>
        <br>
        <li class="nav-item">
            <a href="{{ route('services.index') }}" class="nav-link {{Request::is(['admin/services','admin/services/*']) ? 'active' : ''}}">
                <i class="fas fa-check"></i>
                <span>
                    Approved Services
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pending_services.index') }}" class="nav-link {{Request::is(['admin/pending_services','admin/pending_services/*']) ? 'active' : ''}}">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <span>
                    Pending Services
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('disapproved_services.index') }}" class="nav-link {{Request::is(['admin/disapproved_services','admin/disapproved_services/*']) ? 'active' : ''}}">
                <i class="fa fa-ban" aria-hidden="true"></i>
                <span>
                    Denied Services
                </span>
            </a>
        </li>
        <br>
        <li class="nav-item">
            <a href="{{ route('places.index') }}" class="nav-link {{Request::is(['admin/places','admin/places/*']) ? 'active' : ''}}">
                <i class="fas fa-check"></i>
                <span>
                    Approved Places
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('pending_places.index') }}" class="nav-link {{Request::is(['admin/pending_places','admin/pending_places/*']) ? 'active' : ''}}">
                <i class="fa fa-clock-o" aria-hidden="true"></i>
                <span>
                    Pending Places
                </span>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('disapproved_places.index') }}" class="nav-link {{Request::is(['admin/disapproved_places','admin/disapproved_places/*']) ? 'active' : ''}}">
                <i class="fa fa-ban" aria-hidden="true"></i>
                <span>
                    Denied Places
                </span>
            </a>
        </li>
        
    </ul>
</div>
