<?php $title = $title ?? 'Reliance Digital Agency'; $page = $page ?? ''; ?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title) ?></title><meta name="description" content="Web design, PHP development, e-commerce and digital growth services from Reliance Digital Agency.">
<link rel="stylesheet" href="/assets/css/style.css"><script defer src="/assets/js/site.js"></script>
</head><body>
<div class="topbar"><div class="wrap">Samarth Nagar, Pune <span><a href="tel:+12187874743">+1 218 787 4743</a> · <a href="mailto:support@reliancedigital.agency">support@reliancedigital.agency</a></span></div></div>
<header><div class="wrap nav"><a class="brand" href="/"><b>R</b><span>Reliance Digital<small>AGENCY</small></span></a><button class="menu" aria-label="Open menu">☰</button><nav>
<a class="<?= $page==='home'?'active':'' ?>" href="/">Home</a><a class="<?= $page==='services'?'active':'' ?>" href="/services.php">Services</a><a class="<?= $page==='packages'?'active':'' ?>" href="/packages.php">Packages</a><a class="<?= $page==='contact'?'active':'' ?>" href="/contact.php">Contact</a><a class="cta" href="/packages.php">Build my website ↗</a>
</nav></div></header>

