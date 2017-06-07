<?php

/**
 * Scenario : To check if mesonry layout is enabled.
 */
use Page\Login as LoginPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;
use Page\UploadMedia as UploadMediaPage;

$scrollPosition = ConstantsPage::$num_of_media_textbox;
$scrollToDirectUpload = ConstantsPage::$masonary_checkbox;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if mesonry layout is enabled.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$str_masonary_checkbox_label, ConstantsPage::$masonary_checkbox, $scrollPosition );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$temp = $buddypress->countMedia( ConstantsPage::$media_per_page_on_media_selector ); // $temp will receive the available no. of media

if ( $temp == 0 ) {

	$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-display' );
	$I->waitForElement( ConstantsPage::$display_tab, 10 );
	$settings->verifyDisableStatus( ConstantsPage::$str_direct_uplaod_checkbox_label, ConstantsPage::$directUploadCheckbox, $scrollToDirectUpload ); //This will check if the direct upload is disabled

	$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );

	$I->reloadPage();

	$I->seeElementInDOM( ConstantsPage::$masonry_layout );
} else {
	$I->seeElementInDOM( ConstantsPage::$masonry_layout );
}
?>
