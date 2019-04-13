-- Setup file for Assignments database
USE students;

DROP TABLE IF EXISTS Notes;
CREATE TABLE Notes(
  netid        VARCHAR(20) PRIMARY KEY NOT NULL,
  notes        TEXT NOT NULL,
  creation     TIMESTAMP
);

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

DROP TABLE IF EXISTS Students;
CREATE TABLE Students(
  netid        VARCHAR(20) PRIMARY KEY NOT NULL,
  name         VARCHAR(30) NOT NULL
);

INSERT INTO Notes(netid, notes, creation) VALUES
  ('em66', 'Manny fucked up', '2019-04-02 04:03:07');
