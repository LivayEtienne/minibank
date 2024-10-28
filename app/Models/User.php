<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'email',
        'telephone',
        'photo',
        'date_naissance',
        'adresse',
        'cni',
        'role', // Assurez-vous que 'role' est ici
        'statut',
        'date_creation',
        'mot_de_passe',
        'archived',
    ];

    /**
     * Les attributs qui doivent être masqués pour les tableaux.
     *
     * @var array<int, string>
     */
    /**
     * Les attributs qui doivent être masqués pour les tableaux.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'mot_de_passe',
        'mot_de_passe',
        'remember_token',
    ];

    /**
     * Les attributs qui doivent être castés en types natifs.
     *
     * @var array<string, string>
     */
    /**
     * Les attributs qui doivent être castés en types natifs.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'date_naissance' => 'date',
        'email_verified_at' => 'datetime',
        'archived' => 'boolean',
    ];

    /**
     * Définit la valeur du mot de passe haché.
     *
     * @param string $value
     * @return void
     */
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = bcrypt($value);
    }

    /**
     * Scope pour récupérer uniquement les clients archivés.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query)
    /**
     * Définit la valeur du mot de passe haché.
     *
     * @param string $value
     * @return void
     */
    public function setMotDePasseAttribute($value)
    {
        $this->attributes['mot_de_passe'] = bcrypt($value);
    }

    /**
     * Scope pour récupérer uniquement les clients archivés.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeArchived($query)
    {
        return $query->where('archived', true);
    }

    /**
     * Scope pour récupérer uniquement les clients actifs.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('archived', false);
    }

    /**
     * Scope pour filtrer les utilisateurs par rôle.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $role
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilterByRole($query, $role)
    {
        // Appliquer le filtre en fonction du rôle
        if ($role !== 'all') {
            return $query->where('role', $role);
        }

        return $query;
    }
}




