#!/bin/bash

# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
# Version: @(#)sftp v.2.8.12.0 // 03-07-14 arce@redcitroen.com

# "-----  Activacion de AireBox  -----"

PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)

cd ""$PATH_AIREBOX""/Suite_DCS/scripts
for i in inactive_*.sh; do
	mv $i ${i:9}
done

echo -ne "2.8.12.0" > $PATH_AIREBOX""/Suite_DCS/version.txt