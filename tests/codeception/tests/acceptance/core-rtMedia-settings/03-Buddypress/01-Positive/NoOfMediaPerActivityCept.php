<?php

/**
 * Scenario : To set the number media on Activity page while bulk upload.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To set the number media on Activity page while bulk upload.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$buddypress_tab, ConstantsPage::$buddypress_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$str_media_upload_from_activity_label, ConstantsPage::$media_upload_from_activity_checkbox );

$settings->setValue( ConstantsPage::$num_of_media_label_activity, ConstantsPage::$num_of_media_textbox_activity, ConstantsPage::$num_of_media_per_page_on_activity );

$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-display' );
$I->waitForElement( ConstantsPage::$display_tab, 10 );
$settings->verifyDisableStatus( ConstantsPage::$str_direct_uplaod_checkbox_label, ConstantsPage::$directUploadCheckbox, ConstantsPage::$masonary_checkbox );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$I->seeElementInDOM( ConstantsPage::$upload_button_on_activity_page );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->bulkUploadMediaFromActivity( ConstantsPage::$image_name, ConstantsPage::$num_of_media_per_page_on_activity );

if ( ConstantsPage::$num_of_media_per_page_on_activity > 0 ) {
	$I->seeNumberOfElements( ConstantsPage::$media_per_page_activity_selector, ConstantsPage::$num_of_media_per_page_on_activity );
} else {
	$temp = 5;
	$I->seeNumberOfElements( ConstantsPage::$media_per_page_activity_selector, $temp );
}
?>
