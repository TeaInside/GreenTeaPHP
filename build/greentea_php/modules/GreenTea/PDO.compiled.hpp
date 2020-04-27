
#ifndef __HEADER_45b59b86ff927bc324604b7743cc79c1
#define __HEADER_45b59b86ff927bc324604b7743cc79c1

#include "greentea_php.h"
#include "routes/WebRoutes.hpp"

namespace GreenTea {

class PDO
{
private:
  zval *pdo;
public:
  PDO();
  ~PDO();
}

} // namespace App::GreenTea::Controllers

#endif
