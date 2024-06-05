#!/bin/bash

# Author: Ivan Lois
# Version: @(#)reconfIni v.2.8.31.0 // 10-05-18 arce@redcitroen.com

# "-----  Reconfiguracion de archivos transfer.flx  -----"


PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)
RUTA=""$PATH_AIREBOX""/Suite_DCS/

if [ -f $RUTA/config/transfer.flx ]
then
	sed -i s/"ftp.dekra-automotivesolutions.com, 2222"/"ftp2.dekra-automotivesolutions.com, 22"/g $RUTA/config/transfer.flx
fi
