@echo off 

rem Author: Ivan Lois
rem Version: @(#)Plantilla_instalar_SingleShot v2.8.28.0 // 11-Sep-2017 arce@redcitroen.com

for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==RRDI_CODE set RRDI_CODE=%%b
)
set RRDI=%RRDI_CODE%
for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( 
 if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b
)
set RUTA="%PATH_AIREBOX%\Suite_DCS"

cd %RUTA%

set DIA=%date:~0,2%
set MES=%date:~3,2%
set ANIO=%date:~6,4%

IF EXIST %RUTA%\Microsoft.Win32.TaskScheduler.dll cmd /c move %RUTA%\Microsoft.Win32.TaskScheduler.dll %RUTA%\Microsoft.Win32.TaskScheduler_%ANIO%%MES%%DIA%.dll
cmd /c move %RUTA%\scripts\Microsoft.Win32.TaskScheduler.dll %RUTA%\Microsoft.Win32.TaskScheduler.dll
IF EXIST %RUTA%\addScheduledTask.exe cmd /c move %RUTA%\addScheduledTask.exe %RUTA%\addScheduledTask_%ANIO%%MES%%DIA%.exe
cmd /c move %RUTA%\scripts\addScheduledTask.exe %RUTA%\addScheduledTask.exe

IF EXIST C:\Windows\system32\SCHTASKS set PATH_SYS=C:\Windows\system32
IF EXIST C:\Windows\system32\SCHTASKS set PATH_SYS=C:\Windows\system32
IF EXIST C:\Windows\SCHTASKS set PATH_SYS=C:\Windows


rem Check .Net Framework
:script
cd /d %windir%\Microsoft.NET\Framework
cls

:set
set dotNet=0

:check
if exist v1.0* 	set dotNet=1
if exist v1.1* 	set dotNet=1
if exist v2.0* 	set dotNet=1
if exist v3.0*	set dotNet=1
if exist v3.5*	set dotNet=1
if exist v4.0*	set dotNet=1
if exist v4.5*	set dotNet=1

cd %PATH_SYS%
cls

for /F "tokens=4-5 delims=[.] " %%A in ('ver') do set version=%%A.%%B
if "%version%" == "10.0" goto ver_W7_W2k8R2
if "%version%" == "6.3" goto ver_W7_W2k8R2
if "%version%" == "6.2" goto ver_W7_W2k8R2
if "%version%" == "6.1" goto ver_W7_W2k8R2
if "%version%" == "6.0" goto ver_Vista_W2k8
if "%version%" == "5.2" goto ver_W2k3_XPx64
if "%version%" == "5.1" goto ver_XP
if "%version%" == "5.0" goto ver_W2k

:ver_W2k
:ver_XP
if %dotNet% == 0 goto ver_XPinstallNotDotNet
echo "Installing XP tasks..."
%RUTA%\addScheduledTask.exe 1 "%RUTA%\scripts\sftp_NOMBRE_SFTP.bat" "" %RUTA%\scripts SingleShot_NOMBRE_SFTP_%RRDI% SingleShot_NOMBRE_SFTP_%RRDI% HORA MINUTO
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\""
goto exit

:ver_W2k3_XPx64
if %dotNet% == 0 goto ver_W2k3_XPx64installNotDotNet
echo "Installing Windows 2003 tasks..."
%RUTA%\addScheduledTask.exe 1 "%RUTA%\scripts\sftp_NOMBRE_SFTP.bat" "" %RUTA%\scripts SingleShot_NOMBRE_SFTP_%RRDI% SingleShot_NOMBRE_SFTP_%RRDI% HORA MINUTO
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\""
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\"" /F
goto exit

:ver_Vista_W2k8
if %dotNet% == 0 goto ver_Vista_W2k8installNotDotNet
echo "Installing Windows Vista/2008 tasks..."
%RUTA%\addScheduledTask.exe 1 "%RUTA%\scripts\sftp_NOMBRE_SFTP.bat" "" %RUTA%\scripts SingleShot_NOMBRE_SFTP_%RRDI% SingleShot_NOMBRE_SFTP_%RRDI% HORA MINUTO
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /RL HIGHEST /V1 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\""
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /RL HIGHEST /V1 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\"" /F
goto exit

:ver_W7_W2k8R2
if %dotNet% == 0 goto ver_W7_W2k8R2installNotDotNet
echo "Installing Windows 7/2008 R2 tasks..."
%RUTA%\addScheduledTask.exe 1 "%RUTA%\scripts\sftp_NOMBRE_SFTP.bat" "" %RUTA%\scripts SingleShot_NOMBRE_SFTP_%RRDI% SingleShot_NOMBRE_SFTP_%RRDI% HORA MINUTO
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /V1 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\""
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /V1 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\"" /F
goto exit

:ver_XPinstallNotDotNet
echo "Installing XP tasks..."
SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\""
goto exit

:ver_W2k3_XPx64installNotDotNet
echo "Installing Windows 2003 tasks..."
SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\""
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\"" /F
goto exit

:ver_Vista_W2k8installNotDotNet
echo "Installing Windows Vista/2008 tasks..."
SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% HORA:MINUTO:00 /RL HIGHEST /V1 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\""
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /RL HIGHEST /V1 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\"" /F
goto exit

:ver_W7_W2k8R2installNotDotNet
echo "Installing Windows 7/2008 R2 tasks..."
SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% HORA:MINUTO:00 /RL HIGHEST /V1 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\""
IF %ERRORLEVEL% NEQ 0 SCHTASKS /Create /RU SYSTEM /SC WEEKLY /D MON,TUE,WED,THU,FRI,SAT /TN SingleShot_NOMBRE_SFTP_%RRDI% /ST HORA:MINUTO:00 /RL HIGHEST /V1 /TR "\"%RUTA%\scripts\sftp_NOMBRE_SFTP.bat\"" /F
goto exit

:exit
