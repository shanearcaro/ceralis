CREATE DATABASE IF NOT EXISTS mcs43;
USE mcs43;

CREATE TABLE IF NOT EXISTS Users (
    accountID INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(20) NOT NULL,
    password TEXT(255) NOT NULL,
    PRIMARY KEY(accountID)
);

CREATE TABLE IF NOT EXISTS Students (
    accountID INT NOT NULL,
    studentID INT NOT NULL AUTO_INCREMENT,
    FOREIGN KEY (accountID) REFERENCES Users(accountID),
    PRIMARY KEY(studentID)
);

CREATE TABLE IF NOT EXISTS Teachers (
    accountID INT NOT NULL,
    teacherID INT NOT NULL AUTO_INCREMENT,
    FOREIGN KEY (accountID) REFERENCES Users(accountID),
    PRIMARY KEY(teacherID)
);

CREATE TABLE IF NOT EXISTS Exams (
    examID INT NOT NULL AUTO_INCREMENT,
    examPoints INT NOT NULL,
    numberOfQuestions INT NOT NULL,
    teacherID INT NOT NULL,
    FOREIGN KEY (teacherID) REFERENCES Teachers(teacherID),
    PRIMARY KEY (examID)
);

CREATE TABLE IF NOT EXISTS StudentExams (
    studentExamID INT NOT NULL AUTO_INCREMENT,
    studentID INT NOT NULL,
    examID INT NOT NULL,
    score INT,
    PRIMARY KEY(studentExamID),
    FOREIGN KEY (studentID) REFERENCES Students(studentID),
    FOREIGN KEY (examID) REFERENCES Exams(examID)
);

CREATE TABLE IF NOT EXISTS Questions (
    questionID INT NOT NULL AUTO_INCREMENT,
    teacherID INT NOT NULL,
    question TEXT(255) NOT NULL,
    testcase1 VARCHAR(50) NOT NULL,
    caseAnswer1 VARCHAR(50) NOT NULL,
    testcase2 VARCHAR(50) NOT NULL,
    caseAnswer2 VARCHAR(50) NOT NULL,
    PRIMARY KEY(questionID),
    FOREIGN KEY(teacherID) REFERENCES Teachers(teacherID)
);

CREATE TABLE IF NOT EXISTS CompletedExam (
    studentExamID INT NOT NULL,
    questionID INT NOT NULL,
    answer TEXT(255) NOT NULL,
    result1 TEXT(255),
    result2 TEXT(255),
    score INT NOT NULL,
    comment TEXT(255),
    FOREIGN KEY (studentExamID) REFERENCES StudentExams(studentExamID),
    FOREIGN KEY (questionID) REFERENCES Questions(questionID)
);

CREATE TABLE IF NOT EXISTS ExamQuestions (
    examID INT NOT NULL,
    questionID INT NOT NULL,
    questionPoints INT NOT NULL,
    FOREIGN KEY (examID) REFERENCES Exams(examID),
    FOREIGN KEY (questionID) REFERENCES Questions(questionID)
);

INSERT INTO `Users` (`accountID`, `username`, `password`) VALUES (NULL, 'student', 'student');
INSERT INTO `Users` (`accountID`, `username`, `password`) VALUES (NULL, 'malcolm', 'student');

INSERT INTO `Users` (`accountID`, `username`, `password`) VALUES (NULL, 'teacher', 'teacher');
INSERT INTO `Users` (`accountID`, `username`, `password`) VALUES (NULL, 'shane', 'teacher');

INSERT INTO `Students` (`accountID`, `studentID`) VALUES ('1', NULL);
INSERT INTO `Students` (`accountID`, `studentID`) VALUES ('2', NULL);
INSERT INTO `Teachers` (`accountID`, `teacherID`) VALUES ('3', NULL);
INSERT INTO `Teachers` (`accountID`, `teacherID`) VALUES ('4', NULL);