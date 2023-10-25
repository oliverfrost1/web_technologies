<div class="topbar">
    <div class="top-left">
        <h1>
            <a href="/" class="button"> Todo List</a>
        </h1>
    </div>
    <div class="top-right">
        @auth
            <span>{{ Auth::user()->name }}</span> <!-- Display user name -->
            <a href="Profile" class="button">Profile <i class="fa-solid fa-address-card"></i></a>
            <a href="#" class="button"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Log out <i
                    class="fa-solid fa-right-from-bracket"></i></a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <a href="Login" class="button">Login <i class="fa-solid fa-right-to-bracket"></i></a>
            <a href="Register" class="button">Register <i class="fa-solid fa-align-justify"></i></a>
        @endauth
    </div>
</div>
