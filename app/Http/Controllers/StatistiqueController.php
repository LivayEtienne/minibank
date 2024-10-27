<?
// App\Http\Controllers\StatistiqueController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\transaction;

class StatistiqueController extends Controller
{
    public function index()
    {
        // Récupérer les données de transactions par mois
        $transactionsParMois = Transaction::selectRaw('MONTH(created_at) as mois, SUM(montant) as total_montant')
            ->groupBy('mois')
            ->get()
            ->pluck('total_montant', 'mois')
            ->toArray();

        // Formater les données pour Chart.js
        $moisLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $montantData = array_fill(0, 12, 0); // Initialiser un tableau avec 12 zéros

        foreach ($transactionsParMois as $mois => $montant) {
            $montantData[$mois - 1] = $montant;
        }

        return view('index', compact('moisLabels', 'montantData'));
    }
}
