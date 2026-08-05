"use client";

import Link from "next/link";
import { useState } from "react";

export const services = [
  { icon: "</>", title: "Custom Website Development", text: "Fast, scalable websites engineered around your business goals." },
  { icon: "◫", title: "Responsive Web Design", text: "Polished experiences that feel natural on every screen size." },
  { icon: "🛒", title: "E-Commerce Solutions", text: "Conversion-focused online stores built to make selling simpler." },
  { icon: "↗", title: "Landing Pages", text: "Focused campaign pages designed to turn attention into action." },
  { icon: "W", title: "WordPress Development", text: "Flexible WordPress builds that your team can confidently manage." },
  { icon: "⌕", title: "SEO", text: "Search-ready structure, speed, content foundations and visibility." },
  { icon: "↻", title: "Website Redesign", text: "A smarter visual and technical refresh for an outdated website." },
  { icon: "⚙", title: "Maintenance & Support", text: "Reliable updates, monitoring and ongoing technical care." },
];

const nav = [["Home", "/"], ["About", "/about"], ["Services", "/services"], ["Work", "/work"], ["Contact", "/contact"]];

export function Header() {
  const [open, setOpen] = useState(false);
  return <>
    <div className="topbar"><div className="container top-inner"><span>Samarth Nagar, Pune</span><div><a href="tel:+12187874743">+1 218 787 4743</a><span className="top-sep">•</span><a href="mailto:pbhalshankar5@gmail.com">pbhalshankar5@gmail.com</a></div></div></div>
    <header className="header"><div className="container nav-wrap">
      <Link className="logo" href="/" aria-label="Ascension Suppliers home"><span className="logo-mark">A</span><span>Ascension<small>SUPPLIERS</small></span></Link>
      <button className="menu-btn" onClick={() => setOpen(!open)} aria-label="Toggle navigation" aria-expanded={open}>{open ? "×" : "☰"}</button>
      <nav className={open ? "nav open" : "nav"}>{nav.map(([label, href]) => <Link key={href} href={href} onClick={() => setOpen(false)}>{label}</Link>)}<Link className="nav-cta" href="/contact">Start a project <span>↗</span></Link></nav>
    </div></header>
  </>;
}

export function Footer() {
  return <footer><div className="footer-burst"></div><div className="container footer-grid">
    <div><Link className="logo logo-light" href="/"><span className="logo-mark">A</span><span>Ascension<small>SUPPLIERS</small></span></Link><p>We create practical digital experiences that help ambitious businesses rise.</p><div className="socials"><span>in</span><span>f</span><span>ig</span></div></div>
    <div><h4>Explore</h4><Link href="/about">About us</Link><Link href="/services">Services</Link><Link href="/work">Our work</Link><Link href="/contact">Contact</Link></div>
    <div><h4>Services</h4><span>Web Development</span><span>E-Commerce</span><span>WordPress</span><span>SEO & Support</span></div>
    <div><h4>Let’s talk</h4><a href="tel:+12187874743">+1 218 787 4743</a><a href="https://wa.me/919420911694">WhatsApp us</a><a href="mailto:pbhalshankar5@gmail.com">pbhalshankar5@gmail.com</a><span>Samarth Nagar, Pune</span></div>
  </div><div className="container footer-bottom"><span>© 2026 Ascension Suppliers. All rights reserved.</span><span>Design. Develop. Deliver.</span></div></footer>;
}

export function Shell({ children }: { children: React.ReactNode }) { return <><Header />{children}<a className="whatsapp" href="https://wa.me/919420911694" aria-label="Chat on WhatsApp">◔</a><Footer /></>; }

export function ServiceGrid({ limit }: { limit?: number }) { const list = limit ? services.slice(0, limit) : services; return <div className="service-grid">{list.map((s, i) => <article className="service-card" key={s.title}><div className={`service-icon c${i % 4}`}>{s.icon}</div><span className="service-no">0{i + 1}</span><h3>{s.title}</h3><p>{s.text}</p><Link href="/contact">Explore service <span>↗</span></Link></article>)}</div>; }

export function PageHero({ eyebrow, title, text }: { eyebrow: string, title: string, text: string }) { return <section className="page-hero"><div className="orb orb-a"></div><div className="orb orb-b"></div><div className="container"><span className="eyebrow">{eyebrow}</span><h1>{title}</h1><p>{text}</p></div></section>; }

export function ContactBand() { return <section className="contact-band"><div className="container contact-band-inner"><div><span className="eyebrow light">HAVE AN IDEA?</span><h2>Let’s turn it into something remarkable.</h2></div><Link className="round-link" href="/contact">Start a<br/>project <b>↗</b></Link></div></section>; }
