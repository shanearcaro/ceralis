<h1 align="center">Ceralis LMS</h1>

<p align="center">Ceralis is a learning managment system (LMS) that was inspired by Canvas. Teachers have the ability to create python programming questions with constraints such as for, while, recursion, and can set a specific difficulty to these questions as easy, medium, or hard. These questions required 2-5 test cases for the autograder. The questions can then be grouped together into exams for students to take. Both students and teachers have their own dashboard</p>


<h3 align="center">Project Setup</h3>

<p align="center">
The project is created using docker and docker-compose to create local containers that can be used to test the system. Once the local environment passes all tests, then code will be pushed to production.

First, a `.env` file must be created in the root directory. This env file must include `ROOT_PASSWORD`, `DATABASE`, `NAME`, `PASS` and `HOST`. `HOST` must be set to db or to whatever the database container is called within the `docker-compose.yml` file. `NAME`, `PASS`, and `ROOT_PASSWORD` are up to the user to set. `DATABASE` corresponds to the database name. This can be set to anything but the name must also be changed in the `docker/database/init.sql` file as well.

After all of this is done the project should run with `docker-compose up --build`. This command will build three containers, `php-apache-environment`, `phpmyadmin`, and `db`. 

To log in to the website hosted on the apache container use `localhost:8000`.
To log in to the phpmyadmin environment use `localhost:8080`.

Logging in to the database itself will show binary data that really serves no purpose, but if you'd like to see that you can log in using `localhost:9906`
</p>

<h4 align="center">User Accounts</h4>
<p align="center">
There are four user accounts than can be used to log into the system, two teachers and two students.

| User ID | Username | Password |
| ------- | -------- | -------- |
|    0    | student  | student  |
|    1    | malcolm  | student  |
|    2    | teacher  | teacher  |
|    3    | student  | teacher  |

</p>