<?php

/**
 * Scenario : To set default privacy with private option.
 */

use Page\Login as LoginPage;
use Page\Logout as LogoutPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$status = 'Private Status';

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To set default privacy with private option' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password, ConstantsPage::$save_session );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$privacy_tab, ConstantsPage::$privacy_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$privacy_label, ConstantsPage::$privacy_checkbox );
$settings->verifyEnableStatus( ConstantsPage::$privacy_user_override_label, ConstantsPage::$privacy_user_override_checkbox );
$settings->verifySelectOption( ConstantsPage::$defaultPrivacyLabel, ConstantsPage::$private_radio_button );

$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-bp' );
$I->waitForElement( ConstantsPage::$buddypress_tab , 10);
$settings->verifyEnableStatus( ConstantsPage::$str_media_upload_from_activity_label, ConstantsPage::$media_upload_from_activity_checkbox );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$I->seeElementInDOM( ConstantsPage::$privacy_dropdown );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->postStatus( $status );

$logout = new LogoutPage( $I );
$logout->logout();

$buddypress->gotoActivityPage( ConstantsPage::$user_name );
$I->dontSeeElementInDOM( ConstantsPage::$activity_selector );

?>
