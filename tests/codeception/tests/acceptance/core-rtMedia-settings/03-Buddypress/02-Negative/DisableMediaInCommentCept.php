<?php

/**
 * Scenario : To disable upload media in comment.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( "To disable upload media in comment." );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );

$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url ); // First we need to check if the user is allowed to cooment on upload media.
$settings->verifyEnableStatus( ConstantsPage::$str_comment_checkbox_label, ConstantsPage::$comment_checkbox );
$settings->verifyEnableStatus( ConstantsPage::$str_lightbox_checkbox_label, ConstantsPage::$lightbox_checkbox, ConstantsPage::$custom_css_tab ); //Last arg refers scroll postion

$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-bp' );
$I->waitForElement( ConstantsPage::$buddypress_tab, 10 );

$settings->verifyEnableStatus( ConstantsPage::$str_enable_media_in_pro_label, ConstantsPage::$enable_media_in_pro_checkbox ); //We need to check media is enabled for profile or not.
$settings->verifyDisableStatus( ConstantsPage::$str_media_in_comment_label, ConstantsPage::$media_in_comment_checkbox );

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );
$temp = $buddypress->countMedia( ConstantsPage::$media_per_page_on_media_selector ); // $temp will receive the available no. of media

$uploadmedia = new UploadMediaPage( $I );

if ( $temp >= ConstantsPage::$min_value ) {

	$I->scrollTo( ConstantsPage::$media_page_scroll_pos );

	$uploadmedia->firstThumbnailMedia();

	$I->seeElement( ConstantsPage::$comment_link );
	$I->scrollTo( ConstantsPage::$comment_link );
	$I->seeElement( UploadMediaPage::$commentTextArea );
	$I->dontSeeElement( ConstantsPage::$media_button_in_comment );
} else {

	$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-display' );
	$I->waitForElement( ConstantsPage::$display_tab, 10 );
	$settings->verifyDisableStatus( ConstantsPage::$str_direct_uplaod_checkbox_label, ConstantsPage::$directUploadCheckbox, ConstantsPage::$masonary_checkbox ); //This will check if the direct upload is disabled

	$buddypress->gotoMedia( ConstantsPage::$user_name );
	$I->scrollTo( ConstantsPage::$media_page_scroll_pos );

	$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );

	$I->scrollTo( ConstantsPage::$media_page_scroll_pos );

	$uploadmedia->firstThumbnailMedia();

	$I->seeElement( ConstantsPage::$comment_link );
	$I->scrollTo( ConstantsPage::$comment_link );

	$I->seeElement( UploadMediaPage::$commentTextArea );
	$I->dontSeeElement( ConstantsPage::$media_button_in_comment );
}
?>
