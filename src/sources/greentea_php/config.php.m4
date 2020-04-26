
<?php ?>
dnl config.m4
PHP_ARG_ENABLE(greentea, for greentea support,
[  --enable-greentea            Include greentea support])

if test "$PHP_GREENTEA" != "no"; then

<?php echo ConfigM4::generateIncludePath(); ?>

<?php echo ConfigM4::phpNewExt(); ?>

  PHP_SUBST(GREENTEA_SHARED_LIBADD)
fi
