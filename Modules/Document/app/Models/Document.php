<?php
namespace Modules\Document\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Patient\App\Models\Patient;

class Document extends Model
{
    protected $table = 'documents';

    protected $fillable = [
        'type_document',
        'nom_fichier',
        'chemin_fichier',
        'taille_fichier',
        'date_upload',
        'patient_id'
    ];

    protected $casts = [
        'date_upload' => 'datetime',
    ];

    /**
     * Relation avec Patient
     */
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }
}
