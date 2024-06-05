#!/bin/bash

# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
# Version: @(#)sftp v.2.8.21.0 // 03-07-14 arce@redcitroen.com

# "-----  Desactivacion de SCRATCH  -----"

PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)

cd ""$PATH_AIREBOX""/Suite_DCS

if [ -e ""$PATH_AIREBOX""/Suite_DCS/scratch.ON ]; then
	mv ""$PATH_AIREBOX""/Suite_DCS/scratch.ON ""$PATH_AIREBOX""/Suite_DCS/scratch.OFF
fi
