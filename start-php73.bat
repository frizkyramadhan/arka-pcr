@echo off
REM Start arka-pcr on PHP 7.3.10 (CI3) without switching Laragon global PHP.
set PHP73=C:\laragon\bin\php\php-7.3.10-Win32-VC15-x64\php.exe
set HOST=127.0.0.1
set PORT=8076
cd /d C:\laragon\www\arka-pcr
echo.
echo  arka-pcr  http://%HOST%:%PORT%
echo  PHP: %PHP73%
echo  Press Ctrl+C to stop
echo.
"%PHP73%" -S %HOST%:%PORT% router.php
