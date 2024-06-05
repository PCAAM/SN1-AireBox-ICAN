@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)sftp_NOMBRE_CIBLE v.VERSION // FECHA arce@redcitroen.com

REM # "-----  Recepcion por sFTP de la DMZ del fichero NOMBRE_CIBLE  -----"


set NOM_ENVIO=NOMBRE_CIBLE
set FILE_SOURCE=NOMBRE_SFTP
set FILE_DESTINATION=NOMBRE_DMS
set URL_SFTP=NOMBRE_URL

for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

set RUTA="%PATH_AIREBOX%\Suite_DCS"
set NOM_LOG=diario_%NOM_ENVIO%.log
set FICHERO_PID=%RUTA%\Log\sftp_%NOM_ENVIO%.pid

if not exist %FICHERO_PID% (


	echo "*********************************** Proceso de envio ***********************************************" 	>> %RUTA%\Log\%NOM_LOG%

	cd %RUTA%
	echo "." > %FICHERO_PID%
	cmd /c javaw -Xrs -jar %RUTA%\bin\recep_SFTP.jar %URL_SFTP% %FILE_SOURCE% %FILE_DESTINATION%
	del %FICHERO_PID%	

	echo "*********************************** Fin Proceso de envio *******************************************" 	>> %RUTA%\Log\%NOM_LOG%
	echo ""														>> %RUTA%\Log\%NOM_LOG%
 
	echo "*********************************** Inicio de Archivos de LOG **************************************" 	>> %RUTA%\Log\%NOM_LOG% 
	type %RUTA%\Log\log_recepSFTP_%NOM_ENVIO%.log 									>> %RUTA%\Log\%NOM_LOG%
	if not %NOM_ENVIO%==%FILE_DESTINATION% type %RUTA%\Log\log_recepSFTP_%FILE_DESTINATION%.log			>> %RUTA%\Log\%NOM_LOG%
	type %RUTA%\Log\java_log_recepSFTP_%NOM_ENVIO%.log 								>> %RUTA%\Log\%NOM_LOG%
	if not %NOM_ENVIO%==%FILE_DESTINATION% type %RUTA%\Log\java_log_recepSFTP_%FILE_DESTINATION%.log 		>> %RUTA%\Log\%NOM_LOG%

	echo "*********************************** Fin de Archivos de LOG *****************************************" 	>> %RUTA%\Log\%NOM_LOG%
	echo "####################################################################################################" 	>> %RUTA%\Log\%NOM_LOG%
	echo "" 													>> %RUTA%\Log\%NOM_LOG%
	echo "" 													>> %RUTA%\Log\%NOM_LOG%

	REM # Limpiamos ficheros de log
	del %RUTA%\Log\log_recepSFTP_%NOM_ENVIO%.log 									>> %RUTA%\Log\%NOM_LOG%
	if not %NOM_ENVIO%==%FILE_DESTINATION% del %RUTA%\Log\log_recepSFTP_%FILE_DESTINATION%.log 			>> %RUTA%\Log\%NOM_LOG%
	del %RUTA%\Log\java_log_recepSFTP_%NOM_ENVIO%.log 								>> %RUTA%\Log\%NOM_LOG%
	if not %NOM_ENVIO%==%FILE_DESTINATION% del %RUTA%\Log\java_log_recepSFTP_%FILE_DESTINATION%.log			>> %RUTA%\Log\%NOM_LOG%

) else (
	echo "El proceso se esta ejecutando. No se lanzara una nueva instancia hasta que finalice"			>> %RUTA%\Log\%NOM_LOG%
)
