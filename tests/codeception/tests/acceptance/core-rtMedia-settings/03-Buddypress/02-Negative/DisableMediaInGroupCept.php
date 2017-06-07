<?php

/**
 * Scenario : To check if media tab is disabled for group.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;
use Page\DashboardSettings as DashboardSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Disabled media for group.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$buddypress_tab, ConstantsPage::$buddypress_tab_url );
$settings->verifyDisableStatus( ConstantsPage::$str_enable_media_in_group_label, ConstantsPage::$enable_media_in_group_checkbox );

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoGroup();

$I->dontSeeElement( ConstantsPage::$media_link_on_group );
?>
