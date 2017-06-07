<?php

/**
 * Scenario : Allow user to Organize media into albums.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Check if the user is allowed to Organize media into albums.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$buddypress_tab, ConstantsPage::$buddypress_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$str_enable_album_label, ConstantsPage::$enable_album_checkbox );

$gotoMediaPage = new BuddyPressSettingsPage( $I );
$gotoMediaPage->gotoMedia( ConstantsPage::$user_name );

$I->seeElement( ConstantsPage::$media_album_link );
?>
