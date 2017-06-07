<?php

/**
 * Scenario : To check if media tab for group.
 */
use Page\Login as LoginPage;
use Page\Constants as ConstantsPage;
use Page\BuddypressSettings as BuddypressSettingsPage;
use Page\DashboardSettings as DashboardSettingsPage;

$I = new AcceptanceTester( $scenario );
$I->wantTo( 'To check if media tab is enabled for group' );

$loginPage = new LoginPage( $I );
$loginPage->loginAsAdmin( ConstantsPage::$user_name, ConstantsPage::$password );

$settings = new DashboardSettingsPage( $I );
$settings->gotoTab( ConstantsPage::$buddypress_tab, ConstantsPage::$buddypress_tab_url );
$settings->verifyEnableStatus( ConstantsPage::$str_enable_media_in_group_label, ConstantsPage::$enable_media_in_group_checkbox );

$I->amOnPage( '/wp-admin/options-general.php?page=bp-components/' );
$I->waitForElement( ConstantsPage::$group_table_row, 10 );
$I->seeElement( ConstantsPage::$enable_user_group_checkbox );
$I->checkOption( ConstantsPage::$enable_user_group_checkbox );
$I->seeElement( ConstantsPage::$save_bp_settings );
$I->click( ConstantsPage::$save_bp_settings );
$I->waitForElement( ConstantsPage::$save_msg_selector, 20 );

$buddypress = new BuddypressSettingsPage( $I );
$buddypress->gotoGroup();

$temp = $buddypress->countGroup( ConstantsPage::$group_list_selector );
echo "Total no. of groups = " . $temp;

if ( $temp > 0 ) {

	$buddypress->checkMediaInGroup();
	$I->seeElement( ConstantsPage::$media_link_on_group );
} else {

	$buddypress->createGroup();
	echo "group is created!";
	$buddypress->checkMediaInGroup();
	$I->seeElement( ConstantsPage::$media_link_on_group );
}
?>
