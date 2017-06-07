<?php

/**
 * Scenario :Allow upload for photo media types.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Allow upload for photo media types' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$types_tab, ConstantsPage::$types_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$photo_label, ConstantsPage::$photo_checkbox );

$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-bp' );
$I->waitForElement( ConstantsPage::$display_tab, 10 );
$settings->verifyEnableStatus( ConstantsPage::$str_media_upload_from_activity_label, ConstantsPage::$media_upload_from_activity_checkbox ); //It will check if thr upload from activity is enabled from back end.

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->uploadMediaFromActivity( ConstantsPage::$image_name );

$I->seeElementInDOM( 'li.rtmedia-list-item.media-type-photo' );
echo nl2br( "Photo is uploaded.. \n" );
?>
