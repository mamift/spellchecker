<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpellcheckAttemptsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$sca = R::dispense(TBL_SCATTEMPTS);
		$sca->subjectword = 'doobie';

		$wl = R::dispense('wordlists');

		$sca->wordlist = $wl;

		$sw = R::dispense('suggestedwords');
		$sw->title = 'wwee';
		$sw->list = $wl;

		$sw2 = R::dispense('suggestedwords');
		$sw->title = 'aslkjd';
		$sw->list = $wl;

		R::store($sw2);
		R::store($sw);
		R::store($wl);
		R::store($sca);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
