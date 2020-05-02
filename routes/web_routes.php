<?php
$routes = [
  [
    "pat" => ["/^\/hello$/", []],
    "act" => [
      "class" => "App::GreenTea::Controllers::Index",
      "method" => "hello"
    ]
  ],

  [
    "pat" => ["/^\/query_string$/", []],
    "act" => [
      "class" => "App::GreenTea::Controllers::Index",
      "method" => "query_string"
    ]
  ],

  [
    "pat" => ["/^\/call_php_func$/", []],
    "act" => [
      "class" => "App::GreenTea::Controllers::Index",
      "method" => "call_php_func"
    ]
  ],

  [
    "pat" => ["/^\/php_global_var$/", []],
    "act" => [
      "class" => "App::GreenTea::Controllers::Index",
      "method" => "php_global_var"
    ]
  ],
];

echo "_gt_web_routes gt_web_routes[".(sizeof($routes) + 1)."];\n";
echo "void WebRoutes::initWebRoutes()\n{\n";
foreach ($routes as $k => $route) {

  $cm = explode("::", $route["act"]["class"]);
  $className = end($cm); unset($cm[count($cm) - 1]);
  $namespace = implode("::", $cm);

?>
  gt_web_routes[<?php echo $k; ?>].pat = mp_compile("<?php
    echo str_replace(["\\"], ["\\\\"], substr($route["pat"][0], 1, -1));
  ?>", <?php
    $flag = implode(" | ", $route["pat"][1]);
    echo empty($flag) ? 0 : $flag;
  ?>);
  gt_web_routes[<?php echo $k; ?>].handler = [](route_pass &r) {
    <?php echo $className ?> *st = new <?php echo $className; ?>(r);
    bool ret = st-><?php echo $route["act"]["method"]; ?>();
    delete st;
    return ret;
  };
<?php
  $namespaces[] = $namespace;
}

$handle = fopen("{$__targetDirname}/using_def.hpp", "w");
flock($handle, LOCK_EX);
foreach (array_unique($namespaces) as $namespace) {
  fwrite($handle, "using namespace {$namespace};\n");
}
fclose($handle);
echo "\n}\n";
