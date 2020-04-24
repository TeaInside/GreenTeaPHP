dnl config.m4
PHP_ARG_ENABLE(greentea, for greentea support,
[  --enable-greentea            Include greentea support])

if test "$PHP_GREENTEA" != "no"; then
$~~INCLUDES~~$
  PHP_NEW_EXTENSION(greentea, $~~FILES~~$, $ext_shared,, "-Wall -lpthread")
  PHP_SUBST(GREENTEA_SHARED_LIBADD)
fi