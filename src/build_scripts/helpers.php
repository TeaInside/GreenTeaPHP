<?php

/**
 * @param string    $dir
 * @param ?callable $callback
 * @return void
 */
function recursive_callback_scan(string $dir, ?callable $callback = null): void
{
    $scan = scandir($dir);
    $hasCallable = is_callable($callback);
    unset($scan[0], $scan[1]); // remove "." and ".."

    foreach ($scan as $k => $v) {
        if (is_dir($dir."/".$v)) {
            recursive_callback_scan($dir."/".$v, $callback);
        } else {
            if ($hasCallable) {
                $callback($v, $dir, $k);
            }
        }
    }
}
