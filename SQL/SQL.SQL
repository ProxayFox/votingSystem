-- Create the database and it's name will be votingSystem
CREATE DATABASE votingSystem;

CREATE TABLE votedAccounts (
  VID INT(11) NOT NULL,
  votes INT(4) NOT NULL,
  votedStudent VARCHAR(20) NOT NULL
);

CREATE TABLE options (
  VID INT(11) NOT NULL,
  fName VARCHAR(100) NOT NULL,
  lName VARCHAR(100) NOT NULL,
  IMG VARCHAR(100) NOT NULL UNIQUE
);


 INSERT INTO students (SID, fName, lName, IMG) VALUES
   (1, 'Elliot',        'Fitzgerald',   '1.jpg'),
   (2, 'Amelia-Grace',  'Andrade',      '2.jpg'),
   (3, 'Neive',         'Croft',        '3.jpg'),
   (4, 'Madeline',      'Riggs',        '4.jpg'),
   (5, 'Adriana',       'Woodard',      '5.jpg'),
   (6, 'Tegan',         'Wharton',      '6.jpg'),
   (7, 'Anjali',        'Russo',        '7.jpg'),
   (8, 'Krish',         'Mccabe',       '8.jpg'),
   (9, 'Taybah',        'Munoz',        '9.jpg'),
   (10, 'Yosef',        'Gay',          '10.jpg'),
   (11, 'Eloisa',       'Yoder',        '11.jpg'),
   (12, 'Hashim',       'Maynard',      '12.jpg'),
   (13, 'Clarke',       'Cowan',        '13.jpg'),
   (14, 'Ceri',         'Fox',          '14.jpg'),
   (15, 'Saul',         'Mac',          '15.jpg'),
   (16, 'Johnathon',    'Beasley',      '16.jpg'),
   (17, 'Jazmin',       'Barajas',      '17.jpg'),
   (18, 'Horace',       'Gross',        '18.jpg'),
   (19, 'Cadi',         'Santana',      '19.jpg'),
   (20, 'Jenny',        'Lowery',       '20.jpg');