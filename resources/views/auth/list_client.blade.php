<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Clients</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/affichage.css'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @include('dashboard')

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
            <button type="button" class="close" onclick="this.parentElement.style.display='none';">&times;</button>
        </div>
    @endif

    <div class="container">
        <h1>Liste des Clients</h1>

        <!-- Formulaire de filtrage par rôle -->
        <form method="GET" action="{{ route('clients.index') }}" class="mb-3">
            <div class="form-group">
                <label for="role">Filtrer par rôle :</label>
                <select name="role" id="role" class="form-control" onchange="this.form.submit()">
                    <option value="all" {{ request('role') === 'all' ? 'selected' : '' }}>Tous</option>
                    <option value="administrateur" {{ request('role') === 'administrateur' ? 'selected' : '' }}>Administrateurs</option>
                    <option value="client" {{ request('role') === 'client' ? 'selected' : '' }}>Clients</option>
                </select>
            </div>
        </form>

        <table class="table">
            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($activeClients->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Aucun client trouvé.</td>
                    </tr>
                @else
                    @foreach($activeClients as $client)
                        <tr>
                            <td>
                                @if($client->photo)
                                    <img src="{{ asset($client->photo) }}" alt="Photo de {{ $client->nom }}" style="width: 80px; height: 80px;">
                                @else
                                    <img src="{{ asset('photos/avatae.png') }}" alt="Pas de photo" style="width: 80px; height: 80px;">
                                @endif
                            </td>
                            <td>{{ $client->nom }}</td>
                            <td>{{ $client->prenom }}</td>
                            <td>{{ $client->email }}</td>
                            <td>{{ $client->telephone }}</td>
                            <td>
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Modifier</a>
                                <button type="button" class="btn btn-danger" onclick="archiveClient({{ $client->id }})">Archiver</button>
                                <form id="archiveForm-{{ $client->id }}" action="{{ route('clients.archive', $client->id) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <!-- Pagination -->
        {{ $activeClients->links() }} <!-- Ajoute la pagination si nécessaire -->
    </div>

    <script>
        function archiveClient(clientId) {
            const form = document.getElementById('archiveForm-' + clientId);
            if (confirm('Êtes-vous sûr de vouloir archiver ce client ?')) {
                form.submit();
            }
        }
    </script>
</body>
</html>
