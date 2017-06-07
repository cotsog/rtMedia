<?php

/**
 * Scenario : Use default rtmedia style when custom code is not provided.
 */
use Page\Login as LoginPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$I = new AcceptanceTester( $scenario );
    $I->wantTo( ' Use default rtMedia style when custom code is not provided.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$custom_css_tab, ConstantsPage::$custom_css_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$default_style_label, ConstantsPage::$default_style_checkbox );

$value = $I->grabValueFrom( ConstantsPage::$css_text_area );
echo "value of textarea is = \n" . $value;
$settings->setValue( ConstantsPage::$custom_css_label, ConstantsPage::$css_text_area, ConstantsPage::$custom_css_empty_value );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$I->dontSeeInSource( ConstantsPage::$custom_css_value );
?>
