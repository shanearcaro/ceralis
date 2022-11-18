CREATE DATABASE IF NOT EXISTS sma237;
USE sma237;

CREATE TABLE IF NOT EXISTS Users (
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


INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 1', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 2', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 3', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 4', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 5', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 6', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 7', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 8', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 9', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 10', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 11', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 12', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 13', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 14', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 15', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 16', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 17', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 18', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 19', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 20', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 21', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 22', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 23', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 24', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 25', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 26', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 27', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 28', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 29', '100', '2022-11-16 22:48:36.000000');
INSERT INTO `Exams` (`exam_id`, `user_id`, `title`, `points`, `date`) VALUES (NULL, '2', 'Exam 30', '100', '2022-11-16 22:48:36.000000');

INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '1', '50', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '2', '25', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '3', '33', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '4', '42', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '5', '81', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '6', '19', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '7', '74', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '8', '43', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '9', '24', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '10', '76', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '11', '86', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '12', '34', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '13', '75', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '14', '23', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '15', '54', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '16', '43', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '17', '63', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '18', '24', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '19', '96', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '20', '22', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '21', '15', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '22', '60', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '23', '38', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '24', '64', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '25', '21', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '26', '46', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '27', '97', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '28', '24', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '29', '68', '2022-11-16 22:49:13.000000');
INSERT INTO `StudentExams` (`user_id`, `exam_id`, `score`, `date`) VALUES ('2', '30', '64', '2022-11-16 22:49:13.000000');