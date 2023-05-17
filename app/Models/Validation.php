<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Validation extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function letter()
    {
        return $this->belongsTo(Letter::class);
    }

    public function applicantSignature()
    {
        return $this->belongsTo(Signature::class, 'applicant_signature');
    }

    public function deputySignature()
    {
        return $this->belongsTo(Signature::class, 'deputy_signature');
    }

    public function managerSignature()
    {
        return $this->belongsTo(Signature::class, 'manager_signature');
    }
}
