@echo off

REM # Author: Ivan Lois (O Grove) - Equipo INDER(PSA Peugeot-Citroen)
REM # Version: @(#)sftp v.2.8.12.0 // 19-06-14 arce@redcitroen.com

REM # "-----  Reinicio de la maquina de AireBox  -----"

cd %windir%\system32
WMIC OS Where Primary=TRUE Call Win32Shutdown 6