@echo off
echo ========================================
echo Snipe-IT LDAPS Auto-Startup Script
echo ========================================
echo.

cd /d "%~dp0"

echo Checking configuration file...
if not exist "ldaps_config.php" (
    echo ❌ ldaps_config.php not found!
    echo Please edit ldaps_config.php with your server settings first.
    echo.
    pause
    exit /b 1
)

echo ✅ Configuration file found
echo Running LDAPS startup script...
php auto_ldaps_startup.php

echo.
echo ========================================
echo LDAPS startup complete!
echo ========================================
pause