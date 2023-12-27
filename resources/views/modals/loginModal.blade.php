<section id="loginModal" class="modal">
    <div class="modal-content center-page">
        <span class="close">&times;</span>

        <h2>Login</h2>
        <form id="LoginFormAjax" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="input-row-container">
                <label for="email">Email:</label>
                <input type="email" name="email" required class="text-input-container">
            </div>
            <div class="input-row-container">
                <label for="password">Password:</label>
                <input type="password" name="password" required class="text-input-container">
            </div>
            <div id="login-error" class="error-message"></div>
            <div class="center-children-in-parent">
                <button type="submit" class="todo-button">Login</button>
            </div>
        </form>
    </div>
</section>
<script src="{{ asset('js/login.js') }}"></script>