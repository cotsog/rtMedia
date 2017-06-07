<?php

/**
 * Scenario : Disable organize media into albums.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;
use Page\DashboardSettings as DashboardSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Disable organize media into albums.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$buddypress_tab, ConstantsPage::$buddypress_tab_url );
$settings->verifyDisableStatus( ConstantsPage::$str_enable_album_label, ConstantsPage::$enable_album_checkbox );

$settings->verifyEnableStatus( ConstantsPage::$str_enable_media_in_pro_label, ConstantsPage::$enable_media_in_pro_checkbox ); //This must be enabled else it will not identify the element in front end.

$gotoMediaPage = new BuddyPressSettingsPage( $I );
$gotoMediaPage->gotoMedia( ConstantsPage::$user_name );

$I->dontSeeElement( ConstantsPage::$media_album_link );
?>
