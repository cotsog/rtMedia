<?php

/**
 * Scenario : To set photo large height and width when Crop is enabled.
 */
use Page\Login as LoginPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$scrollToDirectUpload = ConstantsPage::$masonary_checkbox;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To set photo large height and width when Crop is enabled.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$media_sizes_tab, ConstantsPage::$media_sizes_tab_url );
$settings->setMediaSize( ConstantsPage::$photo_large_label, ConstantsPage::$large_width_textbox, ConstantsPage::$large_width, ConstantsPage::$large_height_textbox, ConstantsPage::$large_height );
$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );

$I->reloadPage();
$I->scrollTo( ConstantsPage::$media_page_scroll_pos );

$uploadmedia->firstThumbnailMedia();

echo $I->grabAttributeFrom( ConstantsPage::$thumbnail_selector, 'width' );
echo $I->grabAttributeFrom( ConstantsPage::$thumbnail_selector, 'height' );

$I->reloadPage();
?>
