<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    // Table Name
    protected $table = 'associations';
    // Primary Key
    public $primaryKey = 'id';
    // Timestamps
    public $timestamps = true;
}
