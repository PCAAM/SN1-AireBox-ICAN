@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)sftp v.2.8.6.0 // 26-09-13 arce@redcitroen.com

REM # "-----  Envio por sFTP a la DMZ del fichero  -----"
REM # Sustituir NOMBRE_CIBLE,NOMBRE_DMS,NOMBRE_SFTP por sus valores correctos

set NOM_ENVIO=NOMBRE_CIBLE
set NOM_CIBLE=NOMBRE_CIBLE
set NOM_DMS=NOMBRE_DMS
set URL_SFTP=NOMBRE_SFTP

for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

for /f "tokens=1,2 delims==" %%j in (%PATH_AIREBOX%\Suite_DCS\config\envio_DCS.ini) do ( 
 if %%j==n_tercero set N_TERCERO=%%k
)

set RUTA="%PATH_AIREBOX%\Suite_DCS"
set NOM_LOG=diario_%NOM_ENVIO%.log
set FICHERO_PID=%RUTA%\Log\sftp_%NOM_ENVIO%.pid
set IN_FILE="%PATH_AIREBOX%\envio_DCS"

if not exist %FICHERO_PID% (
	
	echo "*********************************** Inicio Proceso de renombrado ***********************************" 	>> %RUTA%\Log\%NOM_LOG%

	dir %IN_FILE%\%NOM_DMS%* /b											>> %RUTA%\Log\%NOM_LOG%
	for /f "tokens=1,2 delims=." %%a in ('dir %IN_FILE%\%NOM_DMS%* /b') do (
		if NOT "%%b" == "" (
			ren %IN_FILE%\%%a.%%b %N_TERCERO%%NOM_CIBLE%.%%b   	>> %RUTA%\Log\%NOM_LOG%
		) else (
			ren %IN_FILE%\%%a.%%b %N_TERCERO%%NOM_CIBLE%.0   	>> %RUTA%\Log\%NOM_LOG%
		)
	)

	echo "*********************************** Fin Proceso de renombrado **************************************" 	>> %RUTA%\Log\%NOM_LOG%


	echo "*********************************** Proceso de envio ***********************************************" 	>> %RUTA%\Log\%NOM_LOG%

	cd %RUTA%
	echo "." > %FICHERO_PID%
	cmd /c javaw -Xrs -jar %RUTA%\bin\envio_SFTP.jar %URL_SFTP% %NOM_CIBLE%
	del %FICHERO_PID%	

	echo "*********************************** Fin Proceso de envio *******************************************" 	>> %RUTA%\Log\%NOM_LOG%
	echo ""														>> %RUTA%\Log\%NOM_LOG%
 
	echo "*********************************** Inicio de Archivos de LOG **************************************" 	>> %RUTA%\Log\%NOM_LOG% 
	type %RUTA%\Log\log_envioSFTP_%NOM_ENVIO%.log 									>> %RUTA%\Log\%NOM_LOG%

	echo "*********************************** Fin de Archivos de LOG *****************************************" 	>> %RUTA%\Log\%NOM_LOG%
	echo "####################################################################################################" 	>> %RUTA%\Log\%NOM_LOG%
	echo "" 													>> %RUTA%\Log\%NOM_LOG%
	echo "" 													>> %RUTA%\Log\%NOM_LOG%

	REM # Limpiamos ficheros de log
	del %RUTA%\Log\log_envioSFTP_%NOM_ENVIO%.log									>> %RUTA%\Log\%NOM_LOG%

) else (
	echo "El proceso se esta ejecutando. No se lanzara una nueva instancia hasta que finalice"			>> %RUTA%\Log\%NOM_LOG%
)
