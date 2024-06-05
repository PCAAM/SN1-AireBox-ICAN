#!/bin/bash

# Author: Ivan Lois
# Version: @(#)purga_ficheros v.VERSION // FECHA arce@redcitroen.com

PATH_AIREBOX=$(head ../Global_DCS.properties|grep "PATH_AIREBOX"|cut -d "=" -f2)

echo "*** Inicio de purga de ficheros" 								> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
date 												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1

#Purga en ""$PATH_AIREBOX""/Suite_DCS/Log // Elimina archivos de acuse de envio
echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
echo "*** Archivos a eliminar en ""$PATH_AIREBOX""/Suite_DCS/Log: "				>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/Suite_DCS/Log/*cEnvio*							>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/Suite_DCS/Log/*cEnvio* -exec rm -rf {} \;				>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/Suite_DCS/Log/sftp_*.pid							>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/Suite_DCS/Log/sftp_*.pid -exec rm -rf {} \;				>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1


#Purga en ""$PATH_AIREBOX""/backup_DCS // Elimina archivos con antiguedad superior a X dias

echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
echo "*** Archivos a eliminar en ""$PATH_AIREBOX""/backup_DCS/LIGFACTQ(+61 dias): "  	>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/backup_DCS/*SCOMPROPTLIGFACTQ* -mtime +61			>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/backup_DCS/*SCOMPROPTLIGFACTQ* -mtime +61 -exec rm -rf {} \;	>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1

echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
echo "*** Archivos a eliminar en ""$PATH_AIREBOX""/backup_DCS/STKVTEH(+61 dias): "  	>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/backup_DCS/*SCOMPROPTSTKVTEH* -mtime +61			>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/backup_DCS/*SCOMPROPTSTKVTEH* -mtime +61 -exec rm -rf {} \;	>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1

echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
echo "*** Archivos a eliminar en ""$PATH_AIREBOX""/backup_DCS/VENTESQ(+61 dias): "  	>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
echo ""												>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/backup_DCS/*SCOMPROPTVENTESQ* -mtime +61			>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
find ""$PATH_AIREBOX""/backup_DCS/*SCOMPROPTVENTESQ* -mtime +61 -exec rm -rf {} \;	>> ""$PATH_AIREBOX""/Suite_DCS/Log/purga_ficheros.log 2>&1
