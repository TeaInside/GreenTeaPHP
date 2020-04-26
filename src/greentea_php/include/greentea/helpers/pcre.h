
#ifndef HELPERS__PCRE_H
#define HELPERS__PCRE_H

#define PCRE2_CODE_UNIT_WIDTH 8

#include <stdio.h>
#include <string.h>
#include <pcre2.h>
#include <stdint.h>

typedef struct {
  int count;
  char **r;
} pcre_res;

typedef struct {
  int count;
  pcre_res *r;
} pcre_res_all;

void gt_pcre_res_destroy(pcre_res *result);
pcre2_code *gt_pcre_compile(const unsigned char *pattern, uint32_t options);
int gt_pcre_find(pcre2_code *re, const unsigned char *subject, pcre_res* result);

#define mp_compile(A, B) my_pcre_compile((const unsigned char *)A, B)

#endif
