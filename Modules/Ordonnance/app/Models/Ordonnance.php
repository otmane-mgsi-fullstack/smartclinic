<?php
namespace Modules\Ordonnance\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Consultation\App\Models\Consultation;

class Ordonnance extends Model
{
    protected $table = 'ordonnances';

    protected $fillable = [
        'date_prescription',
        'medicaments',
        'instructions',
        'consultation_id'
    ];

    protected $casts = [
        'date_prescription' => 'date',
    ];

    /**
     * Relation avec Consultation
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }
}
