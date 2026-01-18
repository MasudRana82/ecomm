# Payment Gateway System Architecture

## System Flow Diagram

```
┌─────────────────────────────────────────────────────────────────┐
│                         CUSTOMER FLOW                            │
└─────────────────────────────────────────────────────────────────┘

1. Browse Products → 2. Add to Cart → 3. Checkout → 4. Select Payment
                                                            │
                    ┌───────────────────────────────────────┴──────────────────────────┐
                    │                                                                   │
            ┌───────▼────────┐    ┌──────────────┐    ┌──────────────┐    ┌──────────▼────────┐
            │ Cash on        │    │   Stripe     │    │  SSLCommerz  │    │     Bkash         │
            │ Delivery       │    │  (Cards)     │    │  (Multiple)  │    │  (Mobile Wallet)  │
            └───────┬────────┘    └──────┬───────┘    └──────┬───────┘    └──────┬────────────┘
                    │                    │                    │                    │
                    │              Redirect to         Redirect to          Redirect to
                    │              Stripe Checkout     SSLCommerz          Bkash Payment
                    │                    │                    │                    │
                    │              Enter Card          Select Method        Login & Pay
                    │              Details             & Pay                      │
                    │                    │                    │                    │
                    └────────────────────┴────────────────────┴────────────────────┘
                                                │
                                    ┌───────────▼──────────┐
                                    │  Order Confirmation  │
                                    │  Payment Status:     │
                                    │  - Pending (COD)     │
                                    │  - Paid (Online)     │
                                    └──────────────────────┘


┌─────────────────────────────────────────────────────────────────┐
│                         ADMIN FLOW                               │
└─────────────────────────────────────────────────────────────────┘

1. Login to Admin → 2. Payment Gateways → 3. Configure Gateway
                                                      │
                    ┌─────────────────────────────────┴──────────────────────┐
                    │                                                         │
            ┌───────▼────────┐                                    ┌──────────▼────────┐
            │  Enable/Disable │                                   │  Add API Keys     │
            │  Gateway        │                                   │  - Publishable    │
            │                 │                                   │  - Secret         │
            │  ✓ Enabled      │                                   │  - Store ID       │
            │  ○ Disabled     │                                   │  - App Key        │
            └───────┬────────┘                                    └──────────┬────────┘
                    │                                                         │
            ┌───────▼────────┐                                    ┌──────────▼────────┐
            │  Select Mode   │                                    │  Save & Test      │
            │                │                                    │                   │
            │  ○ Sandbox     │                                    │  Gateway now      │
            │  ○ Live        │                                    │  visible on       │
            └────────────────┘                                    │  checkout         │
                                                                  └───────────────────┘


┌─────────────────────────────────────────────────────────────────┐
│                    DATABASE STRUCTURE                            │
└─────────────────────────────────────────────────────────────────┘

┌──────────────────────────────┐         ┌──────────────────────────────┐
│ payment_gateway_settings     │         │         orders               │
├──────────────────────────────┤         ├──────────────────────────────┤
│ id                           │         │ id                           │
│ gateway_name (stripe, etc)   │         │ order_number                 │
│ is_enabled (boolean)         │◄────────┤ payment_method               │
│ sandbox_mode (boolean)       │         │ payment_status               │
│ api_key                      │         │ status                       │
│ api_secret                   │         │ total                        │
│ store_id (SSLCommerz)        │         │ shipping_address             │
│ store_password (SSLCommerz)  │         │ billing_address              │
│ app_key (Bkash)              │         │ created_at                   │
│ app_secret (Bkash)           │         └──────────────────────────────┘
│ username (Bkash)             │
│ password (Bkash)             │         ┌──────────────────────────────┐
│ webhook_secret               │         │       order_items            │
│ created_at                   │         ├──────────────────────────────┤
│ updated_at                   │         │ id                           │
└──────────────────────────────┘         │ order_id                     │
                                         │ product_id                   │
                                         │ quantity                     │
                                         │ price                        │
                                         │ total                        │
                                         └──────────────────────────────┘


┌─────────────────────────────────────────────────────────────────┐
│                    PAYMENT PROCESSING FLOW                       │
└─────────────────────────────────────────────────────────────────┘

Customer Submits Order
         │
         ▼
OrderController.store()
         │
         ├─── Create Order Record
         │    (status: pending, payment_status: pending)
         │
         ├─── Create Order Items
         │
         ├─── Reduce Product Stock
         │
         ├─── Clear Cart
         │
         ▼
Check Payment Method
         │
         ├─── Cash on Delivery?
         │    └─── Return Success (Order stays pending)
         │
         ├─── Stripe?
         │    └─── PaymentController.processStripePayment()
         │         ├─── Create Stripe Checkout Session
         │         ├─── Redirect to Stripe
         │         └─── Return to success/cancel URL
         │
         ├─── SSLCommerz?
         │    └─── PaymentController.processSSLCommerzPayment()
         │         ├─── Initialize SSLCommerz Transaction
         │         ├─── Redirect to SSLCommerz
         │         └─── Return to success/fail/cancel URL
         │
         └─── Bkash?
              └─── PaymentController.processBkashPayment()
                   ├─── Get Bkash Auth Token
                   ├─── Create Payment
                   ├─── Redirect to Bkash
                   └─── Return to callback URL

Payment Gateway Response
         │
         ├─── Success → Update Order
         │              (status: processing, payment_status: paid)
         │
         ├─── Failure → Update Order
         │              (status: pending, payment_status: failed)
         │
         └─── Cancel → Keep Order
                       (status: pending, payment_status: pending)


┌─────────────────────────────────────────────────────────────────┐
│                    FILE STRUCTURE                                │
└─────────────────────────────────────────────────────────────────┘

ecomm/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── PaymentController.php         (Payment processing)
│   │       ├── PaymentGatewayController.php  (Admin management)
│   │       └── OrderController.php           (Order creation)
│   └── Models/
│       ├── PaymentGatewaySetting.php         (Gateway config)
│       └── Order.php                         (Order data)
│
├── database/
│   ├── migrations/
│   │   └── 2026_01_19_000001_create_payment_gateway_settings_table.php
│   └── seeders/
│       └── PaymentGatewaySeeder.php
│
├── resources/
│   └── views/
│       ├── admin/
│       │   ├── payment-gateways/
│       │   │   ├── index.blade.php           (List gateways)
│       │   │   └── edit.blade.php            (Configure gateway)
│       │   └── layout.blade.php              (Admin sidebar)
│       └── checkout.blade.php                (Payment selection)
│
├── routes/
│   └── web.php                               (All routes)
│
└── Documentation/
    ├── PAYMENT_GATEWAY_GUIDE.md              (Full guide)
    ├── PAYMENT_IMPLEMENTATION_SUMMARY.md     (Summary)
    └── PAYMENT_QUICK_REFERENCE.md            (Quick ref)


┌─────────────────────────────────────────────────────────────────┐
│                    SECURITY LAYERS                               │
└─────────────────────────────────────────────────────────────────┘

┌─────────────────────────────────────────────────────────────────┐
│  1. Admin Authentication (Middleware)                            │
│     - Only admins can access payment gateway settings            │
└─────────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────▼───────────────────────────────────┐
│  2. CSRF Protection                                              │
│     - All forms protected with CSRF tokens                       │
└─────────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────▼───────────────────────────────────┐
│  3. API Key Storage                                              │
│     - Stored in database (recommend encryption in production)    │
└─────────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────▼───────────────────────────────────┐
│  4. Sandbox/Live Mode Separation                                 │
│     - Test safely before going live                              │
└─────────────────────────────────────────────────────────────────┘
                              │
┌─────────────────────────────▼───────────────────────────────────┐
│  5. Payment Gateway Security                                     │
│     - PCI DSS compliant (Stripe)                                 │
│     - SSL/TLS encryption                                         │
│     - Webhook signature verification                             │
└─────────────────────────────────────────────────────────────────┘
```

## Key Components

### 1. Models

- **PaymentGatewaySetting**: Stores gateway configuration
- **Order**: Stores order and payment information

### 2. Controllers

- **PaymentGatewayController**: Admin CRUD for gateways
- **PaymentController**: Process payments
- **OrderController**: Create orders

### 3. Views

- **Admin Panel**: Configure gateways
- **Checkout Page**: Select payment method
- **Order Confirmation**: Show payment status

### 4. Routes

- `/admin/payment-gateways` - Admin management
- `/checkout` - Customer checkout
- `/payment/success/{order}` - Payment success callback
- `/payment/failure/{order}` - Payment failure callback
- `/payment/cancel/{order}` - Payment cancellation

## Payment Status Flow

```
Order Created
    │
    ├─── COD: pending → (on delivery) → paid
    │
    ├─── Online Payment: pending → processing → paid
    │                              │
    │                              └─── (if failed) → failed
    │
    └─── Cancelled: pending → cancelled
```

## Integration Points

1. **Stripe**: Direct API integration using Stripe Checkout
2. **SSLCommerz**: HTTP API integration
3. **Bkash**: Tokenized checkout API
4. **Database**: Laravel Eloquent ORM
5. **Frontend**: Blade templates with Tailwind CSS
