@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)sftp v.2.8.12.0 // 03-07-14 arce@redcitroen.com

REM # "-----  Desactivacion de AireBox  -----"


for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

SET FICHERO_PID=%PATH_AIREBOX%\Suite_DCS\Log\sincro.pid
if exist %FICHERO_PID% (
	cd %PATH_AIREBOX%\Suite_DCS\Log\
	del /F /Q %FICHERO_PID%
)
SET FICHERO_PID=%PATH_AIREBOX%\Suite_DCS\Log\envio.pid
if exist %FICHERO_PID% (
	cd %PATH_AIREBOX%\Suite_DCS\Log\
	del /F /Q %FICHERO_PID%
)

set RUTA="%PATH_AIREBOX%\Suite_DCS\scripts"
cd %RUTA%
FOR %%F IN (daemon_*.bat) DO call :RENAME %%F
FOR %%G IN (sftp_*.bat) DO call :RENAME %%G
goto END

:RENAME
set NOMBRE=%1
cmd /c move %RUTA%\%NOMBRE% %RUTA%\inactive_%NOMBRE%
goto :EOF

:END
set RUTA="%PATH_AIREBOX%\Suite_DCS"
cd %RUTA%
echo|set /p="9.9.9.9"> %RUTA%\version.txt