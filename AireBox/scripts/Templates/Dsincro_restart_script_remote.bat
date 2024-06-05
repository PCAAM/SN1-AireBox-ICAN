@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)Reboot Sincro v.2.8.6.0 // 26-09-13 arce@redcitroen.com

REM # "-----  Reboot de servicio Sincro_DCS correspondiente a la instancia  -----"


for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

set RUTA="%PATH_AIREBOX%\Suite_DCS\scripts"

cd %RUTA%
FOR %%F IN (daemon_sincroDCS*.bat) DO SET NFICHERO=%%F
cmd /c %RUTA%\%NFICHERO% restart