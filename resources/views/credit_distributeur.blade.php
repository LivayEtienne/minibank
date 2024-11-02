<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créditer le Compte d'un Distributeur</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    @include('dashboard');
    <div class="container">
        <h1>Créditer le Compte d'un Distributeur</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('distributeur.crediter') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="id_user">Sélectionnez un utilisateur</label>
                <select class="form-control" name="id_user" required>
                    <option value="">Choisir un utilisateur</option>
                    @foreach($utilisateurs as $user)
                        <option value="{{ $user->id }}">{{ $user->nom }} {{ $user->prenom }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="montant">Montant à créditer</label>
                <input type="number" class="form-control" name="montant" required>
            </div>
            <button type="submit" class="btn btn-primary">Créditer</button>
        </form>
    </div>
</body>
</html>
