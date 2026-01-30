@echo off
REM Start Laravel development server on LAN
REM Access dari: http://192.168.110.67:8000

echo.
echo ========================================
echo E-Surat Server (LAN Mode)
echo ========================================
echo.
echo Server akan berjalan di:
echo   Local: http://localhost:8000
echo   LAN:   http://192.168.110.67:8000
echo.
echo Akses dari komputer lain di jaringan yang sama dengan:
echo   http://192.168.110.67:8000
echo.
echo Tekan Ctrl+C untuk menghentikan server
echo ========================================
echo.

php artisan serve --host=0.0.0.0 --port=8000
