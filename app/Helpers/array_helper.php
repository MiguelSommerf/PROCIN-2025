<?php

if (!function_exists('empty_array')) {
    /**
     * 
     * @param array $array
     * @return bool 
     * 
     */
    function empty_array(array $array): bool {
        foreach ($array as $row) {
            if (empty(trim($row))) {
                return true;
            }
        }
    
        return false;
    }
}