<?php

/**
 * Scenario : To set photo thumbnail height and width when Crop is enabled.
 */
use Page\Login as LoginPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\Constants as ConstantsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$scrollToDirectUpload = ConstantsPage::$masonary_checkbox;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To set photo thumbnail height and width when Crop is enabled.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$media_sizes_tab, ConstantsPage::$media_sizes_tab_url );
$settings->setMediaSize( ConstantsPage::$photo_thumbnail_label, ConstantsPage::$thumbnail_width_textbox, ConstantsPage::$thumbnail_width, ConstantsPage::$thumbnail_height_textbox, ConstantsPage::$thumbnail_height );

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->uploadMediaUsingStartUploadButton( ConstantsPage::$user_name, ConstantsPage::$image_name );

$I->reloadPage();

echo $I->grabAttributeFrom( ConstantsPage::$thumbnail_selector, 'width' );
echo $I->grabAttributeFrom( ConstantsPage::$thumbnail_selector, 'height' );
?>
