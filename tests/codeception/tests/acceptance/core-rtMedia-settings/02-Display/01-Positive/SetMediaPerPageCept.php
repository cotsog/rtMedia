<?php

/**
 * Scenario : To set the number media per page
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$scrollPos = ConstantsPage::$custom_css_tab;
$scrollToDirectUpload = ConstantsPage::$masonary_checkbox;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To set the number media per page' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );

if ( $I->grabValueFrom( ConstantsPage::$num_of_media_textbox ) != ConstantsPage::$num_of_media_per_page ) {

	$settings->setValue( ConstantsPage::$num_of_media_perpage_label, ConstantsPage::$num_of_media_textbox, ConstantsPage::$num_of_media_per_page, $scrollPos );
}

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );
$temp = $buddypress->countMedia( ConstantsPage::$media_per_page_on_media_selector ); // $temp will receive the available no. of media

$uploadmedia = new UploadMediaPage( $I );

if ( $temp == ConstantsPage::$num_of_media_per_page ) {

	$I->seeNumberOfElements( ConstantsPage::$media_per_page_on_media_selector, ConstantsPage::$num_of_media_per_page );
} else {

	//Disbale direct upload from settings
	$settings->disableDirectUpload();

	$buddypress->gotoMedia( ConstantsPage::$user_name );

	$mediaTobeUploaded = ConstantsPage::$num_of_media_per_page - $temp;

	for ( $i = 0; $i < $mediaTobeUploaded; $i ++ ) {

		$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );
	}

	$I->reloadPage();
	$I->seeNumberOfElements( ConstantsPage::$media_per_page_on_media_selector, ConstantsPage::$num_of_media_per_page );
}
?>
