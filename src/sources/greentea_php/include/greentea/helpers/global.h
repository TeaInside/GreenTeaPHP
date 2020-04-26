
#ifndef HELPERS__GLOBAL_H
#define HELPERS__GLOBAL_H

#ifdef __cplusplus
extern "C" {
#endif

zval *get_server_var(char *key);
zval *get_post_var(char *key);
zval *get_get_var(char *key);
char *trim(char *str);
char *strtoupper(char *str, unsigned int len);
char *strtolower(char *str, unsigned int len);

#ifdef __cplusplus
}
#endif

#endif
