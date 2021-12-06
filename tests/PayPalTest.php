<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use TechhDan\PayPal\PayPal;

final class PayPalTest extends TestCase
{
	public function testPayPalCreation(): PayPal
	{
		$paypal = new PayPal(getenv('CLIENT_ID'), getenv('CLIENT_SECRET'), true);
		$this->assertSame(PayPal::class, 'TechhDan\\PayPal\\PayPal');
		return $paypal;
	}

	/**
	 * @depends testPayPalCreation
	 */
	public function testGetAcessToken(PayPal $paypal): void
	{
		$this->assertIsString($paypal->getAccessToken());
		$this->assertNotEmpty($paypal->getAccessToken());
	}
}


