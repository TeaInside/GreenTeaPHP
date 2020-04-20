<?php

/**
 * @param string $file
 * @return string
 */
function generate_class(string $file): string
{
    ob_start();
    require $file;
    $out = ob_get_clean();

    return $out;
}
