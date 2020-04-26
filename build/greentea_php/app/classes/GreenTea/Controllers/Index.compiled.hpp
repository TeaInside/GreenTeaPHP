
#ifndef __HEADER_3c85ed64206d392261861b6f03f90d62
#define __HEADER_3c85ed64206d392261861b6f03f90d62

#include "greentea_php.h"
#include "routes/WebRoutes.hpp"

namespace App::GreenTea::Controllers {

class Index
{
private:
  route_pass &r;
public:
  Index(route_pass &r);
  bool hello();
};

} // namespace App::GreenTea::Controllers

#endif
