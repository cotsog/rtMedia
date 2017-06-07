<?php

namespace Page;

use Page\Constants as ConstantsPage;

class Logout {

	protected $tester;

	public function __construct( \AcceptanceTester $I ) {
		$this->tester = $I;
	}

	public function logout() {

		$I = $this->tester;

		$I->seeElement( ConstantsPage::$meta_section );
		$I->scrollTo( ConstantsPage::$meta_section );

		$I->seeElement( ConstantsPage::$logout_link );
		$I->click( ConstantsPage::$logout_link );
		// $I->wait( 5 );
		$I->waitForElement( ConstantsPage::$logout_msg, 10 );
	}

}
