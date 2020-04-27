
#ifndef __HEADER_dda2ba9fbc2364805f24c92fb8f019f8
#define __HEADER_dda2ba9fbc2364805f24c92fb8f019f8

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
};

} // namespace App::GreenTea::Controllers

#endif
