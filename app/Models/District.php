<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    public $table = 'districts';

    public $fillable = [
        'id',
        'regency_id',
        'name',
    ];

    public $timestamps = false;

    public function regency()
    {
        return $this->belongsTo(Regency::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function samples()
    {
        return $this->hasMany(Sample::class);
    }

    public function hivCases()
    {
        return $this->hasMany(HivCase::class);
    }
}
