const menuButton = document.querySelector('.menu');
const navigation = document.querySelector('header nav');

menuButton?.addEventListener('click', () => {
  const isOpen = navigation?.classList.toggle('open') ?? false;
  menuButton.setAttribute('aria-expanded', String(isOpen));
});

navigation?.querySelectorAll('a[href*="#"]').forEach(link => {
  link.addEventListener('click', () => {
    navigation.classList.remove('open');
    menuButton?.setAttribute('aria-expanded', 'false');
  });
});

const sections = [...document.querySelectorAll('main section[id]')];
const navigationLinks = [...document.querySelectorAll('header nav a[href*="#"]')];
if ('IntersectionObserver' in window && sections.length) {
  const observer = new IntersectionObserver(entries => {
    const visible = entries
      .filter(entry => entry.isIntersecting)
      .sort((a, b) => b.intersectionRatio - a.intersectionRatio)[0];
    if (!visible) return;
    navigationLinks.forEach(link => {
      const target = link.getAttribute('href')?.split('#')[1];
      link.classList.toggle('active', target === visible.target.id);
    });
  }, { rootMargin: '-25% 0px -60%', threshold: [0.1, 0.35, 0.6] });
  sections.forEach(section => observer.observe(section));
}
