@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)reconfIni v.2.8.14.0 // 30-09-14 arce@redcitroen.com

REM # "-----  Reconfiguracion de archivos .ini  -----"


for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

set RUTA="%PATH_AIREBOX%\Suite_DCS\scripts"

cd %RUTA%
FOR %%F IN (daemon_sincroDCS*.bat) DO SET NFICHERO=%%F
cmd /c %RUTA%\%NFICHERO% stop
FOR %%G IN (daemon_envioDCS*.bat) DO SET NFICHERO=%%G
cmd /c %RUTA%\%NFICHERO% stop

ping 127.0.0.1 -n 15 -w 1000 > nul

move /Y %RUTA%\Global_DCS.properties %PATH_AIREBOX%\Suite_DCS\Global_DCS.properties
move /Y %RUTA%\sincro_DCS.ini %PATH_AIREBOX%\Suite_DCS\config\sincro_DCS.ini
move /Y %RUTA%\envio_DCS.ini %PATH_AIREBOX%\Suite_DCS\config\envio_DCS.ini
move /Y %RUTA%\recep_DCS.ini %PATH_AIREBOX%\Suite_DCS\config\recep_DCS.ini
move /Y %RUTA%\update_DCS.ini %PATH_AIREBOX%\Suite_DCS\config\update_DCS.ini

cd %RUTA%
FOR %%F IN (daemon_sincroDCS*.bat) DO SET NFICHERO=%%F
cmd /c %RUTA%\%NFICHERO% start
FOR %%G IN (daemon_envioDCS*.bat) DO SET NFICHERO=%%G
cmd /c %RUTA%\%NFICHERO% start
