
#ifndef ROUTES_WEB_HPP
#define ROUTES_WEB_HPP

#include <greentea/helpers/pcre.h>

typedef struct {
  pcre2_code *pat;
  void *handler;
} greentea_routes;


#ifdef __cplusplus

extern "C" void greentea_init_routes();

#else // #ifdef __cplusplus


void greentea_init_routes();


#endif // #ifdef __cplusplus

#endif