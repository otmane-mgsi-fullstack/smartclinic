<?php

namespace Modules\Patient\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Patient\Database\Factories\PatientFactory;
use App\Models\User;
class Patient extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cin',
        'date_naissance',
        'adresse',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function rendezVous()
    {
        return $this->hasMany(\Modules\Rdv\App\Models\RendezVous::class);
    }

    public function documents()
    {
        return $this->hasMany(\Modules\Document\App\Models\Document::class);
    }
    // protected static function newFactory(): PatientFactory
    // {
    //     // return PatientFactory::new();
    // }
}
