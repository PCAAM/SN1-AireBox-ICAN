#!/bin/bash

# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
# Version: @(#)sftp v.2.8.21.0 // 03-07-14 arce@redcitroen.com

# "-----  Activacion de SCRATCH  -----"

PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)

cd ""$PATH_AIREBOX""/Suite_DCS

if [ ! -e ""$PATH_AIREBOX""/Suite_DCS/scratch.ON ]; then
	touch ""$PATH_AIREBOX""/Suite_DCS/scratch.ON
fi

if [ -e ""$PATH_AIREBOX""/Suite_DCS/scratch.OFF ]; then
	rm -rf ""$PATH_AIREBOX""/Suite_DCS/scratch.OFF
fi
