<?php

namespace Cinebaz\SupportTicket\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $fillable =[

        'status'
    ];

    public function details(){
        return $this->hasMany(SupportDetail::class);
    }

    public function ratings(){
        return $this->hasOne(Rating::class);
    }


}
