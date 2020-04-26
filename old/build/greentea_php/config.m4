dnl config.m4
PHP_ARG_ENABLE(greentea, for greentea support,
[  --enable-greentea            Include greentea support])

if test "$PHP_GREENTEA" != "no"; then

  PHP_ADD_INCLUDE(/home/ammarfaizi2/project/now/GreenTeaPHP/src/greentea_php)
  PHP_ADD_INCLUDE(/home/ammarfaizi2/project/now/GreenTeaPHP/src/greentea_php/include)

  PHP_NEW_EXTENSION(greentea, greentea_php.c classes/GreenTea/GreenTea.compiled.php.c helpers/global.c helpers/pcre.c, $ext_shared,, "-Wall")
  PHP_SUBST(GREENTEA_SHARED_LIBADD)
fi
