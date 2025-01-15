<form class="login-form" action="{{ route('login') }}" method="POST">
    @csrf
    <div class="input-group">
        <i class="fas fa-user"></i>
        <input type="email" name="email" placeholder="Email" required>
    </div>
    <div class="input-group">
        <i class="fas fa-lock"></i>
        <input type="password" name="password" placeholder="Password" required>
    </div>
    <!-- ... reste du formulaire ... -->
</form> 