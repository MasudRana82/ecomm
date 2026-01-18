# Payment Gateway Testing Checklist

## Pre-Testing Setup

### ✅ Initial Setup

- [ ] Database migrations completed
- [ ] Payment gateway seeder run
- [ ] Stripe PHP package installed
- [ ] Admin account created
- [ ] Test products added to store

### ✅ Environment Check

- [ ] Laravel application running
- [ ] Database connected
- [ ] No console errors
- [ ] Admin panel accessible

---

## Admin Panel Testing

### Payment Gateway Management

#### Access & Navigation

- [ ] Can access `/admin/payment-gateways`
- [ ] All three gateways visible (Stripe, SSLCommerz, Bkash)
- [ ] "Payment Gateways" link in sidebar works
- [ ] Page loads without errors

#### Gateway Status Display

- [ ] Each gateway shows correct status (Enabled/Disabled)
- [ ] Mode displayed correctly (Sandbox/Live)
- [ ] Configuration status shown (Configured/Not Configured)
- [ ] Icons display correctly for each gateway

#### Enable/Disable Functionality

- [ ] Can click "Edit" button
- [ ] Edit page loads correctly
- [ ] Can toggle Enabled/Disabled radio buttons
- [ ] Can toggle Sandbox/Live mode
- [ ] Changes save successfully
- [ ] Success message displays
- [ ] Redirects back to index page
- [ ] Status updates on index page

---

## Gateway Configuration Testing

### Stripe Configuration

#### Test Credentials

```
Publishable Key: pk_test_51234567890abcdef
Secret Key: sk_test_51234567890abcdef
```

#### Configuration Steps

- [ ] Navigate to Stripe edit page
- [ ] Select "Enabled"
- [ ] Select "Sandbox" mode
- [ ] Enter test publishable key
- [ ] Enter test secret key
- [ ] (Optional) Enter webhook secret
- [ ] Click "Save Configuration"
- [ ] Success message appears
- [ ] Gateway marked as "Configured"

#### Validation

- [ ] Cannot save with empty API key when enabled
- [ ] Cannot save with empty secret key when enabled
- [ ] Can save when disabled without credentials
- [ ] Error messages display correctly

### SSLCommerz Configuration

#### Test Credentials

```
Store ID: [Get from SSLCommerz sandbox]
Store Password: [Get from SSLCommerz sandbox]
```

#### Configuration Steps

- [ ] Navigate to SSLCommerz edit page
- [ ] Select "Enabled"
- [ ] Select "Sandbox" mode
- [ ] Enter store ID
- [ ] Enter store password
- [ ] Click "Save Configuration"
- [ ] Success message appears
- [ ] Gateway marked as "Configured"

### Bkash Configuration

#### Test Credentials

```
App Key: [Get from Bkash sandbox]
App Secret: [Get from Bkash sandbox]
Username: [Get from Bkash sandbox]
Password: [Get from Bkash sandbox]
```

#### Configuration Steps

- [ ] Navigate to Bkash edit page
- [ ] Select "Enabled"
- [ ] Select "Sandbox" mode
- [ ] Enter app key
- [ ] Enter app secret
- [ ] Enter username
- [ ] Enter password
- [ ] Click "Save Configuration"
- [ ] Success message appears
- [ ] Gateway marked as "Configured"

---

## Customer Checkout Testing

### Cash on Delivery (Always Enabled)

#### Checkout Flow

- [ ] Add product to cart
- [ ] Go to checkout page
- [ ] Fill shipping information
- [ ] COD option is visible
- [ ] COD is selected by default
- [ ] COD has green money icon
- [ ] Click "Place Order"
- [ ] Order created successfully
- [ ] Redirected to order confirmation
- [ ] Order status: "Pending"
- [ ] Payment status: "Pending"

#### Order Verification

- [ ] Order appears in customer order history
- [ ] Order appears in admin orders list
- [ ] Order details correct
- [ ] Payment method shows "cash_on_delivery"

### Stripe Payment Testing

#### Prerequisites

- [ ] Stripe enabled in admin
- [ ] Stripe configured with test keys
- [ ] Test card: 4242 4242 4242 4242

#### Checkout Flow

