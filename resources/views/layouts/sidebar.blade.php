<div class="left-side-menu">
    <div class="h-100" id="left-side-menu-container" data-simplebar>
        <ul class="metismenu side-nav">
            <li class="side-nav-title">Menu</li>

            <!-- Dashboard Menu Item -->
            <li class="side-nav-item">
                <a href="
                    @if(auth()->user()->Role === 'admin')
                        {{ route('admin.dashboard') }}
                    @elseif(auth()->user()->Role === 'supervisor')
                        {{ route('supervisor.dashboard') }}
                    @elseif(auth()->user()->Role === 'student')
                        {{ route('student.dashboard') }}
                    @endif
                " class="side-nav-link">
                    <i class="uil-home-alt"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            <!-- Manage Users Menu Item -->
            @if(auth()->user()->Role === 'admin')
            <li class="side-nav-item">
                <a href="{{ route('users.index') }}" class="side-nav-link">
                    <i class="uil-users-alt"></i>
                    <span> Manage Users </span>
                </a>
            </li>
            @endif

            <!-- View and Generate Reports -->
            @if(auth()->user()->Role === 'admin' || auth()->user()->Role === 'supervisor')
            <li class="side-nav-item">
                <a href="{{ route('reports.users') }}" class="side-nav-link">
                    <i class="uil-chart"></i>
                    <span> View & Generate Report </span>
                </a>
            </li>
            @endif

            <!-- Add Manage Quota for Admins -->
            @if(auth()->user()->Role === 'admin')
            <li class="side-nav-item">
                <a href="{{ route('quota.index') }}" class="side-nav-link">
                    <i class="uil-cog"></i>
                    <span> Manage Quota </span>
                </a>
            </li>

            <!-- Add Manage TimeFrame for Admins -->
            <li class="side-nav-item">
                <a href="{{ route('timeframes.index') }}" class="side-nav-link">
                    <i class="uil-calendar-alt"></i>
                    <span> Manage TimeFrame </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="{{ route('appointments.index') }}" class="side-nav-link">
                    <i class="uil-calendar-alt"></i>
                    <span> Manage Appointment </span>
                </a>
            </li>
            @endif
        </ul>
    </div>
</div>