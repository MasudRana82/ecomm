<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PaymentGatewaySetting;

class PaymentGatewaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gateways = [
            [
                'gateway_name' => 'stripe',
                'is_enabled' => false,
                'sandbox_mode' => true,
            ],
            [
                'gateway_name' => 'sslcommerz',
                'is_enabled' => false,
                'sandbox_mode' => true,
            ],
            [
                'gateway_name' => 'bkash',
                'is_enabled' => false,
                'sandbox_mode' => true,
            ],
        ];

        foreach ($gateways as $gateway) {
            PaymentGatewaySetting::updateOrCreate(
                ['gateway_name' => $gateway['gateway_name']],
                $gateway
            );
        }
    }
}
