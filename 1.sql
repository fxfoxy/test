CREATE TABLE "book" (
  "id" SERIAL NOT NULL,
  "title" VARCHAR(300) NOT NULL,
  "isbn" VARCHAR(13) NULL,
  "year" DATE NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "author" (
  "id" SERIAL NOT NULL,
  "surename" VARCHAR(100) NOT NULL,
  "name" VARCHAR(100) NULL,
  "patronymic" VARCHAR(100) NULL,
  PRIMARY KEY ("id")
);

CREATE TABLE "book_author" ( 
	"book_id" INTEGER NOT NULL,
	"author_id" INTEGER NOT NULL,
	PRIMARY KEY ("book_id", "author_id")
);
ALTER TABLE "book_author"
	ADD CONSTRAINT "lnk_author_book_author" FOREIGN KEY ("author_id")
	REFERENCES "author" ("id") MATCH FULL
	ON DELETE Cascade
	ON UPDATE Cascade,
    ADD CONSTRAINT "lnk_book_book_author" FOREIGN KEY ("book_id")
	REFERENCES "book" ("id") MATCH FULL
	ON DELETE Cascade
	ON UPDATE Cascade;

INSERT INTO "book"
    ("id", "title", "isbn", "year")
VALUES
    (1, 'Букварь', 1234567890123, '01.01.2011'),
    (2, 'О вкусной и здоровой пище', 7987654321123, '12.02.2012')
;

INSERT INTO "author"
    ("id", "surename", "name", "patronymic")
VALUES
    (1, 'Марков', 'Николай', 'Григорьевич'),
    (2, 'Светлаков', 'Сергей', 'Семёнович'),
    (3, 'Крузенштерн', 'Роберт', 'Моисеевич')
;

INSERT INTO "book_author"
    ("book_id", "author_id")
VALUES
    (1, 1),
    (2, 1),
	(2, 2),
    (2, 3)
;

/*======================*/

SELECT
  b."title"
, COUNT( * ) authors
FROM book b
JOIN book_author ba
  ON b."id" = ba."book_id"
JOIN author a
  ON ba."author_id" = a."id"
GROUP BY b."title", b."isbn", b."year"
HAVING COUNT( * ) >= 3
