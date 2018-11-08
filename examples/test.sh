#!/usr/bin/env bash

targets=`bin/publisher kong:targets`
for i in ${targets[@]};do
    ip_address=`echo $i |cut -d "&" -f1`
    server_id=`echo $i |cut -d "&" -f2`
    weight=`echo $i |cut -d "&" -f4`


done
echo $targets