<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsertLead extends Model
{
    use HasFactory;
    protected $table='insert_leads';
    protected $fillabe=['campaign','emails','user_id'];
}
