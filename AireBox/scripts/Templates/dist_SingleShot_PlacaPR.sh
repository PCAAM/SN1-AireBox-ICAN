#!/bin/bash

# Author: Ivan Lois
# Version: @(#)Plantilla_instalar_SingleShot v2.8.28.0 // 11-Sep-2017 arce@redcitroen.com

PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)

echo "Installing Linux/Unix tasks... NOMBRE_SFTP"

if ! crontab -l | grep -q 'sh '$PATH_AIREBOX'/Suite_DCS/scripts/sftp_NOMBRE_SFTP.sh'; then
	
	# Ejecicion SingleShot, a las HORA:MINUTO todos los dias
	crontab -l | sed '/^#.*/d' | { cat; echo "MINUTO HORA * * * cd $PATH_AIREBOX/Suite_DCS/scripts;sh $PATH_AIREBOX/Suite_DCS/scripts/sftp_NOMBRE_SFTP.sh"; } | crontab - 
	
	crontab -l | sed '/^#.*/d' | { cat; echo ; } | crontab - 

	echo "Installing Linux/Unix tasks for NOMBRE_SFTP --> OK"
	
fi
