<div class="topbar">
    <div class="top-bar-left">
        <h1>
            <a href="/" class="button"> <i class="fa-solid fa-house-circle-check"></i> Todo List </a>
        </h1>
    </div>
    <div class="top-bar-right">
        @auth
            <span>{{ Auth::user()->name }}</span>
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="button"> <i class="fa-solid fa-screwdriver-wrench"></i> Admin
                </a>
            @endif
            <a href="{{ route('profile') }}" class="button"><i class="fa-solid fa-address-card"></i> Profile </a>
            <a href="#" class="button"
                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                    class="fa-solid fa-right-from-bracket"></i> Log out </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        @else
            <a href="{{ route('Login') }}" class="button"> <i class="fa-solid fa-right-to-bracket"></i> Login</a>
            <a href="{{ route('register') }}" class="button"> <i class="fa-solid fa-align-justify"></i> Register </a>
        @endauth
    </div>
</div>
