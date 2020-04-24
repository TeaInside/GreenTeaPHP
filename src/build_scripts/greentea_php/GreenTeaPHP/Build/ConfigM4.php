<?php

namespace GreenTeaPHP\Build;

final class ConfigM4
{
    /**
     * @var array
     */
    private static $files = [];

    /**
     * @var array
     */
    private static $includePaths = [];

    /**
     * @param string $file
     * @return void
     */
    public static function addFile(string $file): void
    {
        self::$files[] = $file;
    }

    /**
     * @param string $path
     * @return void
     */
    public static function addIncludePath(string $path): void
    {
        self::$includePaths[] = $path;
    }

    /**
     * @param string
     */
    public static function generateIncludePath(): string
    {
        $r = "";
        foreach (self::$includePaths as $k => $v) {
            $r .= "  PHP_ADD_INCLUDE({$v})\n";
        }
        return $r;
    }

    /**
     * @return string
     */
    public static function phpNewExt(): string
    {
        $files = "";
        foreach (self::$files as $k => $v) {
            $files .= $v." ";
        }
        $files = trim($files);
        return "  PHP_NEW_EXTENSION(greentea, {$files}, \$ext_shared,, \"-Wall -lpthread\")";
    }

    /**
     * @param string $configFile
     * @param string $targetDir
     * @return void
     */
    public static function buildConfigM4File(string $configFile, string $targetDir): void
    {
        ob_start();
        require $configFile;
        $out = ob_get_clean();
        file_put_contents($targetDir."/config.m4", $out);
    }

    public static function plugToMakefile()
    {
        $r = "\$(LIBTOOL) --mode=compile \$(CC) -Wall -lpthread -I. -I".." $(COMMON_FLAGS) $(CFLAGS_CLEAN) $(EXTRA_CFLAGS)  -c /home/ammarfaizi2/project/now/GreenTeaPHP/build/greentea_php/classes/GreenTea/GreenTea.compiled.php.c -o classes/GreenTea/GreenTea.lo";
    }
}
