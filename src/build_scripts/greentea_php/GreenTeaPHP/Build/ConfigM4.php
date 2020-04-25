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

    /**
     * @return void
     */
    public static function plugToMakefile(string $targetDir): void
    {
        $makeFile = $targetDir."/Makefile";
        $bakFile = $targetDir."/Makefile.bak";
        if (!file_exists($bakFile)) {
            copy($makeFile, $bakFile);
        }

        $rv1 = explode("shared_objects_greentea", file_get_contents($bakFile), 2);
        $rv2 = explode("\n", $rv1[1], 2);
        
        $m1 = $rv1[0]."shared_objects_greentea";
        $m2 = $rv2[0];
        $m3 = $rv2[1];

        foreach (PHPClass::getCompiledFiles() as $k => $v) {

            $edir = explode($targetDir, $v["dir"], 2);
            $edir = isset($edir[1]) ? trim($edir[1], "/")."/" : "";
            $vtfile = explode(".", $v["file"], 2)[0].".lo";
            $v["dir"] = rtrim($v["dir"], "/");

            $fullPathFile = $v["dir"]."/".$v["file"];

            $m3 .= "# edt\n{$edir}{$vtfile}: {$fullPathFile}\n";

            $m3 .= 
                "\t\$(LIBTOOL) --mode=compile \$(CC) -Wall -lpthread -I. -I".
                escapeshellarg($v["dir"]).
                " \$(COMMON_FLAGS) \$(CFLAGS_CLEAN) \$(EXTRA_CFLAGS) -c ".
                escapeshellarg($fullPathFile)." -o $edir{$vtfile}\n\n";

            $m2 .= " ".$edir.$vtfile;
        }
        $m2 .= "\n";

        file_put_contents($makeFile, $m1.$m2.$m3);
        she("touch -d \"2 hours ago\" ".escapeshellarg($makeFile));
    }
}
