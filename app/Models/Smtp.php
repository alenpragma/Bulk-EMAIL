<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Smtp extends Model
{
    use HasFactory;
    protected $table    = 'smtps';
    protected $fillable = ['from_email', 'emails', 'email_pass', 'host_name', 'imap_port', 'campaign','limit'];
}
