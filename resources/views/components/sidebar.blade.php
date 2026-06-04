<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile">
            <a href="#" class="nav-link">
                <div class="nav-profile-image">
                    <img src="{{ asset('assets/images/faces/face1.jpg') }}" alt="profile" />
                    <span class="login-status online"></span>
                </div>
                <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2">TPP Admin</span>
                    <span class="text-secondary text-small">Administrator</span>
                </div>
                <i class="mdi mdi-star text-warning nav-profile-badge"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <span class="menu-title">Dashboard</span>
                <i class="mdi mdi-view-dashboard menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('instructors.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('instructors.index') }}">
                <span class="menu-title">Instructors</span>
                <i class="mdi mdi-account-tie menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('batches.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('batches.index') }}">
                <span class="menu-title">Batches</span>
                <i class="mdi mdi-layers menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('students.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('students.index') }}">
                <span class="menu-title">Students</span>
                <i class="mdi mdi-account-school menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('categories.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('categories.index') }}">
                <span class="menu-title">Categories</span>
                <i class="mdi mdi-tag-multiple menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('users.index') }}">
                <span class="menu-title">Users</span>
                <i class="mdi mdi-account-multiple menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('roles.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('roles.index') }}">
                <span class="menu-title">Roles</span>
                <i class="mdi mdi-shield-account menu-icon"></i>
            </a>
        </li>

        <li class="nav-item {{ request()->routeIs('permissions.*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('permissions.index') }}">
                <span class="menu-title">Permissions</span>
                <i class="mdi mdi-key-variant menu-icon"></i>
            </a>
        </li>
    </ul>
</nav>
