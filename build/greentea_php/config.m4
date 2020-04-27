
dnl config.m4
PHP_ARG_ENABLE(greentea, for greentea support,
[  --enable-greentea            Include greentea support])

if test "$PHP_GREENTEA" != "no"; then
  PHP_REQUIRE_CXX()
  PHP_ADD_INCLUDE(/home/ammarfaizi2/project/now/GreenTeaPHP)
  PHP_ADD_INCLUDE(/home/ammarfaizi2/project/now/GreenTeaPHP/src/sources/greentea_php)
  PHP_ADD_INCLUDE(/home/ammarfaizi2/project/now/GreenTeaPHP/src/sources/greentea_php/include)
  PHP_ADD_INCLUDE(/home/ammarfaizi2/project/now/GreenTeaPHP/build/greentea_php/include)

  PHP_NEW_EXTENSION(greentea, app_entry.compiled.cpp greentea_php.compiled.c classes/GreenTea/GreenTea.compiled.cpp helpers/global.c helpers/pcre.c helpers/php.c modules/GreenTea/PDO.compiled.cpp modules/GreenTea/PDO.compiled.hpp, $ext_shared,, "-Wall")
  PHP_SUBST(GREENTEA_SHARED_LIBADD)
fi
