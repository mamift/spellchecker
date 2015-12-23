<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWordsTable extends Migration 
{
    private $dateTimeOfMigration;

    /**
     * Create the words table using redbean (a bit slower than SQL...).
     * @return void
     */
    public function createWordsTableUsingRedbean()
    {
        $this->dateTimeOfMigration = date(DEFAULT_DATETIMEFORMAT);

        // echo getcwd();
        $arrayOfWords = file(app_path() . DIRECTORY_SEPARATOR . DB_WORDS_FILE, FILE_IGNORE_NEW_LINES);

        $wordCount = count($arrayOfWords);
        $onePercentDone_increment = (int) ceil($wordCount / 100);
        $progressIndicator = $onePercentDone_increment;
        $percentDone = 0;

        echo "Creating words table...\n";
        echo "Exactly " . $wordCount . " to add\n";

        // replace this line for the production push
        // for ($i = 0; $i < count($arrayOfWords); $i++) { 
        for ($i = 0; $i < $wordCount; $i = $i + rand(20, 100)) { 
            $newWord = R::dispense(TBL_WORDS);

            $newWord["title"] = $arrayOfWords[$i];

            $this->addSecondarySchemaModifcations($newWord);

            R::store($newWord);
            if ($i > $progressIndicator)  {
                echo $progressIndicator . " words added \n";
                $progressIndicator += $onePercentDone_increment;
                $percentDone += 1;
                echo $percentDone . "% done\n";
            }
        }
    }

    /**
     * Use for createWordsTableUsingRedbean() method only
     * 
     * @param [Redbean] $wordBean [the redbean for the word]
     */
    private function addSecondarySchemaModifcations($wordBean) 
    {
        $title = $wordBean["title"];

        $matchAbbreviations = (preg_match_all("/\b[A-Z]+s\b/", $title) || preg_match_all("/\b[A-Z]+'s\b/", $title) || preg_match_all("/\b[A-Z]+\b/", $title));
        if ($matchAbbreviations) {
            echo "Found abbreviation: " . $title . "\n";
            $wordBean->is_abbreviation = true;
        } else {
            $wordBean->is_abbreviation = false;
        }

        $wordBean->dictionary = R::enum(TBL_DICTIONARYENUM . ":default");
        $wordBean->created = $this->dateTimeOfMigration;
    }

    /**
     * Create the words table using SQL (slightly faster!).
     * UNUSED: use the redbean method above
     * 
     * @return void
     */
    public function createWordsTableUsingSQL()
    {
        // echo getcwd();
        $arrayOfWords = file(DB_WORDS_FILE, FILE_IGNORE_NEW_LINES);

        $wordCount = count($arrayOfWords);
        $onePercentDone_increment = (int) ceil($wordCount / 100);
        $progressIndicator = $onePercentDone_increment;
        $percentDone = 0;

        if (!Schema::hasTable(TBL_WORDS)) {
            Schema::create(TBL_WORDS, function (Blueprint $table) {
                $table->string('title')->index();
            });
        }

        echo "Creating words table...\n";
        echo "Exactly " . $wordCount . " to add\n";

        for ($i = 0; $i < count($arrayOfWords); $i++) { 
            $word = $arrayOfWords[$i];
            R::exec("INSERT INTO `:tblName` (title) VALUES (:word)", ['tblName' => TBL_WORDS, 'word' => $word]);
            // R::store($newWord);
            if ($i > $progressIndicator)  {
                echo $progressIndicator . " words added \n";
                $progressIndicator += $onePercentDone_increment;
                $percentDone += 1;
                echo $percentDone . "% done\n\n";
            }
        }
    }

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // $this->createWordsTableUsingSQL();
        $this->createWordsTableUsingRedbean();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        R::wipe(TBL_WORDS);
        Schema::dropIfExists(TBL_WORDS);
        R::wipe(TBL_DICTIONARYENUM);
        Schema::dropIfExists(TBL_DICTIONARYENUM);
    }
}
