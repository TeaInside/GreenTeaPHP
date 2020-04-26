
#include <iostream>

#include "Index.hpp"

namespace App::GreenTea::Controllers {

Index::Index(route_pass &_r): r(_r)
{
}

bool Index::hello()
{
  php_printf("Hello World from App::GreenTea::Controllers::Index::hello()!\n");
  return true;
}

} // namespace App::GreenTea::Controllers
