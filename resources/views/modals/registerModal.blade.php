<div id="registerModal" class="modal">
    <div class="modal-content center-page">
        <span class="close">&times;</span>
        <h2>Register</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="input-row-container">
                <label for="name">Name</label>
                <input type="text" name="name" value="{{ old('name') }} " class="text-input-container" required
                    autofocus>
                @error('name')
                <span>{{ $message }}</span>
                @enderror
            </div>
            <div class="input-row-container">
                <label for="email">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="text-input-container" required>
            </div>
            <div class="input-row-container">
                <label for="password">Password</label>
                <input type="password" name="password" class="text-input-container" required>
            </div>
            <div class="input-row-container">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="text-input-container" required>
            </div>
            <div class="center-children-in-parent">
                <button type="submit" class="todo-button">Register</button>
            </div>
            <div class="error-message">
                @error('name')
                <span>Name error: {{ $message }}</span>
                @enderror

                @error('email')
                <span>Email error: {{ $message }}</span>
                @enderror

                @error('password')
                <span>Password error: {{ $message }}</span>
                @enderror
            </div>
        </form>
    </div>
</div>