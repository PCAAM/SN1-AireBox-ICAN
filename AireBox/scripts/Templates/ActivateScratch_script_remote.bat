@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)sftp v.2.8.21.0 // 03-07-14 arce@redcitroen.com

REM # "-----  Activacion de SCRATCH  -----"


for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

set RUTA="%PATH_AIREBOX%\Suite_DCS"
cd %RUTA%

if not exist %RUTA%\scratch.ON (
	echo ON > %RUTA%\scratch.ON
)

if exist %RUTA%\scratch.OFF (
	delete %RUTA%\scratch.OFF
)
