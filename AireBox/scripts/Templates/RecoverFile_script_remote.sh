#!/bin/bash

# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
# Version: @(#)sftp v.2.8.11.0 // 10-06-14 arce@redcitroen.com

# "-----  Recuperacion de AireBox del fichero CIBLE -----"
# Sustituir NOM_CIBLE por sus valores correctos

FILE_SOURCE=NOMBRE_CIBLE

PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)
N_TERCERO=$(head ""$PATH_AIREBOX""/Suite_DCS/config/envio_DCS.ini|grep "n_tercero"|cut -d "=" -f2)

FROM_FILE=""$PATH_AIREBOX""/backup_DCS/
TO_FILE=""$PATH_AIREBOX""/envio_DCS/

cp $FROM_FILE$N_TERCERO$FILE_SOURCE* $TO_FILE

RUTA=""$PATH_AIREBOX""/Suite_DCS/scripts
mv $RUTA/SenderAireBox.jar ""$PATH_AIREBOX""/Suite_DCS/bin/SenderAireBox.jar
cd ""$PATH_AIREBOX""/Suite_DCS
nohup java -Xrs -jar ""$PATH_AIREBOX""/Suite_DCS/bin/SenderAireBox.jar 