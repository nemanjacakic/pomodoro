<?php
namespace App\Http\Traits;

trait Casts {
    private function cast($var, $type)
    {
        if ( $type === 'integer' ) {
            return (integer) $var;
        } else if ( $type === 'boolean' ) {
            return (boolean) $var;
        }

        return $var;
    }
}
