BEGIN TRANSACTION;
CREATE TABLE "words" ( "id" INTEGER PRIMARY KEY AUTOINCREMENT  ,"title" TEXT,"is_abbreviation" INTEGER,"created" NUMERIC,"dictionary_id" INTEGER  , FOREIGN KEY("dictionary_id")
						 REFERENCES "dictionaries"("id")
						 ON DELETE SET NULL ON UPDATE SET NULL );
CREATE TABLE "dictionaries" ( id INTEGER PRIMARY KEY AUTOINCREMENT , "name" TEXT);
CREATE TABLE "apikeys" ( id INTEGER PRIMARY KEY AUTOINCREMENT , "apikey" TEXT);
CREATE INDEX index_foreignkey_words_dictionaries ON "words" (dictionary_id) ;
COMMIT;
