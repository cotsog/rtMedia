<?php

/**
 * Scenario : To disable the privacy settings for user.
 */

use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To disable the privacy settings for user.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$privacy_tab, ConstantsPage::$privacy_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$privacy_label, ConstantsPage::$privacy_checkbox );
$settings->verifyDisableStatus( ConstantsPage::$privacy_user_override_label, ConstantsPage::$privacy_user_override_checkbox );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$I->dontSeeElement( ConstantsPage::$privacy_dropdown );

?>