- [ ] Add product to cart
- [ ] Go to checkout page
- [ ] Stripe option visible
- [ ] Stripe has Stripe icon
- [ ] Select Stripe payment method
- [ ] Click "Place Order"
- [ ] Redirected to Stripe Checkout
- [ ] Stripe checkout page loads
- [ ] Order details correct on Stripe page

#### Payment Success

- [ ] Enter test card: 4242 4242 4242 4242
- [ ] Enter future expiry date
- [ ] Enter any CVC
- [ ] Click "Pay"
- [ ] Payment processes successfully
- [ ] Redirected back to site
- [ ] Order confirmation page shows
- [ ] Order status: "Processing"
- [ ] Payment status: "Paid"

#### Payment Failure

- [ ] Use declined card: 4000 0000 0000 0002
- [ ] Payment fails
- [ ] Error message shown
- [ ] Order status: "Pending"
- [ ] Payment status: "Failed"

#### Payment Cancellation

- [ ] Start payment process
- [ ] Click "Back" or "Cancel" on Stripe
- [ ] Redirected back to site
- [ ] Appropriate message shown
- [ ] Order status: "Pending"

### SSLCommerz Payment Testing

#### Prerequisites

- [ ] SSLCommerz enabled in admin
- [ ] SSLCommerz configured with sandbox credentials

#### Checkout Flow

- [ ] Add product to cart
- [ ] Go to checkout page
- [ ] SSLCommerz option visible
- [ ] SSLCommerz has shield icon
- [ ] Select SSLCommerz payment method
- [ ] Click "Place Order"
- [ ] Redirected to SSLCommerz
- [ ] SSLCommerz page loads
- [ ] Order details correct

#### Payment Success

- [ ] Select payment method on SSLCommerz
- [ ] Enter test card details
- [ ] Complete payment
- [ ] Redirected back to site
- [ ] Order confirmation shows
- [ ] Order status: "Processing"
- [ ] Payment status: "Paid"

#### Payment Failure

- [ ] Initiate payment
- [ ] Use invalid card or cancel
- [ ] Payment fails
- [ ] Redirected to failure page
- [ ] Error message shown
- [ ] Order status: "Pending"
- [ ] Payment status: "Failed"

### Bkash Payment Testing

#### Prerequisites

- [ ] Bkash enabled in admin
- [ ] Bkash configured with sandbox credentials

#### Checkout Flow

- [ ] Add product to cart
- [ ] Go to checkout page
- [ ] Bkash option visible
- [ ] Bkash has mobile icon
- [ ] Select Bkash payment method
- [ ] Click "Place Order"
- [ ] Redirected to Bkash
- [ ] Bkash page loads
- [ ] Order details correct

#### Payment Success

- [ ] Login to test Bkash account
- [ ] Confirm payment
- [ ] Payment processes
- [ ] Redirected back to site
- [ ] Order confirmation shows
- [ ] Order status: "Processing"
- [ ] Payment status: "Paid"

#### Payment Failure

- [ ] Initiate payment
- [ ] Cancel or fail payment
- [ ] Redirected back
- [ ] Error message shown
- [ ] Order status: "Pending"
- [ ] Payment status: "Failed"

---

## Multiple Gateway Testing

### All Gateways Enabled

- [ ] Enable all gateways in admin
- [ ] Go to checkout page
- [ ] All 4 options visible:
    - [ ] Cash on Delivery
    - [ ] Stripe
    - [ ] SSLCommerz
    - [ ] Bkash
- [ ] Can select each option
- [ ] Each option works correctly

### Selective Enabling

- [ ] Enable only Stripe
- [ ] Only COD and Stripe visible on checkout
- [ ] Enable only SSLCommerz
- [ ] Only COD and SSLCommerz visible
- [ ] Enable only Bkash
- [ ] Only COD and Bkash visible

### All Gateways Disabled

- [ ] Disable all online gateways
- [ ] Only COD visible on checkout
- [ ] COD still works correctly

---

## Edge Cases & Error Handling

### Invalid Credentials

- [ ] Enter invalid Stripe keys
- [ ] Payment fails gracefully
- [ ] Error logged
- [ ] User-friendly message shown

### Network Issues

- [ ] Simulate network timeout
- [ ] Error handled gracefully
- [ ] Order not lost
- [ ] User can retry

