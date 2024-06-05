#!/bin/bash

# Author: Ivan Lois
# Version: @(#)reconfIni v.2.8.14.0 // 30-09-14 arce@redcitroen.com

# "-----  Reconfiguracion de archivos .ini  -----"


PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)
RUTA=""$PATH_AIREBOX""/Suite_DCS/scripts
PID_SINCRO=sincro.pid
PID_ENVIO=envio.pid
DAEMON_SINCRO=daemon_sincroDCS.sh
DAEMON_ENVIO=daemon_envioDCS.sh

if [ -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_SINCRO ];then
        if [ -w ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_SINCRO ];then
                sh $RUTA/$DAEMON_SINCRO stop
        fi
fi
if [ -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_ENVIO ];then
        if [ -w ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_ENVIO ];then
                sh $RUTA/$DAEMON_ENVIO stop
        fi
fi

mv $RUTA/Global_DCS.properties ""$PATH_AIREBOX""/Suite_DCS/Global_DCS.properties
mv $RUTA/sincro_DCS.ini ""$PATH_AIREBOX""/Suite_DCS/config/sincro_DCS.ini
mv $RUTA/envio_DCS.ini ""$PATH_AIREBOX""/Suite_DCS/config/envio_DCS.ini
mv $RUTA/recep_DCS.ini ""$PATH_AIREBOX""/Suite_DCS/config/recep_DCS.ini
mv $RUTA/update_DCS.ini ""$PATH_AIREBOX""/Suite_DCS/config/update_DCS.ini

if [ ! -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_SINCRO ];then
	sh $RUTA/$DAEMON_SINCRO start
fi
if [ ! -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_ENVIO ];then
	sh $RUTA/$DAEMON_ENVIO start
fi