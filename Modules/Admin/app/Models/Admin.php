<?php
namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Admin extends Model
{
    protected $table = 'admins';

    protected $fillable = [
    'niveau_acces',
    'user_id'
    ];

    // relation avec User
    public function user()
    {
    return $this->belongsTo(User::class);
    }

    // helpers utiles
    public function isSuperAdmin()
    {
    return $this->niveau_acces === 'super_admin';
    }

    public function isAdmin()
    {
    return $this->niveau_acces === 'admin';
    }
}
