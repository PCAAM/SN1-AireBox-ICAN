#!/bin/bash

# Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
# Version: @(#)sftp v.2.8.12.0 // 03-07-14 arce@redcitroen.com

# "-----  Desactivacion de AireBox  -----"

PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)

PID=sincro.pid
if [ -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID ];then
        if [ -w ""$PATH_AIREBOX""/Suite_DCS/Log/$PID ];then
			rm -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID
        fi
fi
PID=envio.pid
if [ -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID ];then
        if [ -w ""$PATH_AIREBOX""/Suite_DCS/Log/$PID ];then
			rm -f ""$PATH_AIREBOX""/Suite_DCS/Log/$PID
        fi
fi

cd ""$PATH_AIREBOX""/Suite_DCS/scripts
for i in daemon_*.sh; do
	mv ""$PATH_AIREBOX""/Suite_DCS/scripts/$i ""$PATH_AIREBOX""/Suite_DCS/scripts/inactive_$i
done
for i in sftp_*.sh; do
	mv ""$PATH_AIREBOX""/Suite_DCS/scripts/$i ""$PATH_AIREBOX""/Suite_DCS/scripts/inactive_$i
done

echo -ne "9.9.9.9" > $PATH_AIREBOX""/Suite_DCS/version.txt