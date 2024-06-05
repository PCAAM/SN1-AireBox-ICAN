@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)sftp v.2.8.12.0 // 03-07-14 arce@redcitroen.com

REM # "-----  Activacion de AireBox  -----"


for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

set RUTA="%PATH_AIREBOX%\Suite_DCS\scripts"
cd %RUTA%
FOR %%F IN (inactive_*.bat) DO call :RENAME %%F
goto END

:RENAME
set NOMBRE=%1
cmd /c move %RUTA%\%NOMBRE% %RUTA%\%NOMBRE:~9,60%
goto :EOF

:END
set RUTA="%PATH_AIREBOX%\Suite_DCS"
cd %RUTA%
echo|set /p="2.8.12.0"> %RUTA%\version.txt