<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Event extends Model
{
    use HasFactory;
    protected $table = 'events';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'date',
        'venue',
        'available_seats',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public $timestamps = true;
}
