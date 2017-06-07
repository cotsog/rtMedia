<?php

/**
 * Scenario : To check if Load More - Media display pagination option is enabled
 * Pre condition : The available no of Media should be  > ConstantsPage::$num_of_media_per_page
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;
use Page\UploadMedia as UploadMediaPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if Load More - Media display pagination option is enabled' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );
$settings->verifySelectOption( ConstantsPage::$str_media_display_pagination_label, ConstantsPage::$pagination_radio_button, ConstantsPage::$num_of_media_textbox );
$settings->verifyDisableStatus( ConstantsPage::$str_direct_uplaod_checkbox_label, ConstantsPage::$directUploadCheckbox, ConstantsPage::$masonary_checkbox ); //This will check if the direct upload is disabled

if ( $I->grabValueFrom( ConstantsPage::$num_of_media_textbox ) != ConstantsPage::$num_of_media_per_page ) {

	$settings->setValue( ConstantsPage::$num_of_media_perpage_label, ConstantsPage::$num_of_media_textbox, ConstantsPage::$num_of_media_per_page, ConstantsPage::$custom_css_tab ); // 4th Arg refers the scrolling position
}

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$temp = $buddypress->countMedia( ConstantsPage::$media_per_page_on_media_selector ); // $temp will receive the available no. of media

$uploadmedia = new UploadMediaPage( $I );

if ( $temp <= ConstantsPage::$num_of_media_per_page ) {

	echo "inside if condition";

	$numOfMediaTobeUpload = ConstantsPage::$num_of_media_per_page - $temp + 1;
	echo "\n Media to b uploaded = " . $numOfMediaTobeUpload;

	for ( $i = 0; $i < $numOfMediaTobeUpload; $i ++ ) {

		$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );
	}
}
$I->reloadPage();
$I->seeElementInDOM( ConstantsPage::$pagination_pattern );
?>
