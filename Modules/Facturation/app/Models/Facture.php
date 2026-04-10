<?php

namespace Modules\Facturation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Facturation\Database\Factories\FactureFactory;
use Modules\Consultation\App\Models\Consultation;
use Modules\Facturation\App\Models\Paiement;

class Facture extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'factures';

    protected $fillable = [
        'numero_facture',
        'date_emission',
        'montant_total',
        'montant_paye',
        'statut',
        'consultation_id'
    ];

    protected $casts = [
        'date_emission' => 'date',
        'montant_total' => 'decimal:2',
        'montant_paye' => 'decimal:2',
    ];

    /**
     * Relation avec Consultation
     */
    public function consultation()
    {
        return $this->belongsTo(Consultation::class);
    }

    public function paiements()
    {
        return $this->hasMany(Paiement::class);
    }
    // protected static function newFactory(): FactureFactory
    // {
    //     // return FactureFactory::new();
    // }
}
