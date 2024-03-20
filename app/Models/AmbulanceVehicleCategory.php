<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmbulanceVehicleCategory extends Model
{
    use HasFactory;

    protected $primaryKey = 'ambulance_category_vehicle_id';
    protected $table = 'ambulance_category_vehicle';

}
