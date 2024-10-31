<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire de Connexion</title>
    @vite(['resources/css/connexion.css'])
</head>
<body>
    <div class="login-box">
        <h2>Connexion</h2>
        <form action="{{ route('connexion') }}" method="POST">
            @csrf
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label for="password">Mot de passe:</label>
                <input type="password" name="password" required>
                @error('password')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit">Connexion</button>
        </form>

        <a href="forgot-password.php" class="forgot-password">Mot de passe oublié?</a>
    </div>
    
</body>
</html>
