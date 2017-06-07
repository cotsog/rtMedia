<?php

/**
 * Scenario : Should not allow the user to comment on uploaded media.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$scrollToDirectUpload = ConstantsPage::$masonary_checkbox;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'User should not allowed to comment on uploaded media' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );
$settings->verifyDisableStatus( ConstantsPage::$str_comment_checkbox_label, ConstantsPage::$comment_checkbox );
$uploadmedia = new UploadMediaPage( $I );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$temp = $buddypress->countMedia( ConstantsPage::$media_per_page_on_media_selector ); // $temp will receive the available no. of media

if ( $temp >= ConstantsPage::$min_value ) {

	$I->scrollTo( ConstantsPage::$media_page_scroll_pos );

	$uploadmedia->firstThumbnailMedia();

	$I->waitForElementNotVisible( UploadMediaPage::$commentTextArea, 10 );
} else {
	$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-display' );
	$I->waitForElement( ConstantsPage::$display_tab, 10 );
	$settings->verifyDisableStatus( ConstantsPage::$str_direct_uplaod_checkbox_label, ConstantsPage::$directUploadCheckbox, $scrollToDirectUpload ); //This will check if the direct upload is disabled

	$buddypress->gotoMedia( ConstantsPage::$user_name );

	$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );

	$I->reloadPage();

	$I->scrollTo( ConstantsPage::$media_page_scroll_pos );

	$uploadmedia->firstThumbnailMedia();

	$I->waitForElementNotVisible( UploadMediaPage::$commentTextArea, 10 );
}

$I->reloadPage();
?>
