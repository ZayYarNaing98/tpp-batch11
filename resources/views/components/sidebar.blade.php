<div class="d-flex flex-column flex-shrink-0 bg-dark text-white" style="width: 240px; min-height: 100vh;">
    <a href="/" class="d-flex align-items-center px-3 py-4 text-white text-decoration-none border-bottom border-secondary">
        <span class="fs-5 fw-semibold">TPP Program</span>
    </a>
    <ul class="nav nav-pills flex-column mb-auto p-2 gap-1">
        <li class="nav-item">
            <a href="{{ route('instructors.index') }}"
               class="nav-link {{ request()->routeIs('instructors.*') ? 'active' : 'text-white' }}">
                Instructors
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('batches.index') }}"
               class="nav-link {{ request()->routeIs('batches.*') ? 'active' : 'text-white' }}">
                Batches
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('students.index') }}"
               class="nav-link {{ request()->routeIs('students.*') ? 'active' : 'text-white' }}">
                Students
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('categories.index') }}"
               class="nav-link {{ request()->routeIs('categories.*') ? 'active' : 'text-white' }}">
                Categories
            </a>
        </li>
    </ul>
</div>
