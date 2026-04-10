<?php
namespace Modules\Rdv\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Patient\App\Models\Patient;
use Modules\Medecin\App\Models\Medecin;
use Modules\Consultation\App\Models\Consultation;

use Modules\Medecin\App\Models\Disponibilite;

class RendezVous extends Model
{
    protected $table = 'rendez_vous';

    protected $fillable = [
        'date_heure',
        'statut',
        'motif',
        'notes',
        'patient_id',
        'medecin_id',
        'disponibilite_id'
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function medecin()
    {
        return $this->belongsTo(Medecin::class);
    }

    public function disponibilite()
    {
        return $this->belongsTo(Disponibilite::class);
    }

    public function consultation()
    {
        return $this->hasOne(\Modules\Consultation\App\Models\Consultation::class);
    }
}
