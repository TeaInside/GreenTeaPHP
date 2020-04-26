
#define WEBROUTES_CPP

#include "/home/ammarfaizi2/project/now/GreenTeaPHP/build/greentea_php/routes/using_def.hpp"
#ifndef ROUTES_WEB_HPP
#define ROUTES_WEB_HPP

#ifdef __cplusplus
#include <functional>
extern "C" {
#include <greentea/helpers/pcre.h>
}

typedef struct _route_pass {
  char *uri;
  char *query_str;
  size_t uri_len;
  size_t query_str_len;
  pcre_res match;
} route_pass;

typedef struct {
  pcre2_code *pat;
  std::function<bool(route_pass &)> handler;
} _gt_web_routes;

class WebRoutes
{
private:
  char *uri;
public:
  WebRoutes(char *uri);
  static void initWebRoutes();
};

extern "C" {
void GreenTeaInitWebRoutes();
void RouteExec(char *uri, size_t uri_len, char *query_str, size_t query_str_len);
}

#else // #ifdef __cplusplus

extern void GreenTeaInitWebRoutes();
extern void RouteExec(char *uri, size_t uri_len, char *query_str, size_t query_str_len);

#endif // #ifdef __cplusplus

#endif

_gt_web_routes gt_web_routes[10];
#define rts gt_web_routes
#define routes_count (sizeof(gt_web_routes)/sizeof(gt_web_routes[0]))

WebRoutes::WebRoutes(char *uri)
{
  this->uri = uri;
}

void WebRoutes::initWebRoutes()
{
  gt_web_routes[0].pat = mp_compile("^\\/hello$", PCRE2_CASELESS);
  gt_web_routes[0].handler = [](route_pass &r) {
    Index *st = new Index(r);
    bool ret = st->hello();
    delete st;
    return ret;
  };

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