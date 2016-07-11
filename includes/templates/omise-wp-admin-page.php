<?php defined( 'ABSPATH' ) or die ( "No direct script access allowed." ); ?>

<div class='wrap'>
	<h1><?php echo Omise_Util::translate( 'Omise Dashboard' ); ?></h1>
	
	<?php Omise_Util::render_partial( 'message-box', array( 'message' => $viewData['message'], 'message_type' => $viewData['message_type'] ) ); ?>

	<?php
	if ( isset( $viewData['balance'] ) ) :
		$balance       = $viewData["balance"];
		$charges       = $viewData["charges"];
		$redirect_back = urlencode( remove_query_arg( 'omise_result_msg', $_SERVER['REQUEST_URI'] ) );

		$omise = array(
			'account' => array(
				'email' => $viewData["email"],
			),
			'balance' => array(
				'livemode'  => $balance->livemode,
				'currency'  => $balance->currency,
				'total'     => $balance->total,
				'available' => $balance->available,
			)
		);
		?>

		<!-- Account Info -->
		<div class="Omise-Box Omise-Account">
			<dl>
				<!-- Account email -->
				<dt><?php echo Omise_Util::translate( 'Account' ); ?>: </dt>
				<dd><?php echo $omise['account']['email']; ?></dd>

				<!-- Account status -->
				<dt><?php echo Omise_Util::translate( 'Mode' ); ?>: </dt>
				<dd><strong><?php echo $omise['balance']['livemode'] ? '<span class="Omise-LIVEMODE">' . Omise_Util::translate( 'LIVE' ) . '</span>' : '<span class="Omise-TESTMODE">' . Omise_Util::translate( 'TEST' ) . '</span>'; ?></strong></dd>

				<!-- Current Currency -->
				<dt><?php echo Omise_Util::translate( 'Currency' ); ?>: </dt>
				<dd><?php echo strtoupper( $omise['balance']['currency'] ); ?></dd>

				<!-- Payment Action -->
				<dt><?php echo Omise_Util::translate( 'Auto Capture', 'Account information' ); ?>: </dt>
				<dd><?php echo $viewData['auto_capture'] == 'YES' ? Omise_Util::translate( 'YES', 'Auto capture status is enabled' ) : Omise_Util::translate( 'NO', 'Auto capture status is disabled' ); ?></dd>

				<!-- 3D Secure enabled? -->
				<dt><?php echo Omise_Util::translate( '3-D Secure' ); ?>: </dt>
				<dd><?php echo $viewData['support_3dsecure'] == 'ENABLED' ? Omise_Util::translate( 'ENABLED', '3-D Secure status is enabled' ) : Omise_Util::translate( 'DISABLED', '3-D Secure status is disabled' ); ?></dd>
			</dl>
		</div>

		<!-- Balance -->
		<div class="Omise-Balance Omise-Clearfix">
			<div class="left"><span class="Omise-BalanceAmount"><?php echo OmisePluginHelperCurrency::format( $omise['balance']['currency'], $omise['balance']['total'] ); ?></span><br/><?php echo Omise_Util::translate( 'Total Balance' ); ?></div>
			<div class="right"><span class="Omise-BalanceAmount"><?php echo OmisePluginHelperCurrency::format( $omise['balance']['currency'], $omise['balance']['available'] ); ?></span><br/><?php echo Omise_Util::translate( 'Transferable Balance' ); ?></div>
		</div>

		<div>
			<span id="Omise-BalanceTransferTab" class="Omise-BalanceTransferTab"><?php echo Omise_Util::translate( 'Setup a transfer' ); ?></span>
		</div>

		<h1><?php echo Omise_Util::translate( 'Transactions History' ); ?></h1>

		<!-- Charge list -->
		<div id="Omise-ChargeList">
			<form id="Omise-ChargeFilters" method="GET">
				<input type="hidden" name="page" value="Omise-dashboard" />
				<?php
				$charge_table = new Omise_Charges_Table( $charges );
				$charge_table->prepare_items();
				$charge_table->display();
				?>
			</form>
		</div>
	<?php endif; ?>

	<?php Omise_Util::render_partial( 'transfer-box', $omise ); ?>
</div>