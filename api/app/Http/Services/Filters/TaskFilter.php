<?php 

namespace App\Http\Services\Filters;

use Illuminate\Http\Request;

class TaskFilter extends Filter {

    protected $safeParams = [
        "tittle" => ["_like"],
        "detail" => ["_like"],
        "color" => []
    ];
}