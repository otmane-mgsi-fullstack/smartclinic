<?php

namespace Modules\Medecin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Medecin\Database\Factories\MedecinFactory;
use App\Models\User;

class Medecin extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'medecins';

    protected $fillable = [
        'specialite',
        'tarif_consultation',
        'biographie',
        'user_id'
    ];
    protected $casts = [
        'tarif_consultation' => 'decimal:2',
    ];
    // relation avec User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rendezVous()
    {
        return $this->hasMany(\Modules\Rdv\App\Models\RendezVous::class);
    }

    public function disponibilites()
    {
        return $this->hasMany(\Modules\Medecin\App\Models\Disponibilite::class);
    }


    public function hasDisponibilites()
    {
        // Vérifie si le médecin a au moins un créneau libre
        return $this->disponibilites()->where('statut', 'disponible')->exists();
    }


    // protected static function newFactory(): MedecinFactory
    // {
    //     // return MedecinFactory::new();
    // }
}
