<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAPIKeysTable extends Migration 
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	$key = '5bf36bf5-4790-4c11-821b-deb4cf614aaa';
        $apikey = R::dispense(TBL_APIKEYS);

        if (($apiKeyBean = R::findOne(TBL_APIKEYS, ' apikey = ? ', array($key))) === NULL) {
	        $apikey->apikey = $key;
        } 

        // $apikey->apikey = UUID::generate(4)->__toString();
        
        R::store($apikey);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        R::wipe(TBL_APIKEYS);

        Schema::drop(TBL_APIKEYS);
    }
}
