@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)reconfIni v.2.8.31.0 // 10-08-18 arce@redcitroen.com

REM # "-----  Reconfiguracion de archivos transfer.flx  -----"


for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)

set RUTA="%PATH_AIREBOX%\Suite_DCS"

cd %RUTA%

if not exist "%RUTA%\config\transfer.flx" goto :fin

set BUILDIR=%RUTA%\config
set INTEXTFILE=transfer.flx

set OUTTEXTFILE=temptransfer.txt
set SEARCHTEXT=ftp.dekra-automotivesolutions.com, 2222
set VER=ftp2.dekra-automotivesolutions.com, 22
set OUTPUTLINE= 

for /f "tokens=1,* delims=¶" %%A in ( '"type %BUILDIR%\%INTEXTFILE%"') do (
    SET string=%%A
    setLocal EnableDelayedExpansion
    SET modified=!string:%SEARCHTEXT%=%VER%!
    echo.!modified! >> %BUILDIR%\%OUTTEXTFILE%
    endlocal
 ) 

del %BUILDIR%\%INTEXTFILE%
rename %BUILDIR%\%OUTTEXTFILE% %INTEXTFILE%

:fin
