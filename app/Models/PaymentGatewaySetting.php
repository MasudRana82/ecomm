<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentGatewaySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'gateway_name',
        'is_enabled',
        'api_key',
        'api_secret',
        'store_id',
        'store_password',
        'app_key',
        'app_secret',
        'username',
        'password',
        'sandbox_mode',
        'webhook_secret',
        'additional_settings',
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'sandbox_mode' => 'boolean',
        'additional_settings' => 'array',
    ];

    /**
     * Get enabled payment gateways
     */
    public static function getEnabledGateways()
    {
        return self::where('is_enabled', true)->get();
    }

    /**
     * Get gateway by name
     */
    public static function getGateway($gatewayName)
    {
        return self::where('gateway_name', $gatewayName)->first();
    }

    /**
     * Check if gateway is enabled
     */
    public static function isGatewayEnabled($gatewayName)
    {
        $gateway = self::where('gateway_name', $gatewayName)->first();
        return $gateway && $gateway->is_enabled;
    }
}
