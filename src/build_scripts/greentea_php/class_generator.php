<?php


// Scan all app C files and plug it to $cFiles
recursive_callback_scan(APP_DIR,
    function (string $file, string $dir, int $index) use (&$cFiles, $buildDir) {

        $edir = explode(APP_DIR, $dir, 2);
        $edir = empty($edir[1]) ? "" : ltrim($edir[1]."/", "/");

        if (preg_match("/(.+)\\.c\\.c$/", $file, $m)) {
            $target = $edir.$m[1].".compiled.c";
            file_put_contents(
                $buildDir."/app/".$target,
                generate_class($dir."/".$file)
            );
            $cFiles .= " app/".$target;
        }
    }
);

