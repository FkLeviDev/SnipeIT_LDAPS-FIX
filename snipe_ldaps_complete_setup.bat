@echo off
echo ========================================
echo Snipe-IT Complete LDAPS Setup
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
echo Running complete LDAPS setup...
php complete_ldaps_setup.php

echo.
echo ========================================
echo LDAPS setup complete!
echo ========================================
echo.
echo If you see any errors above, please check:
echo 1. MySQL is running
echo 2. Apache is running
echo 3. Your LDAP server is reachable
echo.
pause
