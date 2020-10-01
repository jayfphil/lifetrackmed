How to use:

1) setup your MySQL database and create a database and name it as "lifetrackmed" 

3) then Open your terminal and go to this directory "lifetrack"

4) go to lifetrackmed dir

5) run php artisan migrate

6) then open a different terminal and run this command
curl -X POST -H "Accept: application/json" -H "Content-Type: application/json" "http://localhost:8000/api/register?name=Phil&password=testman&email=admin123@test.com"

7) after executing the curl script, go to "YOUR DOWNLOAD DIR/lifetrack/lifetrackmed"
and run the php artisan serve

8) Open a browser and paste this URL "http://localhost:8000/lifetrack"

