
#define WEBROUTES_CPP

<?php
echo "#include \"{$__targetDirname}/using_def.hpp\"";
require "{$__curdir}/WebRoutes.hpp";
?>

_gt_web_routes gt_web_routes[10];
#define rts gt_web_routes
#define routes_count (sizeof(gt_web_routes)/sizeof(gt_web_routes[0]))

WebRoutes::WebRoutes(char *uri)
{
  this->uri = uri;
}

void WebRoutes::initWebRoutes()
{
<?php require "{$__curdir}/web_routes.php"; ?>
}

extern "C" {
void GreenTeaInitWebRoutes()
{
  WebRoutes::initWebRoutes();
}

void RouteExec(char *uri, size_t uri_len, char *query_str, size_t query_str_len)
{
  route_pass r;
  for (size_t i = 0; i < routes_count; i++) {
    if (!rts[i].pat) continue;
    if (gt_pcre_find(rts[i].pat, (const unsigned char *)(uri), &(r.match))) {
      bool ret = rts[i].handler(r);
      gt_pcre_res_destroy(&(r.match));
      if (ret) {
        break;
      }
    }
  }
}

}
