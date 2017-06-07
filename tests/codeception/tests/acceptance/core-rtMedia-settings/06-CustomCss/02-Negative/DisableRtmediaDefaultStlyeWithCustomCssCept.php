<?php

/**
 * Scenario : set custom css when default rtmedia style is disabled.
 */
use Page\Login as LoginPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Set custom css code when default rtMedia style is disabled.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$custom_css_tab, ConstantsPage::$custom_css_tab_url );
$settings->verifyDisableStatus( ConstantsPage::$default_style_label, ConstantsPage::$default_style_checkbox );
$settings->setValue( ConstantsPage::$custom_css_label, ConstantsPage::$css_text_area, ConstantsPage::$custom_css_value );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$I->seeInPageSource( ConstantsPage::$custom_css_value );
?>
