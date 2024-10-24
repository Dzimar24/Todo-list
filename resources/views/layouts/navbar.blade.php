<style>
    .margin-custom {
        margin-right: 250px;
    }
</style>

<nav class="navbar navbar-light">
    <div class="container d-block">
        <a class="navbar-brand ms-4" href="index.html">
            <img src="{{ asset('assets/compiled/svg/logo.svg') }}">
        </a>
    </div>
    <div class="justify-content-end margin-custom">
        @auth
            <a class="btn btn-danger btn-sm me-2" onclick="confirmLogout()">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endauth
        @guest
            <a href="{{ route('login') }}" class="btn btn-primary btn-sm me-2">Login</a>
        @endguest
    </div>
</nav>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Are you sure?',
            text: "What are you going to logout?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Logout!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
