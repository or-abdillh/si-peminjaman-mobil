<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserManager extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function employeeDetail()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function managerDetail()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}
