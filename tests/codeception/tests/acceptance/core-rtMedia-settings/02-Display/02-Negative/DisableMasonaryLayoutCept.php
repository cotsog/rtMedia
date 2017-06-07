<?php

/**
 * Scenario : To check if mesonry layout is disabled.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if mesonry layout is enabled.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );
$settings->verifyDisableStatus( ConstantsPage::$str_masonary_checkbox_label, ConstantsPage::$masonary_checkbox, ConstantsPage::$num_of_media_textbox );

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$temp = $buddypress->countMedia( ConstantsPage::$media_per_page_on_media_selector ); // $temp will receive the available no. of media

if ( $temp == 0 ) {

	$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-display' );
	$I->waitForElement( ConstantsPage::$display_tab, 10 );
	$settings->verifyDisableStatus( ConstantsPage::$str_direct_uplaod_checkbox_label, ConstantsPage::$directUploadCheckbox, ConstantsPage::$masonary_checkbox ); //This will check if the direct upload is disabled

	$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );

	$I->reloadPage();

	$I->dontSeeElementInDOM( ConstantsPage::$masonry_layout );
} else {
	$I->dontSeeElementInDOM( ConstantsPage::$masonry_layout );
}
?>
