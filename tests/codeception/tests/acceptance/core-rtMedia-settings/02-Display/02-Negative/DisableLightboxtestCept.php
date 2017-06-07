<?php

/**
 * Scenario : To Check if the media is opening in Light Box.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if the lightbox is disabled' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );
$settings->verifyDisableStatus( ConstantsPage::$str_lightbox_checkbox_label, ConstantsPage::$lightbox_checkbox, ConstantsPage::$custom_css_tab );

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$temp = $buddypress->countMedia( ConstantsPage::$media_per_page_on_media_selector ); // $temp will receive the available no. of media

if ( $temp >= ConstantsPage::$min_value ) {

	$I->scrollTo( '.rtm-gallery-title' );

	$uploadmedia->firstThumbnailMedia();
	$I->dontSeeElement( ConstantsPage::$close_button );   //The close button will only be visible if the media is opened in Lightbox
} else {

	$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-display' );
	$I->waitForElement( ConstantsPage::$display_tab, 10 );
	$settings->verifyDisableStatus( ConstantsPage::$str_direct_uplaod_checkbox_label, ConstantsPage::$directUploadCheckbox, ConstantsPage::$masonary_checkbox ); //This will check if the direct upload is disabled

	$buddypress->gotoMedia( ConstantsPage::$user_name );
	$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );

	$I->reloadPage();
	$I->wait( 7 );

	$uploadmedia->firstThumbnailMedia();
	$I->dontSeeElement( ConstantsPage::$close_button );   //The close button will only be visible if the media is opened in Lightbox
}
?>
