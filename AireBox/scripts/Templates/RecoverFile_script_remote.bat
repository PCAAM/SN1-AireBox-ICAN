@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)sftp v.2.8.11.0 // 10-06-14 arce@redcitroen.com

REM # "-----  Recuperacion de AireBox del fichero CIBLE  -----"
REM # Sustituir NOM_CIBLE por sus valores correctos

set NOM_CIBLE=NOMBRE_CIBLE

for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

for /f "tokens=1,2 delims==" %%j in (%PATH_AIREBOX%\Suite_DCS\config\envio_DCS.ini) do ( 
 if %%j==n_tercero set N_TERCERO=%%k
)

set FROM_FILE="%PATH_AIREBOX%\backup_DCS\"
set TO_FILE="%PATH_AIREBOX%\envio_DCS\"

copy %FROM_FILE%%N_TERCERO%%NOM_CIBLE%* %TO_FILE%

set RUTA="%PATH_AIREBOX%\Suite_DCS\scripts"

move /Y %RUTA%\SenderAireBox.jar %PATH_AIREBOX%\Suite_DCS\bin\SenderAireBox.jar
cd %PATH_AIREBOX%\Suite_DCS
cmd /c javaw -Xrs -jar %PATH_AIREBOX%\Suite_DCS\bin\SenderAirebox.jar