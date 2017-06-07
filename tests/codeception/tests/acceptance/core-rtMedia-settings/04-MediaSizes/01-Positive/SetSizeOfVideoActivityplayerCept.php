<?php

/**
 * Scenario : To set height and width of video player for activity page.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$scrollToDirectUpload = ConstantsPage::$masonary_checkbox;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To set height and width of video player for activity page' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$media_sizes_tab, ConstantsPage::$media_sizes_tab_url );
$settings->setMediaSize( ConstantsPage::$activity_player_label, ConstantsPage::$activity_video_width_textbox, ConstantsPage::$activity_video_player_width, ConstantsPage::$activity_video_height_textbox, ConstantsPage::$activity_video_player_height );

$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-bp' );
$I->waitForElement( ConstantsPage::$buddypress_tab, 10 );
$settings->verifyEnableStatus( ConstantsPage::$str_media_upload_from_activity_label, ConstantsPage::$media_upload_from_activity_checkbox );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->uploadMediaFromActivity( ConstantsPage::$video_name );

$I->reloadPage();

echo $I->grabAttributeFrom( ConstantsPage::$video_selector_activity, 'style' );
?>
