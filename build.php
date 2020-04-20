<?php

require __DIR__."/build_config.php";

// Load helpers.
require BASEPATH."/src/build_scripts/helpers.php";

// Create build dir if it does not exist.
is_dir(BUILD_DIR) or mkdir(BUILD_DIR);

// Build GreenTea PHP extension.
require BASEPATH."/src/build_scripts/greentea_php.php";

