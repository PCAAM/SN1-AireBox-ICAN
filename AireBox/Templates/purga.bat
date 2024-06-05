@echo off

REM # Author: Ivan Lois
REM # Version: @(#)purga_ficheros v.VERSION // FECHA arce@redcitroen.com

for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

echo "Fecha de purga:" 								> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
date /t										>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
echo "Hora inicio......:" 							>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
time /t										>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
echo .										>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
echo .										>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"

REM #Purga en ""%PATH_AIREBOX%""\Suite_DCS\Log // Elimina archivos de acuse de envio

robocopy "%PATH_AIREBOX%\Suite_DCS\Log" c:\backup_borrar\ /MOV /MINAGE:0 /R:10 *cEnvio*			>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
robocopy "%PATH_AIREBOX%\Suite_DCS\Log" c:\backup_borrar\ /MOV /MINAGE:0 /R:10 sftp_*.pid		>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"

REM #Purga en ""%PATH_AIREBOX%""\Suite_DCS\backup_DCS // Elimina archivos con antiguedad superior a X dias

robocopy "%PATH_AIREBOX%\backup_DCS" c:\backup_borrar\ /MOV /MINAGE:31 /R:10 *SCOMAVFETEQCAC.*		>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
robocopy "%PATH_AIREBOX%\backup_DCS" c:\backup_borrar\ /MOV /MINAGE:181 /R:10 *SCOMAVFETAPVAC.*		>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
robocopy "%PATH_AIREBOX%\backup_DCS" c:\backup_borrar\ /MOV /MINAGE:61 /R:10 *SCOMPROPTLIGFACTQ.*	>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
robocopy "%PATH_AIREBOX%\backup_DCS" c:\backup_borrar\ /MOV /MINAGE:61 /R:10 *SCOMPROPTSTKVTEH.*	>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
robocopy "%PATH_AIREBOX%\backup_DCS" c:\backup_borrar\ /MOV /MINAGE:61 /R:10 *SCOMPROPTVENTESQ.*	>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"



rmdir C:\backup_borrar\ /q /s							>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"

echo .										>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
echo .										>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
echo "Hora fin......:" 								>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"
time /t										>> "%PATH_AIREBOX%\Suite_DCS\Log\purga_ficheros.log"