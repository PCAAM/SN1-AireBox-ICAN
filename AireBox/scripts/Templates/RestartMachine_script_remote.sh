#!/bin/bash

# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
# Version: @(#)sftp v.2.8.12.0 // 19-06-14 arce@redcitroen.com

# "-----  Reinicio de la maquina de AireBox  -----"

PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)
PID_SINCRO=sincro.pid
PID_ENVIO=envio.pid
DAEMON_SINCRO=daemon_sincroDCS.sh
DAEMON_ENVIO=daemon_envioDCS.sh

set -e

/sbin/shutdown -r +1 || { 
	if [ -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_SINCRO ];then
		if [ -w ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_SINCRO ];then
			cd ""$PATH_AIREBOX""/Suite_DCS/scripts;			
			NFICHERO=$(find -name daemon_sincroDCS*.sh)
			sh ""$PATH_AIREBOX""/Suite_DCS/scripts/$NFICHERO restart;
		fi
	fi
	if [ -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_ENVIO ];then
        if [ -w ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_ENVIO ];then  
			cd ""$PATH_AIREBOX""/Suite_DCS/scripts;		
			NFICHERO=$(find -name daemon_envioDCS*.sh);
			sh ""$PATH_AIREBOX""/Suite_DCS/scripts/$NFICHERO restart;
        fi
	fi
}


