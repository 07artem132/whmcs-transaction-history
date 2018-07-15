<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 15.07.2018
 * Time: 15:06
 */

use WHMCS\ClientArea;
use WHMCS\Database\Capsule;
use WHMCS\Billing\Invoice;

function TransactionHistory_config() {
	$configarray = [
		"name"        => "История транзакций для клиента",
		"description" => "Данное дополнение позволяет клиенту просматривать историю взаимодействия с его балансом",
		"version"     => "1",
		"author"      => "service-voice",
		"fields"      => [
			'Note' => [
				'Description'  => 'Данный модуль не имеет административного вывода',
				'FriendlyName' => 'Заметка:'
			],
		]
	];

	return $configarray;
}


function TransactionHistory_clientarea( $vars ) {
	$credits = Capsule::table( 'tblcredit' )
	                  ->where( 'clientid', '=', $_SESSION['uid'] )->orderBy( 'id', 'ASC' )->get();
	$balance = 0;
	foreach ( $credits as &$credit ) {
		$descriptionParse  = explode( '#', $credit->description );
		$credit            = (array) $credit;
		$balance           = $balance + $credit['amount'];
		$credit['balance'] = round( $balance, 2 );
		if ( count( $descriptionParse ) == 2 ) {
			$invoiceID = $descriptionParse[1];
			$result    = Invoice::find( $invoiceID );
			if ( ! empty( $result ) ) {
				$credit['invoiceItems'] = '';
				$credit['invoiceId']    = $result->id;
				$items                  = $result->items()->get()->toArray();
				foreach ( $items as $item ) {
					if ( count( $items ) > 1 ) {
						$credit['invoiceItems'] .= $item['description'] . ' | ';
					} else {
						$credit['invoiceItems'] .= $item['description'];
					}
				}
				if ( count( $items ) > 1 ) {
					$credit['invoiceItems'] = substr( $credit['invoiceItems'], 0, - 2 );
				}
			}
		}
	}

	return array(
		'pagetitle'    => 'Ваши транзакции по балансу',
		'breadcrumb'   => array( 'index.php?m=TransactionHistory' => 'Транзакции по балансу' ),
		'templatefile' => 'template/TransactionList',
		'requirelogin' => true,
		'forcessl'     => false,
		'vars'         => array(
			'credits' => array_reverse( $credits ),
		),
	);
}