<?php
require __DIR__.'/includes/bootstrap.php';

$sent = false;
$error = '';
if (is_post() && (string)($_POST['form_type'] ?? '') === 'contact') {
    verify_csrf();
    $name = trim((string)($_POST['name'] ?? ''));
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $message = trim((string)($_POST['message'] ?? ''));
    if ($name === '' || !$email || $message === '') {
        $error = 'Please complete all required fields.';
    } else {
        try {
            $stmt = db()->prepare('INSERT INTO contacts(name,email,phone,service,budget,message,ip_hash) VALUES(?,?,?,?,?,?,?)');
            $stmt->execute([
                $name,
                $email,
                trim((string)($_POST['phone'] ?? '')),
                trim((string)($_POST['service'] ?? '')),
                trim((string)($_POST['budget'] ?? '')),
                $message,
                hash('sha256', ($_SERVER['REMOTE_ADDR'] ?? '') . csrf_token()),
            ]);
            $sent = true;
        } catch (Throwable $exception) {
            error_log('Contact submission failed: ' . $exception->getMessage());
            $error = 'We could not save your enquiry right now. Please try again.';
        }
    }
}

$title = 'Ascension Suppliers | Websites That Deliver';
$page = 'home';
require __DIR__.'/includes/header.php';
?>
<main>
<section class="hero" id="home"><div class="grid-bg"></div><div class="wrap hero-grid"><div><span class="kicker">PHP WEBSITES FOR GROWING BRANDS</span><h1>Ideas that <em>rise.</em><br>Websites that <strong>sell.</strong></h1><p>We design and build fast, secure PHP websites that turn visitors into customers—from strategy and design to payments, databases and ongoing support.</p><div class="actions"><a class="btn primary" href="#packages">View packages ↗</a><a class="text-link" href="#contact">Request a quote →</a></div></div><div class="hero-art"><div class="code-card"><i></i><i></i><i></i><code>&lt;build&gt;<br>&nbsp;strategy: true;<br>&nbsp;payments: secure;<br>&nbsp;growth: ∞;<br>&lt;/build&gt;</code></div><div class="growth"><small>Conversion-ready</small><b>PHP + MySQL</b><span>DESIGN · DEVELOP · DELIVER</span></div></div></div></section>

<section class="section" id="about"><div class="wrap split"><div><span class="kicker">WHAT WE BUILD</span><h2>More than a beautiful website.</h2></div><div><p class="lead">Your website should explain your value, earn trust and make it easy for customers to take action.</p><p>Our builds combine responsive design, secure PHP development, MySQL databases, Razorpay payments and search-friendly foundations.</p></div></div></section>

<section class="section soft" id="services"><div class="wrap"><div class="section-head"><div><span class="kicker">OUR SERVICES</span><h2>Digital services built around business outcomes.</h2><p class="section-intro">From a focused landing page to a payment-enabled platform, we bring design, development and support together.</p></div></div><div class="cards services-grid">
<?php foreach ([['Custom PHP Development','Secure, tailored applications and business websites.'],['Responsive Web Design','Mobile-first interfaces that feel fast on every screen.'],['E-Commerce Solutions','Catalogues, carts, orders and Razorpay checkout.'],['Landing Pages','Campaign pages focused on leads and sales.'],['MySQL Database Development','Structured storage for enquiries, customers and orders.'],['SEO Foundations','Clean metadata, performance and search-ready structure.'],['Website Redesign','Modernise an outdated site without losing its purpose.'],['Maintenance & Support','Updates, monitoring, backups and technical care.']] as $i => $service): ?>
<article><b><?= str_pad((string)($i + 1), 2, '0', STR_PAD_LEFT) ?></b><h3><?= e($service[0]) ?></h3><p><?= e($service[1]) ?></p><a href="#contact">Discuss this service →</a></article>
<?php endforeach; ?>
</div></div></section>

<section class="section dark" id="process"><div class="wrap process"><div><span class="kicker light">OUR PROCESS</span><h2>Clear steps.<br>Better results.</h2></div><div><article><b>01</b><span><h3>Discover</h3><p>Goals, customers, content and requirements.</p></span></article><article><b>02</b><span><h3>Design</h3><p>Structure, visuals and conversion journey.</p></span></article><article><b>03</b><span><h3>Develop</h3><p>PHP, database, payments and testing.</p></span></article><article><b>04</b><span><h3>Launch</h3><p>Hostinger deployment, support and growth.</p></span></article></div></div></section>

