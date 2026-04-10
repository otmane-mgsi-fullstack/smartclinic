<?php

namespace Modules\Facturation\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Facturation\Database\Factories\PaiementFactory;
use Modules\Facturation\App\Models\Facture;

class Paiement extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'paiements';

    protected $fillable = [
        'montant',
        'date_paiement',
        'mode_paiement',
        'reference',
        'facture_id'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'date',
    ];

    /**
     * Relation avec Facture
     */
    public function facture()
    {
        return $this->belongsTo(\Modules\Facturation\App\Models\Facture::class);
    }
    // protected static function newFactory(): PaiementFactory
    // {
    //     // return PaiementFactory::new();
    // }
}
