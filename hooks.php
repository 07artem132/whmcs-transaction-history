<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 15.07.2018
 * Time: 15:10
 */
use WHMCS\View\Menu\Item as MenuItem;

add_hook('ClientAreaPrimaryNavbar', 1, function (MenuItem $primaryNavbar)
{
	$navItem = $primaryNavbar->getChild('Billing');
	if (is_null($navItem)) {
		return;
	}

	if (!is_null($primaryNavbar->getChild('Billing'))) {
		$primaryNavbar->getChild('Billing')
		              ->addChild('Transactions on balance', array(
			              'label' => 'Транзакции по балансу',
			              'uri' => '/?m=TransactionHistory',
			              'order' => '100',
		              ));
	}

});
