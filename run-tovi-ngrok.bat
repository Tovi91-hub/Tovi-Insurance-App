@echo off
start cmd /k "php -S localhost:8000 -t C:\Users\YourName\ToviLifeInsurrance"
timeout /t 2
start cmd /k "cd C:\ngrok && ngrok http 8000"