### Concurrent Orders

- [ ] Multiple users checkout simultaneously
- [ ] All orders processed correctly
- [ ] No race conditions
- [ ] Stock updated correctly

### Cart Modifications

- [ ] Start checkout
- [ ] Modify cart in another tab
- [ ] Original checkout handles correctly

---

## Admin Order Management

### Order List

- [ ] All orders visible
- [ ] Payment method shown correctly
- [ ] Payment status shown correctly
- [ ] Can filter by payment method
- [ ] Can filter by payment status

### Order Details

- [ ] Payment method displayed
- [ ] Payment status displayed
- [ ] Can update order status
- [ ] Can update payment status
- [ ] Changes save correctly

---

## Security Testing

### Admin Access

- [ ] Non-admin cannot access `/admin/payment-gateways`
- [ ] Redirected to login if not authenticated
- [ ] Redirected to home if not admin

### CSRF Protection

- [ ] Forms have CSRF tokens
- [ ] Cannot submit without valid token
- [ ] Token validation works

### API Key Security

- [ ] API keys not visible in page source
- [ ] API keys not in JavaScript
- [ ] Password fields masked
- [ ] Sensitive data encrypted in transit

---

## Performance Testing

### Page Load Times

- [ ] Admin gateway list loads < 2 seconds
- [ ] Gateway edit page loads < 2 seconds
- [ ] Checkout page loads < 2 seconds
- [ ] Payment redirect < 3 seconds

### Database Queries

- [ ] No N+1 query problems
- [ ] Queries optimized
- [ ] Indexes used correctly

---

## Mobile Responsiveness

### Admin Panel

- [ ] Gateway list responsive on mobile
- [ ] Edit form usable on mobile
- [ ] Buttons accessible on mobile
- [ ] No horizontal scrolling

### Checkout Page

- [ ] Payment options visible on mobile
- [ ] Can select payment method
- [ ] Forms usable on mobile
- [ ] Payment process works on mobile

---

## Browser Compatibility

### Desktop Browsers

- [ ] Chrome - All features work
- [ ] Firefox - All features work
- [ ] Safari - All features work
- [ ] Edge - All features work

### Mobile Browsers

- [ ] Chrome Mobile - All features work
- [ ] Safari iOS - All features work
- [ ] Samsung Internet - All features work

---

## Documentation Review

### Code Documentation

- [ ] Controllers have comments
- [ ] Methods documented
- [ ] Complex logic explained

### User Documentation

- [ ] PAYMENT_GATEWAY_GUIDE.md complete
- [ ] PAYMENT_QUICK_REFERENCE.md accurate
- [ ] PAYMENT_ARCHITECTURE.md clear
- [ ] All links work

---

## Production Readiness

### Before Going Live

- [ ] All tests passed
- [ ] Sandbox testing complete
- [ ] Live credentials obtained
- [ ] Webhooks configured
- [ ] SSL certificate installed
- [ ] Error logging enabled
- [ ] Backup system in place
- [ ] Monitoring set up

### Live Credentials

- [ ] Stripe live keys added
- [ ] SSLCommerz live credentials added
- [ ] Bkash live credentials added
- [ ] Sandbox mode disabled
- [ ] Test transactions in live mode
- [ ] Verify webhooks working

### Final Checks

- [ ] All gateways working in live mode
- [ ] Error handling tested
- [ ] Customer support ready
- [ ] Refund process documented
- [ ] Compliance requirements met

---

## Sign-Off

### Testing Completed By

- Name: ************\_\_\_************
- Date: ************\_\_\_************
- Signature: **********\_\_\_**********

### Issues Found

| Issue # | Description | Severity | Status | Fixed By |
| ------- | ----------- | -------- | ------ | -------- |
| 1       |             |          |        |          |
| 2       |             |          |        |          |
| 3       |             |          |        |          |

### Notes

```
[Add any additional notes or observations here]
```

---

## Quick Test Commands

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Check routes
php artisan route:list | grep payment

# Check database
php artisan db:show
php artisan migrate:status

# Run seeder
php artisan db:seed --class=PaymentGatewaySeeder

# Check logs
tail -f storage/logs/laravel.log
```

---

**Remember**: Always test in sandbox/test mode before enabling live payments!
