
#include <stdio.h>
#include <greentea_php.h>
#include <IndexController.hpp>

IndexController::IndexController(void *param)
{
  this->param = param;
  printf("Constructor...\n");
}

IndexController::index()
{
  php_printf("Hello World from IndexController!!!\n");
}

extern "C" void *IndexControllerHandler(void *param)
{
  IndexController st = new IndexController(param);
}
