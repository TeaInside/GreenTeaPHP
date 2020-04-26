
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
