# Reliance Digital Agency — PHP Website

Native PHP 8.1+ and MySQL website for `reliancedigital.agency`, including service packages, quote requests, Razorpay Orders API checkout, payment signature verification, webhook capture updates, contact storage, and a private admin dashboard.

## Hostinger installation

1. Create a MySQL database and user in hPanel.
2. Import `config/schema.sql` using phpMyAdmin.
3. Copy `config/config.example.php` to `config/config.local.php` in Hostinger File Manager.
4. Enter the MySQL credentials, Razorpay Test keys, webhook secret, and admin password hash.
5. Generate a password hash locally or with a temporary PHP file, then delete that temporary file immediately:
   `password_hash('YOUR-STRONG-PASSWORD', PASSWORD_DEFAULT)`
6. Deploy the repository branch to `public_html`; ensure `index.php` is directly inside `public_html`.
7. In Razorpay Test Mode, add webhook URL `https://reliancedigital.agency/api/razorpay-webhook.php` and subscribe to `payment.captured`.
8. Enable automatic capture in Razorpay, complete test payments, then replace Test keys with Live keys only after verification.

## Admin

Open `/admin/login.php`. Credentials are read from `config/config.local.php`; the password itself is never stored, only its hash.

## Security notes

- Never commit `config/config.local.php`.
- Keep Test and Live Razorpay keys separate.
- The Razorpay Key Secret is used only server-side.
- Payment success is accepted only after HMAC-SHA256 signature verification.
- The webhook signature is verified against the raw request body.
