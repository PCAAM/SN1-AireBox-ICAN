#!/bin/bash

# Author: Ivan Lois
# Version: @(#)Reboot Sincro v.2.8.12.0 // 26-09-13 arce@redcitroen.com

# "-----  Reboot de servicio Sincro_DCS correspondiente a la instancia  -----"


PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)
PID_SINCRO=sincro.pid
DAEMON_SINCRO=daemon_sincroDCS.sh

if [ -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_SINCRO ];then
        if [ -w ""$PATH_AIREBOX""/Suite_DCS/Log/$PID_SINCRO ];then
                cd ""$PATH_AIREBOX""/Suite_DCS/scripts
				NFICHERO=$(find -name daemon_sincroDCS*.sh)
				sh ""$PATH_AIREBOX""/Suite_DCS/scripts/$NFICHERO restart
        fi
fi