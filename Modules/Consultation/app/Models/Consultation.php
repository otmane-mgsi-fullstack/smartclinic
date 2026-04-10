<?php
namespace Modules\Consultation\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Rdv\App\Models\RendezVous;

class Consultation extends Model
{
protected $table = 'consultations';

    protected $fillable = [
    'date_consultation',
    'diagnostic',
    'symptomes',
    'traitement',
    'montant',
    'rendez_vous_id'
    ];

    protected $casts = [
        'date_consultation' => 'date',
        'montant' => 'decimal:2',
    ];

    // relation avec RDV
    public function rendezVous()
    {
        return $this->belongsTo(RendezVous::class);
    }

    public function ordonnances()
    {
        return $this->hasMany(\Modules\Ordonnance\App\Models\Ordonnance::class);
    }
}
