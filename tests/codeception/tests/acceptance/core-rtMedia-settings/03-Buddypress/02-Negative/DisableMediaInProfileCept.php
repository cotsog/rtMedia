<?php

/**
 * Scenario : To check if media tab is disabled on profile
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;
use Page\DashboardSettings as DashboardSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if media tab is disabled on profile' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$buddypress_tab, ConstantsPage::$buddypress_tab_url );
$settings->verifyDisableStatus( ConstantsPage::$str_enable_media_in_pro_label, ConstantsPage::$enable_media_in_pro_checkbox );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoProfile( ConstantsPage::$user_name );

$I->dontSeeElement( ConstantsPage::$media_link_on_profile );
?>
