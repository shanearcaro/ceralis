CREATE DATABASE sma237;
USE sma237;

CREATE TABLE Users (
    user_id int AUTO_INCREMENT NOT NULL,
    username varchar(50) NOT NULL,
    name varchar(50) NOT NULL,
    password varchar(50) NOT NULL,
    position varchar(50) NOT NULL,
    PRIMARY KEY(user_id),
    UNIQUE(username)
);

CREATE TABLE Exams (
    exam_id int AUTO_INCREMENT NOT NULL,
    user_id int NOT NULL,
    title varchar(50) NOT NULL,
    points int NOT NULL,
    date datetime NOT NULL,
    PRIMARY KEY(exam_id),
    FOREIGN KEY(user_id) REFERENCES Users(user_id)
);

CREATE TABLE Questions (
    question_id int AUTO_INCREMENT NOT NULL,
    type varchar(50) NOT NULL,
    difficulty varchar(50) NOT NULL,
    case1 varchar(50) NOT NULL,
    case2 varchar(50) NOT NULL,
    PRIMARY KEY(question_id)
);

CREATE TABLE StudentExams (
    user_id int NOT NULL,
    exam_id int NOT NULL,
    score int,
    date datetime NOT NULL,
    FOREIGN KEY(user_id) REFERENCES Users(user_id),
    FOREIGN KEY (exam_id) REFERENCES Exams(exam_id),
    PRIMARY KEY(user_id, exam_id)
);

CREATE TABLE ExamQuestions (
    exam_id int NOT NULL,
    question_id int NOT NULL,
    points int NOT NULL,
    answer varchar(2000),
    comment varchar(500),
    FOREIGN KEY(exam_id) REFERENCES Exams(exam_id),
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    PRIMARY KEY(exam_id, question_id)
);

INSERT INTO Users(name, username, password, position) VALUES('Shane','studentshane', 'studentpassword', 'student');
INSERT INTO Users(name, username, password, position) VALUES('Shane','teachershane', 'teacherpassword', 'teacher');
INSERT INTO Users(name, username, password, position) VALUES('Malcolm','studentmalcolm', 'studentpassword', 'student');
INSERT INTO Users(name, username, password, position) VALUES('Malcolm','teachermalcolm', 'teacherpassword', 'teacher');

INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Statements', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Expressions', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Objects', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'OOP', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Functions', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Methods', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Classes', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Conditionals', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'For Loops', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'While Loops', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'For Each Loops', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Types', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Wrappers', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Inheritance', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Polymorphism', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Abstraction', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Public, Private, Protected modifiers', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Lamdas', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Inline functions', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Inner classes', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Nested classes', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Static keyword', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Static classes', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Static constructors', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Initializers', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Garbage Collection', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Memory Managment', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Java vs Other Languages', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'What to learn next', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Java Beyond', '100', '2022-11-16 22:48:36.000000');

INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '1', '50', '2022-4-1 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '2', '25', '2022-4-7 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '3', '33', '2022-4-19 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '4', '42', '2022-5-3 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '5', '81', '2022-5-6 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '6', '19', '2022-6-7 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '7', '74', '2022-6-23 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '8', '43', '2022-6-29 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '9', '24', '2022-7-23 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '10', '76', '2022-7-25 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '11', '86', '2022-7-27 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '12', '34', '2022-7-29 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '13', '75', '2022-7-30 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '14', '23', '2022-7-30 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '15', '54', '2022-7-31 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '16', '43', '2022-8-3 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '17', '63', '2022-8-13 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '18', '24', '2022-8-17 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '19', '96', '2022-8-20 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '20', '22', '2022-9-1 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '21', '15', '2022-9-6 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '22', '60', '2022-9-14 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '23', '38', '2022-9-18 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '24', '64', '2022-10-5 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '25', '21', '2022-10-26 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '26', '46', '2022-11-2 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '27', '97', '2022-11-3 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '28', '24', '2022-12-2 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '29', '68', '2022-12-24 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('1', '30', '64', '2022-12-25 22:49:13.000000');

INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '1', '50', '2022-4-1 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '2', '25', '2022-4-7 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '3', '33', '2022-4-19 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '4', '42', '2022-5-3 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '5', '81', '2022-5-6 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '6', '19', '2022-6-7 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '7', '74', '2022-6-23 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '8', '43', '2022-6-29 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '9', '24', '2022-7-23 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '10', '76', '2022-7-25 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '11', '86', '2022-7-27 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '12', '34', '2022-7-29 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '13', '75', '2022-7-30 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '14', '23', '2022-7-30 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '15', '54', '2022-7-31 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '16', '43', '2022-8-3 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '17', '63', '2022-8-13 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '18', '24', '2022-8-17 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '19', '96', '2022-8-20 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '20', '22', '2022-9-1 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '21', '15', '2022-9-6 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '22', '60', '2022-9-14 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '23', '38', '2022-9-18 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '24', '64', '2022-10-5 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '25', '21', '2022-10-26 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '26', '46', '2022-11-2 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '27', '97', '2022-11-3 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '28', '24', '2022-12-2 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '29', '68', '2022-12-24 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('3', '30', '64', '2022-12-25 22:49:13.000000');

INSERT INTO `ExamQuestions` (`exam_id`, `question_id`, )