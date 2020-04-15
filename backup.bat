REM cd D:\server\isms\laravel

REM REM C:\xampp2\php\php.exe php artisan schedule:run 1>> NUL 2>&1
REM "C:\xampp2\php\php.exe" "artisan" isms:backup > "NUL" 2>&1
REM PAUSE

cd /D D:\server\isms\laravel   

C:\xampp2\php\php.exe artisan schedule:run 1>> NUL 2>&1

REM PAUSE