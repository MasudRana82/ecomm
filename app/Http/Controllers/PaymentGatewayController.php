<?php

namespace App\Http\Controllers;

use App\Models\PaymentGatewaySetting;
use Illuminate\Http\Request;

class PaymentGatewayController extends Controller
{
    /**
     * Display payment gateway settings
     */
    public function index()
    {
        $gateways = PaymentGatewaySetting::all();

        // Initialize default gateways if they don't exist
        $defaultGateways = ['stripe', 'sslcommerz', 'bkash'];

        foreach ($defaultGateways as $gatewayName) {
            if (!$gateways->where('gateway_name', $gatewayName)->first()) {
                PaymentGatewaySetting::create([
                    'gateway_name' => $gatewayName,
                    'is_enabled' => false,
                    'sandbox_mode' => true,
                ]);
            }
        }

        $gateways = PaymentGatewaySetting::all();

        return view('admin.payment-gateways.index', compact('gateways'));
    }

    /**
     * Show the form for editing a payment gateway
     */
    public function edit($id)
    {
        $gateway = PaymentGatewaySetting::findOrFail($id);
        return view('admin.payment-gateways.edit', compact('gateway'));
    }

    /**
     * Update the specified payment gateway
     */
    public function update(Request $request, $id)
    {
        $gateway = PaymentGatewaySetting::findOrFail($id);

        $validationRules = [
            'is_enabled' => 'required|boolean',
            'sandbox_mode' => 'required|boolean',
        ];

        // Add specific validation based on gateway type
        if ($gateway->gateway_name === 'stripe') {
            $validationRules['api_key'] = 'required_if:is_enabled,1|nullable|string';
            $validationRules['api_secret'] = 'required_if:is_enabled,1|nullable|string';
        } elseif ($gateway->gateway_name === 'sslcommerz') {
            $validationRules['store_id'] = 'required_if:is_enabled,1|nullable|string';
            $validationRules['store_password'] = 'required_if:is_enabled,1|nullable|string';
        } elseif ($gateway->gateway_name === 'bkash') {
            $validationRules['app_key'] = 'required_if:is_enabled,1|nullable|string';
            $validationRules['app_secret'] = 'required_if:is_enabled,1|nullable|string';
            $validationRules['username'] = 'required_if:is_enabled,1|nullable|string';
            $validationRules['password'] = 'required_if:is_enabled,1|nullable|string';
        }

        $validated = $request->validate($validationRules);

        $updateData = [
            'is_enabled' => $request->is_enabled,
            'sandbox_mode' => $request->sandbox_mode,
        ];

        // Update gateway-specific fields
        if ($gateway->gateway_name === 'stripe') {
            $updateData['api_key'] = $request->api_key;
            $updateData['api_secret'] = $request->api_secret;
            $updateData['webhook_secret'] = $request->webhook_secret;
        } elseif ($gateway->gateway_name === 'sslcommerz') {
            $updateData['store_id'] = $request->store_id;
            $updateData['store_password'] = $request->store_password;
        } elseif ($gateway->gateway_name === 'bkash') {
            $updateData['app_key'] = $request->app_key;
            $updateData['app_secret'] = $request->app_secret;
            $updateData['username'] = $request->username;
            $updateData['password'] = $request->password;
        }

        $gateway->update($updateData);

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', ucfirst($gateway->gateway_name) . ' payment gateway updated successfully!');
    }

    /**
     * Toggle gateway status
     */
    public function toggle($id)
    {
        $gateway = PaymentGatewaySetting::findOrFail($id);
        $gateway->update(['is_enabled' => !$gateway->is_enabled]);

        $status = $gateway->is_enabled ? 'enabled' : 'disabled';

        return redirect()->route('admin.payment-gateways.index')
            ->with('success', ucfirst($gateway->gateway_name) . ' payment gateway ' . $status . ' successfully!');
    }
}
