<?php

/**
 * Scenario : To Check if the media is opening in Light Box.
 */
use Page\Login as LoginPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if the lightbox is enabled' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$str_lightbox_checkbox_label, ConstantsPage::$lightbox_checkbox, ConstantsPage::$custom_css_tab ); //Last arg refers scroll postion

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$temp = $buddypress->countMedia( ConstantsPage::$media_per_page_on_media_selector ); // $temp will receive the available no. of media

if ( $temp >= ConstantsPage::$min_value ) {

	$I->scrollTo( '.rtm-gallery-title' );

	$uploadmedia->firstThumbnailMedia();

	$I->seeElement( ConstantsPage::$close_button );   //The close button will only be visible if the media is opened in Lightbox
	$I->click( ConstantsPage::$close_button );
} else {

	//Disbale direct upload from settings
	$settings->disableDirectUpload();

	$buddypress->gotoMedia( ConstantsPage::$user_name );
	$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );

	$I->reloadPage();
	$uploadmedia->firstThumbnailMedia();

	$I->seeElement( ConstantsPage::$close_button );   //The close button will only be visible if the media is opened in Lightbox
	$I->click( ConstantsPage::$close_button );
}
?>
