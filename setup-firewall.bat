@echo off
REM Run as Administrator to allow firewall access
REM Script untuk membuka port 8000 di Windows Firewall

echo.
echo ========================================
echo Setup Firewall untuk E-Surat LAN
echo ========================================
echo.

REM Check if running as admin
net session >nul 2>&1
if %errorLevel% neq 0 (
    echo ERROR: Script harus dijalankan sebagai Administrator!
    echo.
    echo Cara:
    echo 1. Buka Command Prompt sebagai Admin
    echo 2. Jalankan: setup-firewall.bat
    echo.
    pause
    exit /b 1
)

echo Adding firewall rule for port 8000...

REM Delete rule jika sudah ada
netsh advfirewall firewall delete rule name="E-Surat Port 8000" >nul 2>&1

REM Add new rule
netsh advfirewall firewall add rule name="E-Surat Port 8000" ^
    dir=in action=allow protocol=tcp localport=8000 ^
    description="Allow E-Surat Development Server on port 8000"

echo.
echo ✓ Firewall rule sudah ditambahkan!
echo.
echo Sekarang jalankan:
echo   start-lan-server.bat
echo.
echo Atau dari command line:
echo   php artisan serve --host=0.0.0.0 --port=8000
echo.
echo Akses dari komputer lain:
echo   http://192.168.110.67:8000
echo.
pause
