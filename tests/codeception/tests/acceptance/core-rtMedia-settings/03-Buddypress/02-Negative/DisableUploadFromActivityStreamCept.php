<?php

/**
 * Scenario : Disable upload from activity stream.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Disable upload from activity stream.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$buddypress_tab, ConstantsPage::$buddypress_tab_url );
$settings->verifyDisableStatus( ConstantsPage::$str_media_upload_from_activity_label, ConstantsPage::$media_upload_from_activity_checkbox );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$I->dontSeeElementInDOM( ConstantsPage::$upload_button_on_activity_page );
?>
