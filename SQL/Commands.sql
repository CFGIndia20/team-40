CREATE TABLE STUDENT(
  NAME        VARCHAR(11) NOT NULL,
  EMAIL       VARCHAR(15) ,
  PHONE       NUMBER,
  AGE         NUMBER,
  AADHAR      NUMBER,
  MARKSHEET   VARCHAR(50)
  SKILLS_ID   VARCHAR(15),
  INTREST_ID  VARCHAR(15),
  BATCH_GOT   VARCHAR(15)
);

CREATE TABLE SKILLS_ID(
  SKILLS_ID   VARCHAR(15),
  SKILL_NAME  VARCHAR(11),
);

CREATE TABLE INTREST_ID(
  INTREST_ID   VARCHAR(15),
  INTREST_NAME VARCHAR(15),
);
