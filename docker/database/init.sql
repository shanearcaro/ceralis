CREATE DATABASE IF NOT EXISTS sma237;
USE sma237;

DROP TABLE IF EXISTS `Users`, `Exams`, `Types`, `Questions`, `TestCases`, `ExamQuestions`, `StudentExams`, `QuestionAnswers`, `CompletedExam`;

CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT NOT NULL,
    name VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(50) NOT NULL,
    position VARCHAR(50) NOT NULL,
    PRIMARY KEY(user_id)
);


CREATE TABLE Exams (
    exam_id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    title VARCHAR(50) NOT NULL,
    points INT NOT NULL,
    question_count INT NOT NULL,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES Users(user_id),
    PRIMARY KEY(exam_id)
);


CREATE TABLE Types (
    type_id INT AUTO_INCREMENT NOT NULL,
    typename VARCHAR(20) NOT NULL,
    PRIMARY KEY(type_id)
);


CREATE TABLE Questions (
    question_id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    question_type INT NOT NULL default 0,
    difficulty VARCHAR(50) NOT NULL DEFAULT 'Medium',
    `constraint` VARCHAR(50) DEFAULT NULL,
    question_text VARCHAR(999) not null,
    created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(user_id) REFERENCES Users(user_id),
    FOREIGN KEY(question_type) REFERENCES Types(type_id),
    PRIMARY KEY(question_id)
);


CREATE TABLE TestCases (
    testcase_id INT AUTO_INCREMENT NOT NULL,
    question_id INT NOT NULL,
    case_input VARCHAR(50),
    case_answer VARCHAR(50),
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    PRIMARY KEY(testcase_id)
);


CREATE TABLE IF NOT EXISTS ExamQuestions (
    exam_id INT NOT NULL,
    question_id INT NOT NULL,
    questionPoints INT NOT NULL,
    FOREIGN KEY (exam_id) REFERENCES Exams(exam_id),
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    PRIMARY KEY(exam_id, question_id)
);


CREATE TABLE StudentExams (
    studentexam_id INT AUTO_INCREMENT NOT NULL,
    user_id INT NOT NULL,
    exam_id INT NOT NULL,
    score INT NOT NULL,
    FOREIGN KEY(user_id) REFERENCES Users(user_id),
    FOREIGN KEY (exam_id) REFERENCES Exams(exam_id),
    PRIMARY KEY(studentexam_id)
);


CREATE TABLE QuestionAnswers (
    student_id INT NOT NULL,
    exam_id INT NOT NULL,
    question_id INT NOT NULL,
    points INT NOT NULL,
    answer VARCHAR(2000),
    comment VARCHAR(500),
    FOREIGN KEY (student_id) REFERENCES Users(User_id),
    FOREIGN KEY(exam_id) REFERENCES Exams(exam_id),
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    PRIMARY KEY(exam_id, question_id)
);


CREATE TABLE CompletedExam (
    studentexam_id INT NOT NULL,
    question_id INT NOT NULL,
    answer VARCHAR(255) NOT NULL,
    score INT NOT NULL,
    `comment` VARCHAR(255),
    FOREIGN KEY (studentexam_id) REFERENCES StudentExams(studentexam_id),
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    PRIMARY KEY(studentexam_id, question_id)
);


CREATE TABLE CompletedExamResults (
    studentexam_id INT NOT NULL,
    question_id INT NOT NULL,
    testcase_id INT NOT NULL,
    result VARCHAR(255),
    FOREIGN KEY (studentexam_id) REFERENCES StudentExams(studentexam_id),
    FOREIGN KEY (question_id) REFERENCES Questions(question_id),
    FOREIGN KEY (testcase_id) REFERENCES TestCases(testcase_id),
    PRIMARY KEY(studentexam_id, question_id, testcase_id)
);



INSERT INTO Users(name, password, position) VALUES
('student1', 'studentp1', 'student'),
('teacher1', 'teacherp1', 'teacher'),
('student2', 'studentp2', 'student'),
('teacher2', 'teacherp2', 'teacher');
/*
INSERT INTO Exams(user_id, title, points, question_count) VALUES
(2, 'testexam1', 80, 2),
(4, 'testexam2', 60, 2);

INSERT INTO Types(typename) VALUES
('Conditionals'),
('Strings'),
('Recursion'),
('ForLoops');

INSERT INTO Questions(user_id, question_type, difficulty, question_text) VALUES
(2, 2, 'Easy', 'Write a function named sayHello that takes two arguments: string name and string greeting, it should return the greeting and the name as a single string'),
(2, 4, 'Medium', 'Write a function named largest that takes one argument: list of ints lst, it should iterate through the given list and return the largest value found'),
(4, 2, 'Easy', 'Write a function named sayHello that takes two arguments: string name and string greeting, it should return the greeting and the name as a single string'),
(4, 4, 'Medium', 'Write a function named largest that takes one argument: list of ints lst, it should iterate through the given list and return the largest value found');

INSERT INTO TestCases(question_id, case_input, case_answer) VALUES
(1, 'John~Howdy', 'Howdy, John'),
(1, 'apple~orange', 'orange, apple'),
(2, '[3,7,2,9,8,1]', '9'),
(2, '[1,2,3,7,5,1]', '7'),
(2, '[1,300,2,9,8,1]', '300'),
(2, '[1,800,300,9,8,1]', '800'),
(3, 'John~Howdy', 'Howdy, John'),
(3, 'apple~orange', 'orange, apple'),
(4, '[3,7,2,9,8,1]', '9'),
(4, '[1,2,3,7,5,1]', '7'),
(4, '[1,300,2,9,8,1]', '300'),
(4, '[1,800,300,9,8,1]', '800');
*/
