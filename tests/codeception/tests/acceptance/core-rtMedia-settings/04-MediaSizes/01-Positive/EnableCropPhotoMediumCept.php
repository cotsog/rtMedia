<?php

/**
 * Scenario : To set photo medium height and width when Crop is enabled.
 */
use Page\Login as LoginPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$scrollToDirectUpload = ConstantsPage::$masonary_checkbox;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To set photo medium height and width when Crop is enabled.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$media_sizes_tab, ConstantsPage::$media_sizes_tab_url );
$settings->setMediaSize( ConstantsPage::$photo_medium_label, ConstantsPage::$medium_width_textbox, ConstantsPage::$medium_width, ConstantsPage::$medium_height_textbox, ConstantsPage::$medium_height );
$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-bp' );
$I->waitForElement( ConstantsPage::$buddypress_tab, 10 );
$settings->verifyEnableStatus( ConstantsPage::$str_media_upload_from_activity_label, ConstantsPage::$media_upload_from_activity_checkbox );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->uploadMediaFromActivity( ConstantsPage::$image_name );

echo $I->grabAttributeFrom( ConstantsPage::$thumbnail_selector, 'width' );
echo $I->grabAttributeFrom( ConstantsPage::$thumbnail_selector, 'height' );
?>
