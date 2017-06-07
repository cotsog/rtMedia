<?php

/**
 * Scenario : To check direct media upload.
 */
use Page\Login as LoginPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\Constants as ConstantsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if the user is allowed to upload the media directly' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$str_direct_uplaod_checkbox_label, ConstantsPage::$directUploadCheckbox, ConstantsPage::$masonary_checkbox );

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->uploadMediaDirectly( ConstantsPage::$user_name, ConstantsPage::$image_name );
?>
