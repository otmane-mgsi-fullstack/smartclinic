<?php

namespace Modules\Medecin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Medecin\Database\Factories\DisponibiliteFactory;
use Modules\Medecin\App\Models\Medecin;

class Disponibilite extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $fillable = [
        'date',
        'heure_debut',
        'heure_fin',
        'statut',
        'medecin_id'
    ];
    public function isDisponible()
    {
        return $this->disponibilites()->where('statut', 'disponible')->exists();
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }
    // protected static function newFactory(): DisponibiliteFactory
    // {
    //     // return DisponibiliteFactory::new();
    // }
}
