<h1 align="center">CS490</h1>
<h1 align="center">Guided Design in Software Engineering</h1>

<h3 align="center">Milestones</h3>

<h4 align="center"><s>Alpha Milestone (User Authentication)</s></h4>

<p align="center"><s>The Alpha of the project was to create an authentication tier system. The authtentication starts by accepting iput from the frontend and transfering this to the middle. The middle takes the data and sends it to the backend which query's the database and sends those results back to the middle. The middle sends that data to the front and the frontend can either log the user into the correct portal, Student portal vs Teacher portal, or take the user back to the login screen with an invalid user authentication.</s></p>

<h4 align="center"><s>Beta Milestone (Auto Grader)</s></h4>

<p align="center"><s>The Beta of the project focuses on enhancing the alpha to include an auto grader system. Teachers are able to log into their portal and create questions which can then be used to create exams for students to take. Once a student takes an exam the teacher is able to run an auto grader on the exam which will deduct points for incorrect answers. The teacher is able to update the grade of the auto grader if they think the grade should be handled differently, and can add comments. Students are able to take exams as well as review their grade and comments from their teacher.</s></p>

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