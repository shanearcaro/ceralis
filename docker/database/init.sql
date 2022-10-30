CREATE DATABASE IF NOT EXISTS sma237;
USE sma237;

CREATE TABLE IF NOT EXISTS Users (
    user_id int AUTO_INCREMENT NOT NULL,
    name varchar(50) NOT NULL,
    password varchar(50) NOT NULL,
    position varchar(50) NOT NULL,
    PRIMARY KEY(user_id),
    UNIQUE(name)
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
    score int NOT NULL,
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

INSERT INTO Users(name, password, position) VALUES('studentshane', 'studentpassword', 'student');
INSERT INTO Users(name, password, position) VALUES('teachershane', 'teacherpassword', 'teacher');
INSERT INTO Users(name, password, position) VALUES('studentmalcolm', 'studentpassword', 'student');
INSERT INTO Users(name, password, position) VALUES('teachermalcolm', 'teacherpassword', 'teacher');