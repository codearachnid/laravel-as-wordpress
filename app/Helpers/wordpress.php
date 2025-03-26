<?php

if (! function_exists('maybe_unserialize')) {
    function maybe_unserialize($data) {
        return is_serialized($data) ? unserialize($data) : $data;
    }
}

if (! function_exists('is_serialized')) {
    function is_serialized($data) {
        return is_string($data) && preg_match('/^(a|O|s|i|b|d):/', $data);
    }
}