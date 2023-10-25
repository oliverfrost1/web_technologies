<div class="topbar">
    <div class="top-left">
        <h1>
            <a href="/" class="button"> Todo List</a>
        </h1>
    </div>
    <div class="top-right">
        @auth
            <span>{{ Auth::user()->name }}</span> <!-- Display user name -->
            <a href="Profile" class="button">Profile</a>
            <a href="#" class="button"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <a href="Login" class="button">Login</a>
            <a href="Register" class="button">Register</a>
        @endauth
    </div>
</div>
