# Wildberries-proxy
An application that collects data from Wildberries and stores it for some time.
It gives the possibility of gradual data processing.

## Start
1. ``` docker-compose up -d --build ``` or execute ``` start.bat ``` file.
2. Wait 2-3 minutes for all containers to load and prepare the database.

## Using
1. Execute the console command ``` php artisan app:update-search-data ```
or just open it up in your browser (for test) ``` http://localhost:8000/api/updateData ```.
You can either configure Cron to run this command or run it manually.

2. Perform GET request with your parameter http://localhost:8000/api/search/{your-search}.
   Available:
   - 'футболка оверсайз'
   - 'футболка мужская'
   - 'футболка мужская оверсайз' 
Or just open it in your browser for the test

## End
``` docker-compose down ``` or execute ``` stop.bat ``` file.
