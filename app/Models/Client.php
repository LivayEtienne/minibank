<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    // app/Http/Controllers/ClientController.php
public function block($id)
{
    $client = Client::find($id);

    if ($client) {
        $client->statut = 'bloqué';
        $client->save();

        return response()->json(['success' => 'Client bloqué avec succès.']);
    }

    return response()->json(['error' => 'Client non trouvé.'], 404);
}

}
