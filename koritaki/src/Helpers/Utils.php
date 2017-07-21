<?php

if ( ! function_exists('dd')) {
    function dd() {
        $args = func_get_args();
        foreach( $args as $arg ) {
            var_dump( $arg );
        }
        die();
    }
}