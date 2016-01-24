<?php

class execCommandTest extends TestCase {

	/** 
	 * Test invoking handle() on a command object using exec_command()
	 */
	public function testExecCommand1()
	{
		$response1 = exec_command(new SpellCheckWord('iamzim'));
		$all1 = $response1->all();

		// results is an instance of Results
		$this->assertTrue($response1 instanceof Results);
		// all() returns an array
		$this->assertTrue(is_array($all1));
		// all()['data'] contains at least two elements
		$this->assertTrue(count($all1['data']) == 2);
		// that the first and second element begins with 'iambi'
		$this->assertTrue($all1['data'][0] == 'iambi');
		$this->assertTrue($all1['data'][1] == 'iambic');

	}

	/**
	 * Test invoking exec_command using class name
	 */
	public function testExecCommand2()
	{
		$response2 = exec_command('SpellCheckWord', 'iamzim');
		$all2 = $response2->all();

		// results is an instance of Results
		$this->assertTrue($response2 instanceof Results);
		// all() returns an array
		$this->assertTrue(is_array($all2));
		// all()['data'] contains at least two elements
		$this->assertTrue(count($all2['data']) == 2);
		// that the first and second element begins with 'iambi'
		$this->assertTrue($all2['data'][0] == 'iambi');
		$this->assertTrue($all2['data'][1] == 'iambic');
	}

	/** 
	 * Test exec_command using third alternate method signature
	 */
	public function testExecCommand3()
	{
		$response = exec_command('IdentifyMispelltWords', 'iamzim', 'extractUniqueWords');
		$all = $response->all();

		var_dump($all);
	
		// results is an array
		$this->assertTrue(is_array($all));
		$this->assertTrue($all['data'][0] == 'iamzim');
	}
}
