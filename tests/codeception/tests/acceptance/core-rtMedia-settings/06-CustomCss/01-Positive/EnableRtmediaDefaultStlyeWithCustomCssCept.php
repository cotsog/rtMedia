<?php

/**
 * Scenario : set custom css when default rtmedia style is enabled.
 */
use Page\Login as LoginPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'set custom css style when default rtmedia style is enabled.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$custom_css_tab, ConstantsPage::$custom_css_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$default_style_label, ConstantsPage::$default_style_checkbox );

$value = $I->grabValueFrom( ConstantsPage::$css_text_area );
echo "Css text area value = \n" . $value;
$settings->setValue( ConstantsPage::$custom_css_label, ConstantsPage::$css_text_area, ConstantsPage::$custom_css_value );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$I->seeInSource( ConstantsPage::$custom_css_value );
?>
