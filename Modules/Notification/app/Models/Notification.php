<?php
namespace Modules\Notification\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'message',
        'date_envoi',
        'type',
        'titre',
        'est_lue',
        'user_id'
    ];

    protected $casts = [
        'date_envoi' => 'datetime',
        'est_lue' => 'boolean',
    ];

    /**
     * Relation avec User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Marquer comme lue
     */
    public function markAsRead()
    {
        $this->est_lue = true;
        $this->save();
    }
}
