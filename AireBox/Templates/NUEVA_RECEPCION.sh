#!/bin/bash

# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
# Version: @(#)sftp_NOMBRE_CIBLE v.VERSION // FECHA arce@redcitroen.com

# "-----  Recepcion por sFTP de la DMZ del fichero NOMBRE_CIBLE  -----"


NOM_ENVIO=NOMBRE_CIBLE
FILE_SOURCE=NOMBRE_SFTP
FILE_DESTINATION=NOMBRE_DMS
URL_SFTP=NOMBRE_URL

PATH_AIREBOX=$(head Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)
NOM_LOG=diario_$NOM_ENVIO.log
FICHERO_PID=""$PATH_AIREBOX""/Suite_DCS/Log/sftp_$NOM_ENVIO.pid

echo "*********************************** Proceso de envio *************************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1

if [ -e "$FICHERO_PID" ]; then
	echo "El proceso se esta ejecutando. No se lanzara una nueva instancia hasta que finalice"		>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
else
	cd ""$PATH_AIREBOX""/Suite_DCS
	touch "$FICHERO_PID"
	nohup java -Xrs -jar ""$PATH_AIREBOX""/Suite_DCS/bin/recep_SFTP.jar $URL_SFTP $FILE_SOURCE $FILE_DESTINATION >>  ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
	rm -rf "$FICHERO_PID"
	
fi
echo "*********************************** Fin Proceso de envio *********************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1 
echo "" 													>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1 
 
echo "*********************************** Inicio de Archivos de LOG ****************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
cat ""$PATH_AIREBOX""/Suite_DCS/Log/log_recepSFTP_$NOM_ENVIO.log 						>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
if [ $FILE_SOURCE != $FILE_DESTINATION ]; then
	cat ""$PATH_AIREBOX""/Suite_DCS/Log/log_recepSFTP_$FILE_DESTINATION.log					>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
fi
cat ""$PATH_AIREBOX""/Suite_DCS/Log/java_log_recepSFTP_$NOM_ENVIO.log 						>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
if [ $FILE_SOURCE != $FILE_DESTINATION ]; then
	cat ""$PATH_AIREBOX""/Suite_DCS/Log/java_log_recepSFTP_$FILE_DESTINATION.log				>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
fi

echo "*********************************** Fin de Archivos de LOG *******************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
echo "######################################################################################################" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
echo "" 													>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
echo "" 													>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1

# Limpiamos ficheros de log
rm -rf ""$PATH_AIREBOX""/Suite_DCS/Log/log_recepSFTP_$NOM_ENVIO.log 						>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
rm -rf ""$PATH_AIREBOX""/Suite_DCS/Log/log_recepSFTP_$FILE_DESTINATION.log					>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
rm -rf ""$PATH_AIREBOX""/Suite_DCS/Log/java_log_recepSFTP_$NOM_ENVIO.log 					>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
rm -rf ""$PATH_AIREBOX""/Suite_DCS/Log/java_log_recepSFTP_$FILE_DESTINATION.log					>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1