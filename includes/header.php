<?php $title = $title ?? 'Reliance Digital Agency'; $page = $page ?? ''; ?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title) ?></title><link rel="icon" type="image/png" sizes="192x192" href="/assets/images/ascension-symbol-icon.png"><link rel="apple-touch-icon" href="/assets/images/favicon.png"><meta name="description" content="Web design, PHP development, e-commerce and digital growth services from Reliance Digital Agency.">
<link rel="stylesheet" href="/assets/css/style.css"><?php if ($page === 'privacy'): ?><link rel="stylesheet" href="/assets/css/privacy.css"><?php endif; ?><script defer src="/assets/js/site.js"></script>
<!-- Meta Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '1086480664055827');
fbq('track', 'PageView');
</script>
<!-- End Meta Pixel Code -->
</head><body>
<noscript><img height="1" width="1" style="display:none"
src="https://www.facebook.com/tr?id=1086480664055827&ev=PageView&noscript=1"
alt=""
></noscript>
<div class="topbar" aria-hidden="true"><div class="wrap"></div></div>
<header><div class="wrap nav"><a class="brand header-brand" href="/" aria-label="Ascension Suppliers home"><img class="brand-icon" src="/assets/images/favicon.png" alt="" aria-hidden="true"><span class="brand-text">Ascension Suppliers</span></a><button class="menu" aria-label="Open menu">☰</button><nav>
<a class="<?= $page==='home'?'active':'' ?>" href="/#home">Home</a><a href="/#about">About</a><a href="/#services">Services</a><a href="/#packages">Packages</a><a href="/#contact">Contact</a><a class="cta" href="/#contact">Build my website ↗</a>
</nav></div></header>
