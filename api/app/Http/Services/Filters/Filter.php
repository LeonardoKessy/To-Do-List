<?php

namespace App\Http\Services\Filters;

use Illuminate\Http\Request;

class Filter {
    protected $suffixes = [
        "_max" => "<=",
        "_min" => ">=",
        "_like" => "LIKE"
    ];

    public function transform(Request $request, $safeParams) {
        $queries = [];
        foreach ($request->query() as $param => $value) {
            $field = $this->__getField($param, $safeParams);
            if (!$field) continue;

            $operation = $this->__getOperation($param, $safeParams[$field]);
            
            $value = $operation === "LIKE" ? "%$value%" : $value;
           
            $queries[] = [$field, $operation, $value];
        }
        return $queries;
    }

    protected function __getField($param, $safeParams) {
        foreach ($safeParams as $field => $suffixes) 
            if (str_starts_with($param, $field)) 
                return $field;
        return false;
    }

    protected function __getOperation($param, $suffixes) {
        foreach ($suffixes as $suffix) 
            if (str_ends_with($param, $suffix)) 
                return $this->suffixes[$suffix];
        return "=";
    }
}