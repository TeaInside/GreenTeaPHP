
extern "C" {

#include <web.hpp>

greentea_routes greentea_php_routes[3];

#define rts greentea_php_routes

void greentea_init_routes()
{
  rts[0].pat = mp_compile("^\\/index", 0);
  rts[0].handler = (void *)0;
}

#undef rts

}
