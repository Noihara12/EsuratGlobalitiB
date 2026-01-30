@echo off
REM Start Laravel development server on LAN with proper binding
REM Access dari: http://192.168.110.67:8000

cd /d D:\laragon\www\EsuratGlobalitiB

echo.
echo ========================================
echo E-Surat Server (LAN Mode)
echo ========================================
echo.
echo Server akan berjalan di:
echo   Local:   http://127.0.0.1:8000
echo   Network: http://192.168.110.67:8000
echo.
echo Akses dari komputer lain di jaringan dengan:
echo   http://192.168.110.67:8000
echo.
echo Tekan Ctrl+C untuk menghentikan server
echo ========================================
echo.

php artisan serve --host=0.0.0.0 --port=8000
pause
