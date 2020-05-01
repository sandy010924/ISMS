REM cd D:\project\ISMS\laravel

REM REM C:\xampp\php\php.exe php artisan schedule:run 1>> NUL 2>&1
REM "C:\xampp\php\php.exe" "artisan" emails:send > "NUL" 2>&1
REM PAUSE

cd /D D:\project\ISMS\laravel   

C:\xampp\php\php.exe artisan schedule:run 1>> NUL 2>&1

REM PAUSE