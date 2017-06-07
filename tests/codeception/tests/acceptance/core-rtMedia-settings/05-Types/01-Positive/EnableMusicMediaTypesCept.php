<?php

/**
 * Scenario :Allow upload for music media types.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\UploadMedia as UploadMediaPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddyPressSettings as BuddyPressSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'Allow upload for music media types' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$types_tab, ConstantsPage::$types_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$music_label, ConstantsPage::$music_checkbox );

$I->amOnPage( '/wp-admin/admin.php?page=rtmedia-settings#rtmedia-bp' );
$I->waitForElement( ConstantsPage::$display_tab, 10 );
$settings->verifyEnableStatus( ConstantsPage::$str_media_upload_from_activity_label, ConstantsPage::$media_upload_from_activity_checkbox ); //It will check if thr upload from activity is enabled from back end.

$buddypress = new BuddyPressSettingsPage( $I );
$buddypress->gotoActivityPage( ConstantsPage::$user_name );

$uploadmedia = new UploadMediaPage( $I );
$uploadmedia->uploadMediaFromActivity( ConstantsPage::$audio_name );

$I->seeElementInDOM( 'li.rtmedia-list-item.media-type-music' );
echo nl2br( "Audio is uploaded.. \n" );
?>
