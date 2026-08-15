<?php $title = $title ?? 'Reliance Digital Agency'; $page = $page ?? ''; ?>
<!doctype html><html lang="en"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= e($title) ?></title><meta name="description" content="Web design, PHP development, e-commerce and digital growth services from Reliance Digital Agency.">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="/assets/css/style.css"><?php if ($page === 'privacy'): ?><link rel="stylesheet" href="/assets/css/privacy.css"><?php endif; ?><script defer src="/assets/js/site.js"></script>
</head><body>
<div class="topbar" aria-hidden="true"><div class="wrap"></div></div>
<header><div class="wrap nav"><a class="brand" href="/"><b>A</b><span>Ascension Suppliers</span></a><button class="menu" aria-label="Open menu">☰</button><nav>
<a class="<?= $page==='home'?'active':'' ?>" href="/#home">Home</a><a href="/#about">About</a><a href="/#services">Services</a><a href="/#packages">Packages</a><a href="/#contact">Contact</a><a class="cta" href="/#contact">Build my website ↗</a>
</nav></div></header>
