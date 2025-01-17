<div class="navbar-custom d-flex justify-content-between align-items-center">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <!-- Project Name -->
        <div class="navbar-brand text-primary">
            My Laravel Project
        </div>

        <!-- Logout Button -->
        <div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="uil-signout-alt"></i> Logout
                </button>
            </form>
        </div>
    </div>
</div>
