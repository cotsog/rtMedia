<?php

/**
 * Scenario : To Allow the user to comment on uploaded media.
 */
use Page\Login as LoginPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$comment_str = 'test comment';

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if the user is allowed to comment on uploaded media' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$str_comment_checkbox_label, ConstantsPage::$comment_checkbox );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );
$temp = $buddypress->countMedia( ConstantsPage::$media_per_page_on_media_selector ); // $temp will receive the available no. of media

$uploadmedia = new UploadMediaPage( $I );

if ( $temp >= ConstantsPage::$min_value ) {

	$I->scrollTo( ConstantsPage::$media_page_scroll_pos );

	$uploadmedia->firstThumbnailMedia();

	$I->scrollTo( ConstantsPage::$comment_link );

	$I->seeElement( UploadMediaPage::$commentTextArea );
	$I->fillfield( UploadMediaPage::$commentTextArea, $comment_str );
	$I->click( UploadMediaPage::$commentSubmitButton );
	$I->waitForText( $comment_str, 20 );
} else {
	
	//Disbale direct upload from settings
	$settings->disableDirectUpload();

	$buddypress->gotoMedia( ConstantsPage::$user_name );
	$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );

	$I->reloadPage();

	$I->scrollTo( ConstantsPage::$media_page_scroll_pos );
	$uploadmedia->firstThumbnailMedia();
	$I->scrollTo( ConstantsPage::$comment_link );
	$I->seeElement( UploadMediaPage::$commentTextArea );
	$I->fillfield( UploadMediaPage::$commentTextArea, $comment_str );
	$I->click( UploadMediaPage::$commentSubmitButton );
	$I->waitForText( $comment_str, 20 );
}

$I->reloadPage();
?>
