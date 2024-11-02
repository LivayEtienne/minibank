<!-- resources/views/transactions/index.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4 text-center">Liste des Transactions</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($transactions->isEmpty())
            <div class="alert alert-warning text-center">
                <strong>Aucune transaction trouvée.</strong>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Compte Source</th>
                            <th>Compte Destinataire</th>
                            <th>Agent</th>
                            <th>Montant (CFA)</th>
                            <th>Type</th>
                            <th>Frais (CFA)</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ $transaction->compteSource->nom }} {{ $transaction->compteSource->prenom }}</td>
                                <td>{{ $transaction->compteDestinataire->nom }} {{ $transaction->compteDestinataire->prenom }}</td>
                                <td>{{ $transaction->agent->nom }} {{ $transaction->agent->prenom }}</td>
                                <td>{{ number_format($transaction->montant, 2, ',', ' ') }}</td>
                                <td>{{ ucfirst($transaction->type) }}</td>
                                <td>{{ number_format($transaction->frais, 2, ',', ' ') }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="d-flex justify-content-center mt-4">
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">Nouvelle Transaction</a>
        </div>
    </div>
@endsection
