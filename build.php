<?php

require __DIR__."/config/build.php";

require BASEPATH."/src/helpers/build.php";

// Create build dir if it does not exist.
is_dir(BUILD_DIR) or mkdir(BUILD_DIR);

// Build GreenTea PHP extension.
$builds = [
    BASEPATH."/src/build_scripts/greentea_php/builder.php"
];

// Do it here to isolate local variables.
function req_isolate_variables(string $file)
{
  require $file;
}

foreach ($builds as $v) {
  req_isolate_variables($v);
}
