<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatosHistoricos extends Model
{
    protected $table = "datos_historicos";

    protected $fillable = [
    	'tiker',
    	'date',
    	'open',
    	'high',
    	'low',
    	'close',
    	'adjClose',
    	'volume'
    ];

}
