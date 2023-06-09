<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    use HasFactory;

    public $table = 'institutions';

    protected $fillable = [
        'code',
        'name',
    ];

    public function authors()
    {
        return $this->hasMany(Author::class);
    }
}
