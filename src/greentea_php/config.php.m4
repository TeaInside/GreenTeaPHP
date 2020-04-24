
dnl config.m4
PHP_ARG_ENABLE(greentea, for greentea support,
[  --enable-greentea            Include greentea support])

if test "$PHP_GREENTEA" != "no"; then

  PHP_ADD_INCLUDE(/home/ammarfaizi2/project/now/GreenTeaPHP/src/greentea_php)
  PHP_NEW_EXTENSION(greentea, classes/GreenTea/GreenTea.php.c greentea_php.c greentea_php.php.c app/Http/Controllers/IndexController.compiled.c, $ext_shared,, "-Wall -lpthread")
  PHP_SUBST(GREENTEA_SHARED_LIBADD)
fi
