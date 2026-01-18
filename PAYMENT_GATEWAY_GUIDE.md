# Payment Gateway Integration Guide

## Overview

This e-commerce system now supports multiple payment gateways:

- **Cash on Delivery** (Default - Always Enabled)
- **Stripe** (Credit/Debit Cards)
- **SSLCommerz** (Bangladesh Payment Gateway)
- **Bkash** (Mobile Financial Service)

## Admin Configuration

### Accessing Payment Gateway Settings

1. Login as admin
2. Navigate to: `/admin/payment-gateways`
3. You'll see all available payment gateways

### Configuring Each Gateway

#### 1. Stripe Configuration

**Required Credentials:**

- Publishable Key (pk*test*... or pk*live*...)
- Secret Key (sk*test*... or sk*live*...)
- Webhook Secret (optional, whsec\_...)

**How to Get Credentials:**

1. Sign up at https://stripe.com
2. Go to Developers → API Keys
3. Copy your publishable and secret keys
4. For webhooks: Developers → Webhooks → Add endpoint

**Test Mode:**

- Use test keys (pk*test*..., sk*test*...)
- Test card: 4242 4242 4242 4242
- Any future expiry date and CVC

#### 2. SSLCommerz Configuration

**Required Credentials:**

- Store ID
- Store Password

**How to Get Credentials:**

1. Sign up at https://sslcommerz.com
2. Complete merchant registration
3. Get Store ID and Password from merchant panel
4. Use sandbox credentials for testing

**Sandbox Credentials (for testing):**

- Store ID: Provided by SSLCommerz
- Store Password: Provided by SSLCommerz
- Sandbox URL: https://sandbox.sslcommerz.com

#### 3. Bkash Configuration

**Required Credentials:**

- App Key
- App Secret
- Username
- Password

**How to Get Credentials:**

1. Register as Bkash merchant at https://www.bkash.com/
2. Apply for API integration
3. Get credentials from Bkash merchant portal
4. Use sandbox credentials for testing

**Sandbox Mode:**

- Sandbox URL: https://tokenized.sandbox.bka.sh
- Use test credentials provided by Bkash

## Enabling/Disabling Gateways

### To Enable a Gateway:

1. Go to `/admin/payment-gateways`
2. Click "Edit" on the gateway you want to enable
3. Select "Enabled" radio button
4. Fill in all required API credentials
5. Choose "Sandbox" or "Live" mode
6. Click "Save Configuration"

### To Disable a Gateway:

1. Go to `/admin/payment-gateways`
2. Click "Disable" button next to the gateway
   OR
3. Click "Edit" and select "Disabled" radio button

## Customer Experience

### Checkout Process

1. Customer adds items to cart
2. Proceeds to checkout
3. Fills in shipping information
4. Selects payment method from available options:
    - Cash on Delivery (always visible)
    - Enabled payment gateways (Stripe, SSLCommerz, Bkash)
5. Places order
6. If online payment selected, redirected to payment gateway
7. After successful payment, redirected back to order confirmation

### Payment Flow

#### Cash on Delivery:

- Order created immediately
- Payment status: "Pending"
- Order status: "Pending"
- Payment collected on delivery

#### Stripe:

- Redirected to Stripe Checkout
- Enter card details
- On success: Payment status "Paid", Order status "Processing"
- On failure: Can retry payment

#### SSLCommerz:

- Redirected to SSLCommerz payment page
- Choose payment method (card, mobile banking, etc.)
- On success: Payment status "Paid", Order status "Processing"
- On failure: Can retry payment

#### Bkash:

- Redirected to Bkash payment page
- Login to Bkash account
- Confirm payment
- On success: Payment status "Paid", Order status "Processing"
- On failure: Can retry payment

## Database Structure

### Payment Gateway Settings Table

```sql
payment_gateway_settings
- id
- gateway_name (stripe, sslcommerz, bkash)
- is_enabled (boolean)
- api_key (encrypted)
- api_secret (encrypted)
- store_id (for SSLCommerz)
- store_password (for SSLCommerz)
- app_key (for Bkash)
- app_secret (for Bkash)
- username (for Bkash)
- password (for Bkash)
- sandbox_mode (boolean)
- webhook_secret
- additional_settings (JSON)
- created_at
- updated_at
```

## Security Considerations

1. **API Keys Storage:**
    - All sensitive credentials are stored in the database
    - Consider encrypting sensitive fields in production
    - Never commit API keys to version control

2. **Sandbox vs Live Mode:**
    - Always test in sandbox mode first
    - Switch to live mode only after thorough testing
    - Use different API keys for sandbox and live

3. **Webhook Security:**
    - Verify webhook signatures
    - Use HTTPS for webhook endpoints
    - Implement proper error handling

## Testing

### Testing Stripe:

1. Enable Stripe in sandbox mode
2. Use test API keys
3. Test card: 4242 4242 4242 4242
4. Expiry: Any future date
5. CVC: Any 3 digits

### Testing SSLCommerz:

1. Enable SSLCommerz in sandbox mode
2. Use sandbox credentials
3. Use test cards provided by SSLCommerz
4. Test different payment methods

### Testing Bkash:

1. Enable Bkash in sandbox mode
2. Use sandbox credentials
3. Use test Bkash account provided by Bkash
4. Test payment flow

## Troubleshooting

### Gateway Not Showing on Checkout:

- Check if gateway is enabled in admin panel
- Verify all required credentials are filled
- Check database connection

### Payment Failing:

- Verify API credentials are correct
- Check if using correct mode (sandbox/live)
- Check Laravel logs: `storage/logs/laravel.log`
- Verify payment gateway status (not down for maintenance)

### Webhook Issues:

- Ensure webhook URL is accessible
- Check webhook signature verification
- Verify webhook secret is correct
- Check firewall/security settings

## Support & Documentation

### Stripe:

- Documentation: https://stripe.com/docs
- Support: https://support.stripe.com

### SSLCommerz:

- Documentation: https://developer.sslcommerz.com
- Support: integration@sslcommerz.com

### Bkash:

- Documentation: https://developer.bka.sh
- Support: merchant.service@bka.sh

## Development Notes

### Files Modified:

1. `database/migrations/2026_01_19_000001_create_payment_gateway_settings_table.php`
2. `app/Models/PaymentGatewaySetting.php`
3. `app/Http/Controllers/PaymentGatewayController.php`
4. `app/Http/Controllers/PaymentController.php`
5. `resources/views/admin/payment-gateways/index.blade.php`
6. `resources/views/admin/payment-gateways/edit.blade.php`
7. `resources/views/checkout.blade.php`
8. `routes/web.php`

### Dependencies Added:

- `stripe/stripe-php` - Stripe PHP SDK

### Routes Added:

- `GET /admin/payment-gateways` - List all gateways
- `GET /admin/payment-gateways/{id}/edit` - Edit gateway
- `PUT /admin/payment-gateways/{id}` - Update gateway
- `PATCH /admin/payment-gateways/{id}/toggle` - Toggle gateway status

## Future Enhancements

1. Add more payment gateways (PayPal, Nagad, Rocket)
2. Implement refund functionality
3. Add payment analytics dashboard
4. Implement recurring payments
5. Add multi-currency support
6. Implement payment retry logic
7. Add email notifications for payment status
