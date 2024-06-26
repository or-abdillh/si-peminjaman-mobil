<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Letter extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $guarded = ['id'];
    protected $dates = ['deleted_at'];

    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    public function feedback()
    {
        return $this->hasOne(Feedback::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validation()
    {
        return $this->hasOne(Validation::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
