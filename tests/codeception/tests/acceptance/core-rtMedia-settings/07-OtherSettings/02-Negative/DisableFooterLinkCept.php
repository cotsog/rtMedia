<?php

/**
 * Scenario : To check if rtMedia footer link is disabled.
 */
use Page\Login as LoginPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\Constants as ConstantsPage;

$scrollToTab = ConstantsPage::$media_sizes_tab;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if rtMedia footer link is disabled.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$other_settings_tab, ConstantsPage::$other_settings_tab_url, $scrollToTab );
$settings->verifyDisableStatus( ConstantsPage::$footer_link_label, ConstantsPage::$footer_link_checkbox );

$I->amOnPage( '/' );
$I->dontSeeElement( ConstantsPage::$footer_link );
?>
