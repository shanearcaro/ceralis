CREATE DATABASE IF NOT EXISTS sma237;
USE sma237;

CREATE TABLE Users (
    user_id INT AUTO_INCREMENT NOT NULL,
    username VARCHAR(50) NOT NULL,
    name VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    position VARCHAR(50) NOT NULL,
    PRIMARY KEY(user_id),
    UNIQUE(username)
);

CREATE TABLE Exams (
    exam_id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    points INT NOT NULL,
    date DATETIME NOT NULL,
    PRIMARY KEY(exam_id),
    FOREIGN KEY(user_id) REFERENCES Users(user_id)
);

CREATE TABLE Questions (
    question_id INT AUTO_INCREMENT NOT NULL,
    text VARCHAR(500) NOT NULL,
    difficulty ENUM ('Easy', 'Medium', 'Hard') NOT NULL,
    `constraint` ENUM ('For', 'While', 'Recursion'),
    category ENUM ('Variable', 'Conditional', 'For', 'While', 'List', 'Recursion') NOT NULL,
    PRIMARY KEY(question_id)
);

-- Score should probably default as null but previous logic works
-- when -1 is used as the default value. Might change in later version
CREATE TABLE StudentExams (
    studentexam_id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    exam_id INT NOT NULL,
    score FLOAT NOT NULL DEFAULT -1,
    date datetime NOT NULL,
    FOREIGN KEY(user_id) REFERENCES Users(user_id),
    FOREIGN KEY(exam_id) REFERENCES Exams(exam_id),
    PRIMARY KEY(studentexam_id)
);

CREATE TABLE ExamQuestions (
    studentexam_id INT NOT NULL,
    question_id INT NOT NULL,
    points FLOAT NOT NULL,
    answer VARCHAR(2000),
    comment VARCHAR(500),
    FOREIGN KEY(studentexam_id) REFERENCES StudentExams(studentexam_id),
    FOREIGN KEY(question_id) REFERENCES Questions(question_id),
    PRIMARY KEY(studentexam_id, question_id)
);

CREATE TABLE Testcases (
    testcase_id INT AUTO_INCREMENT NOT NULL,
    question_id INT NOT NULL,
    `case` VARCHAR(100) NOT NULL,
    answer VARCHAR(100) NOT NULL,
    FOREIGN KEY(question_id) REFERENCES Questions(question_id),
    PRIMARY KEY(testcase_id)
);

CREATE TABLE Autograde (
    studentexam_id INT NOT NULL,
    testcase_id INT NOT NULL,
    autoresult VARCHAR(300) NOT NULL,
    points FLOAT NOT NULL,
    score FLOAT NOT NULL DEFAULT 0,
    FOREIGN KEY(studentexam_id) REFERENCES StudentExams(studentexam_id),
    FOREIGN KEY(testcase_id) REFERENCES Testcases(testcase_id),
    PRIMARY KEY(studentexam_id, testcase_id)
);

INSERT INTO Users(name, username, password, position) VALUES ('Shane','studentshane', 'studentpassword', 'student');
INSERT INTO Users(name, username, password, position) VALUES ('Shane','teachershane', 'teacherpassword', 'teacher');
INSERT INTO Users(name, username, password, position) VALUES ('Malcolm','studentmalcolm', 'studentpassword', 'student');
INSERT INTO Users(name, username, password, position) VALUES ('Malcolm','teachermalcolm', 'teacherpassword', 'teacher');