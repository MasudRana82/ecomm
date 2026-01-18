# Quick Reference - Payment Gateway System

## 🔗 Important URLs

### Admin Panel:

- **Payment Gateway Settings**: `/admin/payment-gateways`
- **Admin Dashboard**: `/admin/dashboard`
- **Orders Management**: `/admin/orders`

### Customer:

- **Checkout Page**: `/checkout`
- **Order History**: `/orders`

## 🔑 Getting API Credentials

### Stripe (Credit/Debit Cards)

1. Sign up: https://dashboard.stripe.com/register
2. Get API keys: Dashboard → Developers → API keys
3. Test keys start with: `pk_test_` and `sk_test_`
4. Live keys start with: `pk_live_` and `sk_live_`

**Test Card**: 4242 4242 4242 4242 (any future date, any CVC)

### SSLCommerz (Bangladesh)

1. Sign up: https://sslcommerz.com/registration/
2. Complete merchant verification
3. Get credentials from merchant panel
4. Sandbox URL: https://sandbox.sslcommerz.com
5. Live URL: https://securepay.sslcommerz.com

### Bkash (Mobile Wallet)

1. Apply: https://www.bkash.com/corporate
2. Contact Bkash merchant support
3. Get API credentials from merchant portal
4. Sandbox URL: https://tokenized.sandbox.bka.sh
5. Live URL: https://tokenized.pay.bka.sh

## ⚙️ Configuration Steps

### 1. Enable a Payment Gateway:

```
1. Login as admin
2. Go to /admin/payment-gateways
3. Click "Edit" on desired gateway
4. Select "Enabled"
5. Choose "Sandbox" (for testing) or "Live" (for production)
6. Fill in API credentials
7. Click "Save Configuration"
```

### 2. Test the Gateway:

```
1. Add product to cart
2. Go to checkout
3. Fill shipping info
4. Select the payment method
5. Complete test payment
6. Verify order status in admin panel
```

## 📊 Payment Gateway Status

### Default Settings (After Installation):

- ✅ **Cash on Delivery**: Always Enabled
- ❌ **Stripe**: Disabled (needs configuration)
- ❌ **SSLCommerz**: Disabled (needs configuration)
- ❌ **Bkash**: Disabled (needs configuration)

## 🎨 Payment Method Icons

- 💵 Cash on Delivery: Green money icon
- 💳 Stripe: Indigo Stripe logo
- 🛡️ SSLCommerz: Green shield icon
- 📱 Bkash: Pink mobile icon

## 🔧 Troubleshooting

### Gateway not showing on checkout?

- Check if gateway is enabled in admin panel
- Verify API credentials are filled
- Check database connection

### Payment failing?

- Verify API credentials are correct
- Check if using correct mode (sandbox/live)
- Check Laravel logs: `storage/logs/laravel.log`

### Admin panel not accessible?

- Ensure you're logged in as admin
- Check User model has `isAdmin()` method
- Verify middleware is applied

## 📝 Database Tables

### payment_gateway_settings

Stores configuration for each gateway:

- gateway_name (stripe, sslcommerz, bkash)
- is_enabled (true/false)
- sandbox_mode (true/false)
- API credentials (encrypted recommended)

### orders

Tracks order information:

- payment_method (cash_on_delivery, stripe, sslcommerz, bkash)
- payment_status (pending, paid, failed, refunded)
- status (pending, processing, shipped, delivered, cancelled)

## 🚀 Quick Commands

### Run migrations:

```bash
php artisan migrate
```

### Seed payment gateways:

```bash
php artisan db:seed --class=PaymentGatewaySeeder
```

### Clear cache:

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

### Check routes:

```bash
php artisan route:list | grep payment
```

## 📧 Support Contacts

### Payment Providers:

- **Stripe**: https://support.stripe.com
- **SSLCommerz**: integration@sslcommerz.com
- **Bkash**: merchant.service@bka.sh

### Development:

- **Laravel Docs**: https://laravel.com/docs
- **Stripe PHP**: https://stripe.com/docs/api/php

## ⚠️ Important Notes

1. **Always test in sandbox mode first**
2. **Never commit API keys to version control**
3. **Use HTTPS in production**
4. **Verify webhook signatures**
5. **Keep API credentials secure**
6. **Monitor payment logs regularly**

## 📈 Success Metrics

Track these metrics in your admin dashboard:

- Total orders by payment method
- Payment success/failure rates
- Average transaction value
- Most used payment method
- Gateway-specific conversion rates

---

**Need Help?** Check `PAYMENT_GATEWAY_GUIDE.md` for detailed documentation.
