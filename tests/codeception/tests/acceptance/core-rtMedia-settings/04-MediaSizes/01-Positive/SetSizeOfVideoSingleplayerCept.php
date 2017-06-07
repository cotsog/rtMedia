<?php

/**
 * Scenario : To set height and width of single video player.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$scrollToDirectUpload = ConstantsPage::$masonary_checkbox;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To set height and width of single video player.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$media_sizes_tab, ConstantsPage::$media_sizes_tab_url );
$settings->setMediaSize( ConstantsPage::$single_player_label, ConstantsPage::$single_video_width_textbox, ConstantsPage::$single_video_width, ConstantsPage::$single_video_height_textbox, ConstantsPage::$single_video_height );

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
    $uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$video_name );

$uploadmedia->firstThumbnailMedia();

echo $I->grabAttributeFrom( ConstantsPage::$video_selector_single, 'style' );
?>
