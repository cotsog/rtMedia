<?php

/**
 * Scenario : To check Admin bar menu integration is disabled.
 */
use Page\Login as LoginPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\Constants as ConstantsPage;

$scrollToTab = ConstantsPage::$media_sizes_tab;
$scrollPos = ConstantsPage::$display_tab;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if Admin bar menu integration is disabled.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$other_settings_tab, ConstantsPage::$other_settings_tab_url, $scrollToTab );
$settings->verifyDisableStatus( ConstantsPage::$adminbar_menu_label, ConstantsPage::$adminbar_menu_checkbox, $scrollPos );

$I->amOnPage( '/' );
$I->dontSeeElement( ConstantsPage::$rtmedia_adminbar );
?>
