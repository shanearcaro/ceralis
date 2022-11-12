CREATE DATABASE IF NOT EXISTS sma237;
USE sma237;

/*DROP TABLE IF EXISTS `Exams`, `QuestionAnswers`, `Questions`, `StudentExams`, `Types`, `Users`;*/

CREATE TABLE IF NOT EXISTS Users (
    user_id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name varchar(50) unique NOT NULL,
    password varchar(50) NOT NULL,
    position varchar(50) NOT NULL
);

INSERT INTO Users(name, password, position) VALUES
('student1', 'studentp1', 'student'),
('teacher1', 'teacherp1', 'teacher'),
('student2', 'studentp2', 'student'),
('teacher2', 'teacherp2', 'teacher');


CREATE TABLE Exams (
    exam_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    creator_id int NOT NULL,
    title varchar(50) NOT NULL,
    points int NOT NULL DEFAULT 100,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(creator_id) REFERENCES Users(user_id)
);

INSERT INTO Exams(creator_id, title, points) VALUES
(2, 'testexam1', 80),
(4, 'testexam2', 60);

CREATE TABLE Types (
    type_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    typename varchar(20) not null
);

INSERT INTO Types(typename) VALUES
('Conditionals'),
('Strings'),
('Recursion'),
('ForLoops');



CREATE TABLE Questions (
    question_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    creator_id int NOT NULL,
    question_type int NOT NULL default 0,
    difficulty varchar(50) NOT NULL DEFAULT 'Medium',
    `constraint` varchar(50) DEFAULT NULL,
    question_text varchar(999) not null,
    tc1 varchar(50) NOT NULL, 
    an1 varchar(50) NOT NULL,
    tc2 varchar(50) NOT NULL, 
    an2 varchar(50) NOT NULL,
    tc3 varchar(50) DEFAULT NULL, 
    an3 varchar(50) DEFAULT NULL,
    tc4 varchar(50) DEFAULT NULL, 
    an4 varchar(50) DEFAULT NULL,
    tc5 varchar(50) DEFAULT NULL, 
    an5 varchar(50) DEFAULT NULL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(creator_id) REFERENCES Users(user_id),
    FOREIGN KEY(question_type) REFERENCES Types(type_id)
);

INSERT INTO Questions(creator_id, question_type, difficulty, question_text, tc1, an1, tc2, an2, tc3, an3, tc4, an4, tc5, an5) VALUES
(2, 2, 'Easy', 'Write a function named sayHello that takes two arguments: string name and string greeting, it should return the greeting and the name as a single string', 'John~Howdy', 'Howdy, John', 'apple~orange', 'orange, apple', NULL, NULL, NULL, NULL, NULL, NULL),
(2, 4, 'Medium', 'Write a function named largest that takes one argument: list of ints lst, it should iterate through the given list and return the largest value found', '[3,7,2,9,8,1]', '9', '[1,2,3,7,5,1]', '7', '[1,300,2,9,8,1]', '300', '[1,800,300,9,8,1]', '800', NULL, NULL),
(4, 2, 'Easy', 'Write a function named sayHello that takes two arguments: string name and string greeting, it should return the greeting and the name as a single string', 'John~Howdy', 'Howdy, John', 'apple~orange', 'orange, apple', NULL, NULL, NULL, NULL, NULL, NULL),
(4, 4, 'Medium', 'Write a function named largest that takes one argument: list of ints lst, it should iterate through the given list and return the largest value found', '[3,7,2,9,8,1]', '9', '[1,2,3,7,5,1]', '7', '[1,300,2,9,8,1]', '300', '[1,800,300,9,8,1]', '800', NULL, NULL);

/*
CREATE TABLE ExtraTestCases (
    case_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    question_id int NOT NULL,
    tcxinput varchar(50) NOT NULL, 
    tcxanswer varchar(50) NOT NULL,
    FOREIGN KEY(question_id) REFERENCES Questions(question_id)
);

INSERT INTO ExtraTestCases(question_id, tcxinput, tcxanswer) VALUES
(2, '[1,300,2,9,8,1]', '300'),
(2, '[1,800,300,9,8,1]', '800');
*/

CREATE TABLE StudentExams (
    submission_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id int NOT NULL,
    exam_id int NOT NULL,
    score int NOT NULL,
    FOREIGN KEY(user_id) REFERENCES Users(user_id),
    FOREIGN KEY (exam_id) REFERENCES Exams(exam_id)
);


CREATE TABLE QuestionAnswers (
    student_id int NOT NULL,
    exam_id int NOT NULL,
    question_id int NOT NULL,
    points int NOT NULL,
    answer varchar(2000),
    comment varchar(500),
    FOREIGN KEY (student_id) REFERENCES Users(User_id),
    FOREIGN KEY(exam_id) REFERENCES Exams(exam_id),
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    PRIMARY KEY(exam_id, question_id)
);
