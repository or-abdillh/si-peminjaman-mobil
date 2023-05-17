<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function validationsAsApplicant()
    {
        return $this->hasMany(Validation::class, 'applicant_signature');
    }

    public function validationsAsDeputy()
    {
        return $this->hasMany(Validation::class, 'deputy_signature');
    }

    public function validationsAsManager()
    {
        return $this->hasMany(Validation::class, 'manager_signature');
    }
}
