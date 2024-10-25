<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class agentModel extends Model
{
    //
    protected $table = 'transactions';

    protected $fillable = ['id', 'date', 'montant'];
}
