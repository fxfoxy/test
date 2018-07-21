CREATE TABLE test (
  id INT NOT NULL PRIMARY KEY
);

INSERT INTO test (id) VALUES (1), (2), (3), (6), (8), (9), (12);

/*======================*/

SELECT
	t1.id as "FROM"
   ,t2.id as "TO"
FROM (SELECT
	id,
	row_number() over() n
FROM test) t1
JOIN (SELECT
	id,
	row_number() over() n
FROM test) t2
ON (t1.n = t2.n - 1) AND (t2.id - t1.id > 1)