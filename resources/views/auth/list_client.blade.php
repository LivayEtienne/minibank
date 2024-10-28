<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listes</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/affichage.css'])
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- CSS de Bootstrap -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
        <h1>Affichages des Listes</h1>

        <!-- Formulaire de filtrage par rôle -->
        <form method="GET" action="{{ route('clients.index') }}" class="mb-3">
            <div class="form-group">
                <label for="role">Filtrer par rôle :</label>
                <select name="role" id="role" class="form-control" onchange="this.form.submit()">
                    <option value="all" {{ request('role') === 'all' ? 'selected' : '' }}>Tous</option>
                    <option value="distributeur" {{ request('role') === 'distributeur' ? 'selected' : '' }}>Distributeurs</option>
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
                    <th>Role</th>
                    <th>Téléphone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @if($activeClients->isEmpty())
                    <tr>
                        <td colspan="6" class="text-center">Aucun Utilisateur trouvé.</td>
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
                            <td>{{ $client->role }}</td>
                            <td>{{ $client->telephone }}</td>
                            <td>
                                <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">Modifier</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#archiveModal" onclick="setArchiveClientId('{{ $client->id }}')">
                                    Archiver
                                </button>

                                <!-- Formulaire d'archivage (caché) -->
                                <form id="archiveForm-{{ $client->id }}" action="{{ route('clients.archive', $client->id) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                            </td>
                        </tr>
                    @endforeach
                @endif

                <!-- Modal de Confirmation -->
<div class="modal fade" id="archiveModal" tabindex="-1" role="dialog" aria-labelledby="archiveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="archiveModalLabel">Confirmer l'Archivage</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir archiver ce client ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="confirmArchive">Archiver</button>
            </div>
        </div>
    </div>
</div>

            </tbody>
        </table>

        <!-- Pagination -->
        {{ $activeClients->links() }} <!-- Ajoute la pagination si nécessaire -->
    </div>

<!-- JS de Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<script>
        function archiveClient(clientId) {
            const form = document.getElementById('archiveForm-' + clientId);
            if (confirm('Êtes-vous sûr de vouloir archiver ce client ?')) {
                form.submit();
            }
        }

        let clientIdToArchive = null;

// Fonction pour définir l'ID du client à archiver
    function setArchiveClientId(clientId) {
        clientIdToArchive = clientId;
    }

    // Fonction pour confirmer l'archivage
    document.getElementById('confirmArchive').addEventListener('click', function() {
        if (clientIdToArchive) {
            // Soumettre le formulaire correspondant à l'ID du client
            document.getElementById(`archiveForm-${clientIdToArchive}`).submit();
        }
        // Fermer le modal
        $('#archiveModal').modal('hide');
    });

</script>
</body>
</html>
