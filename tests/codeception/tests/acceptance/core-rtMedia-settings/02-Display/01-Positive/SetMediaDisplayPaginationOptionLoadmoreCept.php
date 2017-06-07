<?php

/**
 * Scenario : To check if Load More - Media display pagination option is enabled
 * Pre condition : The available no of Media should be  > ConstantsPage::$num_of_media_per_page
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\DashboardSettings as DashboardSettingsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;

$scrollPosition = ConstantsPage::$num_of_media_textbox;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if Load More - Media display pagination option is enabled' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$display_tab, ConstantsPage::$display_tab_url );
$settings->verifySelectOption( ConstantsPage::$str_media_display_pagination_label, ConstantsPage::$load_more_radio_button, $scrollPosition );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoMedia( ConstantsPage::$user_name );

$I->seeElementInDOM( ConstantsPage::$load_more );
?>
