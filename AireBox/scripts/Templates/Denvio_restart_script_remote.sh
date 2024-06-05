#!/bin/bash

# Author: Ivan Lois
# Version: @(#)Reboot Envio v.2.8.12.0 // 26-09-13 arce@redcitroen.com

# "-----  Reboot de servicio Envio_DCS correspondiente a la instancia  -----"


PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)
PID_ENVIO=envio.pid
DAEMON_ENVIO=daemon_envioDCS.sh

if [ -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_ENVIO ];then
        if [ -w ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_ENVIO ];then
                cd ""$PATH_AIREBOX""/Suite_DCS/scripts
				NFICHERO=$(find -name daemon_envioDCS*.sh)
				sh ""$PATH_AIREBOX""/Suite_DCS/scripts/$NFICHERO restart
        fi
fi


