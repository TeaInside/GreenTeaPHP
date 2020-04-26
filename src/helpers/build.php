<?php

/**
 * @param string  $dir
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

/**
 * @param string $dir
 * @return void
 */
$shechdir = BASEPATH;
function shechdir(string $dir): void
{
  global $shechdir;
  $shechdir = $dir;
}

/**
 * @param string $cmd
 * @param bool   $silent
 * @return void
 */
function she(string $cmd, bool $silent = false): void
{
  global $shechdir;

  $pipes = null;
  $fd = [
    ["file", "php://stdin", "r"],
    ["file", ($silent ? "/dev/null" : "php://stdout"), "w"],
    ["file", ($silent ? "/dev/null" : "php://stderr"), "w"],
  ];

  $p = proc_open($cmd, $fd, $pipes, $shechdir);
  proc_close($p);
}

/**
 * @param string $dir
 * @return bool
 */
function mkdirp(string $dir)
{
  $rdir = "";
  foreach (explode("/", $dir) as $v) {
    $rdir .= $v."/";
    is_dir($rdir) or mkdir($rdir);
  }
  return is_dir($dir);
}
