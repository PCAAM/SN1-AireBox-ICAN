#!/bin/bash

# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
# Version: @(#)sftp_NOMBRE_CIBLE v.VERSION // FECHA arce@redcitroen.com

# "-----  Envio por sFTP a la DMZ del fichero NOMBRE_CIBLE  -----"


NOM_ENVIO=NOMBRE_CIBLE
NOM_CIBLE=NOMBRE_SFTP
NOM_DMS=NOMBRE_DMS
URL_SFTP=NOMBRE_URL

PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)
NOM_LOG=diario_$NOM_ENVIO.log
FICHERO_PID=""$PATH_AIREBOX""/Suite_DCS/Log/sftp_$NOM_ENVIO.pid
IN_FILE=""$PATH_AIREBOX""/envio_DCS/


echo "*********************************** Proceso de envio *************************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1

if [ -e "$FICHERO_PID" ]; then
	echo "El proceso se esta ejecutando. No se lanzara una nueva instancia hasta que finalice"		>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
else

	echo "*********************************** Inicio Proceso de Renombrado **************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
		
		N_TERCERO=$(head ""$PATH_AIREBOX""/Suite_DCS/config/envio_DCS.ini|grep "n_tercero"|cut -d "=" -f2)
		FILES=($IN_FILE$NOM_DMS.*)
		if [ -e ${FILES[0]} ]									>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
		then
			for i in $IN_FILE$NOM_DMS.*; do
				j=`echo $i | sed s/$NOM_DMS/$N_TERCERO$NOM_CIBLE/g`
				echo $i " ... renombrado a ..." $j							>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
				if [[ $i == *'.'* ]]; then
					mv $i $j 										>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
				else
					mv $i $j.0					>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
				fi
			done
		else
			echo "No existen archivos " $NOM_DMS " para renombrar"						>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
		fi
	echo "*********************************** Fin Proceso de Renombrado ****************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1

		cd ""$PATH_AIREBOX""/Suite_DCS
		touch "$FICHERO_PID"
		nohup java -Xrs -jar ""$PATH_AIREBOX""/Suite_DCS/bin/envio_SFTP.jar $URL_SFTP $NOM_CIBLE		>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
		rm -rf "$FICHERO_PID"
		
fi
echo "*********************************** Fin Proceso de envio *********************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1 
echo "" 													>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1 
 
echo "*********************************** Inicio de Archivos de LOG ****************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1 
cat ""$PATH_AIREBOX""/Suite_DCS/Log/log_envioSFTP_$NOM_ENVIO.log 						>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1

echo "*********************************** Fin de Archivos de LOG *******************************************" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
echo "######################################################################################################" 	>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
echo "" 													>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1
echo "" 													>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1

# Limpiamos ficheros de log
rm -rf ""$PATH_AIREBOX""/Suite_DCS/Log/log_envioSFTP_$NOM_ENVIO.log						>> ""$PATH_AIREBOX""/Suite_DCS/Log/$NOM_LOG 2>&1