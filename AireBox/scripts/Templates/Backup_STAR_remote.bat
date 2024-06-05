@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)sftp v.2.8.9.0 // 24-03-14 arce@redcitroen.com

REM # "-----  Backup de STAR en remoto  -----"


for /f "tokens=1,2 delims==" %%a in (../Global_DCS.properties) do ( if %%a==PATH_AIREBOX set PATH_AIREBOX=%%b)

set RUTA="%PATH_AIREBOX%\Suite_DCS"
for /f "tokens=4" %%x in ('reg query "HKLM\Software\Grupo PSA\StarDMS\Settings" /v "Ruta Backup"') do set PATH_BACKUP=%%x

cmd /c "%PATH_BACKUP%"\Backup_SQL.bat
