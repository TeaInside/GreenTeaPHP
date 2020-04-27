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
      "method" => "queryString"
    ]
  ],

  [
    "pat" => ["/^\/test_substr$/", []],
    "act" => [
      "class" => "App::GreenTea::Controllers::Index",
      "method" => "dumpQueryString"
    ]
  ],
];

$handle = fopen("{$__targetDirname}/using_def.hpp", "w");
flock($handle, LOCK_EX);

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
  fwrite($handle, "using namespace {$namespace};\n");
}

echo "\n";
fclose($handle);
