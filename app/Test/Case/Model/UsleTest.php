<?php
App::uses('Usle', 'Model');

/**
 * Usle Test Case
 *
 */
class UsleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.usle'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Usle = ClassRegistry::init('Usle');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Usle);

		parent::tearDown();
	}

}
