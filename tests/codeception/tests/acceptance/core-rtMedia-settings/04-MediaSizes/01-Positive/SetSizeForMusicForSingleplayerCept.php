<?php

/**
 * Scenario : To set width of single music player.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$scrollToDirectUpload = ConstantsPage::$masonary_checkbox;
$scrollPos = ConstantsPage::$custom_css_tab;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To set width of single music player.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$media_sizes_tab, ConstantsPage::$media_sizes_tab_url );
$settings->setMediaSize( ConstantsPage::$single_player_label, ConstantsPage::$single_music_width_textbox, ConstantsPage::$single_music_player_width, $scrollPos );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$audio_name, ConstantsPage::$music_link );

$I->reloadPage();

$I->scrollTo( ConstantsPage::$media_page_scroll_pos );

$uploadmedia->firstThumbnailMedia();

echo $I->grabAttributeFrom( ConstantsPage::$audio_selector_single, 'style' );
?>
