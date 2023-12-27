<section id="registerModal" class="modal">
    <div class="modal-content center-page">
        <span class="close">&times;</span>
        <h2>Register</h2>
        <form id="registerFormAjax" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="input-row-container">
                <label for="name">Name</label>
                <input type="text" name="name" class="text-input-container" autofocus>
            </div>
            <div id="name-error" class="error-message"></div>
            <div class="input-row-container">
                <label for="email">Email Address</label>
                <input type="email" name="email" class="text-input-container">
            </div>
            <div id="email-error" class="error-message"></div>
            <div class="input-row-container">
                <label for="password">Password</label>
                <input type="password" name="password" class="text-input-container">
            </div>
            <div class="input-row-container">
                <label for="password_confirmation">Confirm Password</label>
                <input type="password" name="password_confirmation" class="text-input-container">
            </div>
            <div id="password-error" class="error-message"></div>
            <div class="center-children-in-parent">
                <button type="submit" class="todo-button">Register</button>
            </div>
        </form>
    </div>
</section>
<script src="{{ asset('js/register.js') }}"></script>