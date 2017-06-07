<?php

/**
 * Scenario : Allow upload from activity stream.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Check if the user is allowed to upload media from activity stream.' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$buddypress_tab, ConstantsPage::$buddypress_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$str_media_upload_from_activity_label, ConstantsPage::$media_upload_from_activity_checkbox );

$I->scrollTo( ConstantsPage::$top_save_button );

$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-display' );
$I->waitForElement( ConstantsPage::$display_tab, 10 );
$settings->verifyDisableStatus( ConstantsPage::$str_direct_uplaod_checkbox_label, ConstantsPage::$directUploadCheckbox, ConstantsPage::$masonary_checkbox );

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$I->seeElementInDOM( ConstantsPage::$upload_button_on_activity_page );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->uploadMediaFromActivity( ConstantsPage::$image_name );
?>
