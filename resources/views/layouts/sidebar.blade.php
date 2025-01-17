<div class="left-side-menu">
    <div class="h-100" id="left-side-menu-container" data-simplebar>
        <ul class="metismenu side-nav">
            <li class="side-nav-title">Menu</li>

            <!-- Dashboard Menu Item -->
            <li class="side-nav-item">
                <a href="{{ route('dashboard') }}" class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <!-- Manage Users Menu Item -->
            <li class="side-nav-item">
                <a href="{{ route('users.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Manage Users </span>
                </a>
            </li>

            <!-- View and Generate Reports -->
            <li class="side-nav-item">
                <a href="{{ route('reports.users') }}" class="side-nav-link">
                    <i class="uil-chart"></i>
                    <span> View & Generate Report </span>
                </a>
            </li>

            <!-- Add other sidebar items as needed -->
        </ul>
    </div>
</div>
