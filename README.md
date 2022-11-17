<p align="center"><img src="public/assets/img/logo.png" width="200px"></p>


## Getting Started Step by Step
1. In your root folder, clone the project file using git clone https://github.com/MRMSoft/daytoday.git
2. Open terminal (bash/cmd). Then go to project folder using command

```sh
cd daytoday
```

3. Then install required files and libraries using

```sh
composer install
```

4. Then generate key and make storage link for this project using command

```sh
php artisan key:generate

php artisan storage:link
```

5. Create a database in MYSQL and connect it with your project via updating .env file.
6. After connecting the db with project, then run command(Run These command after every pull request)

```sh
php artisan migrate:fresh

php artisan permission:create-permission-routes

php artisan db:seed
```

After completing the migration and seeding of db, you will have a user ready for login in this project.




Finally we are ready to run our project using this command

```sh
php artisan serve
```

Author: Muhammad Mehroz

Design And Developed For Mrm-Soft
