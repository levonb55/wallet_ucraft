<?php

if (!function_exists('format_number')) {
    function format_number($num)
    {
        return number_format($num, 2);
    }
}
