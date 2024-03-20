<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceCategory extends Model
{
    use HasFactory;
    protected $primaryKey = 'ambulance_category_id';
    protected $table = 'ambulance_category';

}
