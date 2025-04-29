<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;
    protected $table = 'booking_details';
    protected $primaryKey = 'id';
    protected $fillable = [
        'event_id',
        'user_id',
        'booking_name',
        'booking_date',
        'status',
        'created_by',
        'updated_by',
    ];
    public $timestamps = true;
}
