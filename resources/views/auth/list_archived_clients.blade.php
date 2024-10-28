<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clients Archivés</title>

    <!-- Inclure jQuery et Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    @include('dashboard')

<div class="container mt-4">
    <h1>Liste des Clients Archivés</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>photo</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Téléphone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($archivedClients as $client)
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
                        <button type="button" class="btn btn-success" onclick="restoreClient({{ $client->id }})">Restaurer</button>
                        <form id="restoreForm-{{ $client->id }}" action="{{ route('clients.restore', $client->id) }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination justify-content-center">
        {{ $archivedClients->links() }}
    </div>
</div>

<script>
    function restoreClient(clientId) {
        const form = document.getElementById(`restoreForm-${clientId}`);
        if (confirm('Êtes-vous sûr de vouloir restaurer ce client ?')) {
            form.submit(); // Soumet le formulaire pour restaurer le client
        }
    }
</script>

</body>
</html>
