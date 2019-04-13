-- Setup file for Assignments database
USE students;

DROP TABLE IF EXISTS Assignments;
CREATE TABLE Assignments(
  netid        VARCHAR(20) PRIMARY KEY NOT NULL,
  class        VARCHAR(10) NOT NULL,
  name         VARCHAR(20) NOT NULL,
  completion   TINYINT(1) NOT NULL,
  grade        TINYINT(101),
  duedate      TIMESTAMP,
  turnin       TIMESTAMP
);

INSERT INTO Assignments(netid, class, name, completion, grade, duedate, turnin) VALUES
  ('em66', 'CSE154', 'Set!', TRUE, 100, '', '2019-04-02 04:03:07');
