CREATE DATABASE IF NOT EXISTS sma237;
USE sma237;

CREATE TABLE IF NOT EXISTS Users (
    user_id int AUTO_INCREMENT PRIMARY KEY NOT NULL,
    name varchar(50) unique NOT NULL,
    password varchar(50) NOT NULL,
    isteacher byte NOT NULL default 0,
);

INSERT INTO Users(name, password, isteacher) VALUES
('teststudent', 'studentpassword', 0),
('testteacher', 'teacherpassword', 1),
('teststudent2', 'studentpassword', 0),
('testteacher2', 'teacherpassword', 1);


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
    typename varchar(10) not null
);

INSERT INTO Types(typename) VALUES
('Conditionals'),
('Strings'),
('Recursion'),
('ForLoops');



CREATE TABLE Questions (
    question_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    question_type int NOT NULL default 0,
    difficulty varchar(50) NOT NULL DEFAULT 'Medium',
    question_text varchar(999) not null 
    tc1input varchar(50) NOT NULL, --Multiple input parameters are split by character '~'
    tc1answer varchar(50) NOT NULL,
    FOREIGN KEY(question_type) REFERENCES Types(type_id)
);

INSERT INTO Questions(question_type, difficulty, question_text, tc1input, tc1answer) VALUES
(2, 'Easy', 'Write a function named sayHello that takes two arguments: string name and string greeting, it should return the greeting and the name as a single string', 'John~Howdy', 'Howdy, John' ),
(4, 'Medium', 'Write a function named largest that takes one argument: list of ints lst, it should iterate through the given list and return the largest value found', '[3,7,2,9,8,1]', '9');


CREATE TABLE StudentExams (
    submission_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
    user_id int NOT NULL,
    exam_id int NOT NULL,
    score int NOT NULL,
    FOREIGN KEY(user_id) REFERENCES Users(user_id),
    FOREIGN KEY (exam_id) REFERENCES Exams(exam_id),
);

--no progress past this point
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
