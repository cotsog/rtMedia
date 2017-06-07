<?php

namespace Page;

use Page\Constants as ConstantsPage;

class BuddyPressSettings {

	public static $userProfileLink = 'a#user-xprofile';
	public static $media_link_on_profile = 'a#user-media';
	public static $myGroupLink = '#groups-personal';
	public static $groupNameLink = 'ul#groups-list li:first-child .item .item-title a';
	protected $tester;

	public function __construct( \AcceptanceTester $I ) {
		$this->tester = $I;
	}

	/**
	 * gotoProfilePage() -> Will take the user to his/her profile page
	 */
	public function gotoProfile( $user_name ) {

		$I = $this->tester;

		$url = 'members/' . $user_name . '/profile';
		$I->amOnPage( $url );
		$I->waitForElement( ConstantsPage::$profile_picture, 5 );
	}

	/**
	 * countGroup() -> Will count the no of groups available
	 */
	public function countGroup( $selector ) {

		$I = $this->tester;
		$groupsArray = $I->grabMultiple( $selector );
		return count( $groupsArray );
	}

	/**
	 * checkMediaInGroup() -> Will check if the media is available in group
	 */
	public function checkMediaInGroup() {

		$I = $this->tester;

		$I->seeElement( self::$groupNameLink );
		$I->click( self::$groupNameLink );
		$I->waitForElement( ConstantsPage::$manage_group_link, 10 );
	}

	/**
	 * gotoGroupPage() -> Will take the user to group page
	 */
	public function gotoGroup() {

		$I = $this->tester;
		$I->amonPage( '/groups' );
		$I->waitForElement( ConstantsPage::$create_group_link, 5 );
	}

	/**
	 * createGroup() -> Will create a new group
	 */
	public function createGroup() {

		echo "this is from create grp function.";

		$I = $this->tester;

		$I->seeElementInDOM( ConstantsPage::$create_group_link );
		$I->click( ConstantsPage::$create_group_link );

		$I->waitForElement( ConstantsPage::$create_group_tabs, 5 );
		$I->scrollTo( ConstantsPage::$create_group_tabs );

		$I->seeElementInDOM( ConstantsPage::$group_name_textbox );
		$I->fillField( ConstantsPage::$group_name_textbox, 'Test Group Name from Script' );

		$I->seeElementInDOM( ConstantsPage::$group_desc_textarea );
		$I->fillField( ConstantsPage::$group_desc_textarea, 'Test Group Desc from Script' );  // Enter group Description

		$I->seeElement( ConstantsPage::$create_group_button );
		$I->click( ConstantsPage::$create_group_button );
		// $I->wait( 5 );
		$I->waitForElement( ConstantsPage::$next_group_button, 20 );

		self::gotoGroup();
	}

	/**
	 * gotoActivityPage() -> Will take the user to activity page
	 */
	public function gotoActivityPage( $user_name ) {

		$I = $this->tester;

		$url = 'members/' . $user_name;
		$I->amOnPage( $url );
		$I->waitForElement( ConstantsPage::$media_page_scroll_pos, 10 );
		$I->scrollTo( ConstantsPage::$media_page_scroll_pos );
	}

	/**
	 * gotoMedia() -> Will take the user to media page
	 */
	public function gotoMedia( $user_name ) {

		$I = $this->tester;

		$url = 'members/' . $user_name . '/media';
		$I->amOnPage( $url );

		$I->waitForElement( ConstantsPage::$profile_picture, 5 );
	}

	/**
	 * gotoPhotoPage() -> Will take the user to photo page
	 */
	public function gotoPhotoPage( $user_name ) {

		$I = $this->tester;

		$url = 'members/' . $user_name . '/media/photo';
		$I->amOnPage( $url );
		$I->waitForElement( 'div.rtmedia-container', 10 );
	}

	/**
	 * countMedia() -> Will count media
	 */
	public function countMedia( $selector ) {

		$I = $this->tester;

		$mediaArray = $I->grabMultiple( $selector ); // This will grab the no. of media available on media page
		echo nl2br( 'No of media on page = ' . count( $mediaArray ) );

		return count( $mediaArray );
	}

	/**
	 * gotoAlubmPage() -> Will take the user to album page
	 */
	public function gotoAlbumPage() {

		$I = $this->tester;

		$url = 'members/' . ConstantsPage::$user_name . '/media/album/';
		$I->amOnPage( $url );
		$I->waitForElement( 'div.rtmedia-container', 10 );
	}

	/**
	 * createNewAlbum() -> Will create new album
	 */
	public function createNewAlbum() {

		$albumName = 'My test album';
		$albumCreationMsg = $albumName . ConstantsPage::$album_msg;

		$I = $this->tester;

		self::gotoAlbumPage();

		$I->scrollTo( ConstantsPage::$media_page_scroll_pos );

		$I->seeElement( ConstantsPage::$media_option_button );
		$I->click( ConstantsPage::$media_option_button );
		$I->waitForElementVisible( ConstantsPage::$options_popup, 10 );

		$I->seeElement( ConstantsPage::$add_album_button_link );
		$I->click( ConstantsPage::$add_album_button_link );

		$I->waitForElementVisible( ConstantsPage::$create_album_popup, 10 );
		$I->seeElement( ConstantsPage::$album_name_textbox );
		$I->fillField( ConstantsPage::$album_name_textbox, $albumName );
		$I->seeElement( ConstantsPage::$create_album_button );
		$I->click( ConstantsPage::$create_album_button );
		$I->waitForText( $albumCreationMsg, 20 );

		$I->seeElement( ConstantsPage::$close_album_button );
		$I->click( ConstantsPage::$close_album_button );
		echo "Album created";

		$I->reloadPage();
		$I->waitForElement( ConstantsPage::$profile_picture, 10 );
	}

	/**
	 * editAlbumDesc() -> Will edit the desc for created new album
	 */
	public function editAlbumDesc() {

		$albumDesc = 'My test album desc';
		$I = $this->tester;
		echo "Inside edit album function";

		$I->seeElement( ConstantsPage::$first_album );
		$I->click( ConstantsPage::$first_album );

		$I->wait( 10 );
		$tempUri = $I->grabFromCurrentUrl();
		echo $tempUri;

		$t = $tempUri . 'edit/';
		echo $t;
		$I->amOnPage( $t );
		$I->waitForElement( ConstantsPage::$profile_picture, 10 );

		$I->waitForElementVisible( ConstantsPage::$scroll_selector, 20 );
		$I->scrollTo( ConstantsPage::$scroll_selector );

		$I->seeElement( ConstantsPage::$albumDescTeaxtarea );
		$I->fillField( ConstantsPage::$albumDescTeaxtarea, $albumDesc );
		$I->seeElement( ConstantsPage::$save_album_button );
		$I->click( ConstantsPage::$save_album_button );

		$I->wait( 5 );
		$I->reloadPage();
		$I->scrollTo( ConstantsPage::$scroll_selector );

		$I->amOnPage( $tempUri );
		$I->wait( 5 );
		$I->scrollTo( ConstantsPage::$scroll_selector );

		echo "After scroll";

		$I->seeElementInDOM( ConstantsPage::$album_desc_selector );
	}

}
