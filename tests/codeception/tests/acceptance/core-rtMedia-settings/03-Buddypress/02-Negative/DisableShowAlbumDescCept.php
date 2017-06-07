<?php

/**
 * Scenario : Disable Show Album description.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Disable Show Album description.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$buddypress_tab, ConstantsPage::$buddypress_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$str_enable_media_in_pro_label, ConstantsPage::$enable_media_in_pro_checkbox );
$settings->verifyEnableStatus( ConstantsPage::$str_enable_album_label, ConstantsPage::$enable_album_checkbox );
$settings->verifyDisableStatus( ConstantsPage::$str_show_album_desc_label, ConstantsPage::$album_desc_checkbox );

$buddypress = new BuddyPressSettingsPage( $I );

$buddypress->gotoAlbumPage();

$I->seeElement( ConstantsPage::$first_album );
$I->click( ConstantsPage::$first_album );
$I->waitForElement( ConstantsPage::$profile_picture, 10 );

$I->dontSeeElement( ConstantsPage::$album_desc_selector );
?>