<section class="section packages-section" id="packages"><div class="wrap section-head"><div><span class="kicker">CLEAR PRICING</span><h2>Start with a package.</h2><p class="section-intro">Pay the full project fee, reserve your start date with a 30% deposit, or request a tailored quote.</p></div></div><div class="wrap pricing">
<?php $features = [['starter',['Up to 5 pages','Responsive design','Contact form','Basic SEO']],['business',['Up to 10 pages','PHP + MySQL','Admin-ready structure','Advanced SEO foundations']],['ecommerce',['Product catalogue','Razorpay payments','Orders database','Admin dashboard']]]; foreach ($features as [$slug,$items]): $package = $packages[$slug]; ?>
<article class="price-card <?= $slug === 'business' ? 'featured' : '' ?>"><?php if ($slug === 'business'): ?><span class="popular">POPULAR</span><?php endif; ?><small><?= e($package['name']) ?></small><h2><?= e($package['label']) ?></h2><p>Starting price</p><ul><?php foreach ($items as $item): ?><li>✓ <?= e($item) ?></li><?php endforeach; ?></ul><button class="btn primary pay-button" data-package="<?= e($slug) ?>" data-type="full">Pay full amount</button><button class="btn outline pay-button" data-package="<?= e($slug) ?>" data-type="deposit">Pay 30% deposit</button></article>
<?php endforeach; ?>
</div><div class="wrap custom-pay"><div><span class="kicker">CUSTOM QUOTE</span><h2>Already received a quote?</h2><p>Enter the quote reference and approved amount to pay securely.</p></div><form id="quote-payment"><label>Quote reference<input name="quote_ref" required placeholder="QUOTE-1001"></label><label>Amount (₹)<input name="quote_amount" type="number" min="1000" required placeholder="25000"></label><button class="btn primary" type="submit">Pay quoted amount ↗</button></form></div></section>

<section class="section soft" id="contact"><div class="wrap contact-heading"><span class="kicker">LET’S TALK</span><h2>Tell us what you’re ready to build.</h2><p>Share your goals, requirements and timeline. We’ll reply with a clear next step.</p></div><div class="wrap contact-grid"><div><span class="kicker">CONTACT</span><h2>Start a useful conversation.</h2><p>Phone: <a href="tel:+12187874743">+1 218 787 4743</a></p><p>WhatsApp: <a href="https://wa.me/919325983943">+91 93259 83943</a></p><p>Email: <a href="mailto:pbhalshankar5@gmail.com">pbhalshankar5@gmail.com</a></p><p>Samarth Nagar, Pune</p></div><form class="contact-form" method="post" action="/#contact"><input type="hidden" name="form_type" value="contact"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><?php if ($sent): ?><div class="success">Thank you. Your enquiry has been saved and we’ll contact you soon.</div><?php elseif ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?><div class="two"><label>Name *<input name="name" required></label><label>Email *<input type="email" name="email" required></label></div><div class="two"><label>Phone<input name="phone"></label><label>Service<select name="service"><option>PHP Website</option><option>E-Commerce</option><option>Landing Page</option><option>Website Redesign</option><option>Maintenance</option></select></label></div><label>Budget<select name="budget"><option>₹10,000–₹25,000</option><option>₹25,000–₹50,000</option><option>₹50,000+</option></select></label><label>Project details *<textarea name="message" rows="6" required></textarea></label><button class="btn primary">Send enquiry ↗</button></form></div></section>
</main>

<div class="modal" id="pay-modal" hidden><div class="modal-card"><button class="close" type="button">×</button><h2>Complete your details</h2><p>We’ll create a secure Razorpay order for your selected option.</p><form id="payment-form"><input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>"><input type="hidden" name="package"><input type="hidden" name="payment_type"><input type="hidden" name="quote_ref"><input type="hidden" name="quote_amount"><label>Full name<input name="name" required autocomplete="name"></label><label>Email<input name="email" type="email" required autocomplete="email"></label><label>Phone<input name="phone" required autocomplete="tel"></label><button class="btn primary" type="submit">Continue to payment</button><p class="form-note" aria-live="polite"></p></form></div></div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script><script defer src="/assets/js/payments.js"></script>
<?php require __DIR__.'/includes/footer.php'; ?>
