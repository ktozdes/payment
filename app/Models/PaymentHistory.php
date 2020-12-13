<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class
PaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = ['status_id', 'payment_id'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
}
