import {
    createIcons,
    ArrowRight, ArrowUp, ArrowUpRight, Menu, X, Phone, Mail, MapPin, Clock,
    MessageCircle, ChevronRight, ChevronLeft, Search, FileText, Download, Eye,
    Landmark, Calculator, Percent, PiggyBank, HandCoins, CalendarClock,
    LayoutDashboard, Package, Newspaper, Building2, Inbox, LogOut, Plus, Pencil,
    Trash2, Check, ExternalLink, Users, Quote, Image, Network, MessageSquareQuote,
} from 'lucide';

const icons = {
    ArrowRight, ArrowUp, ArrowUpRight, Menu, X, Phone, Mail, MapPin, Clock,
    MessageCircle, ChevronRight, ChevronLeft, Search, FileText, Download, Eye,
    Landmark, Calculator, Percent, PiggyBank, HandCoins, CalendarClock,
    LayoutDashboard, Package, Newspaper, Building2, Inbox, LogOut, Plus, Pencil,
    Trash2, Check, ExternalLink, Users, Quote, Image, Network, MessageSquareQuote,
};

document.documentElement.classList.add('js');
createIcons({ icons, attrs: { 'stroke-width': 1.75, 'aria-hidden': 'true' } });

const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches || navigator.webdriver || /Headless/i.test(navigator.userAgent);

/* Efek bayangan halus pada navbar saat di-scroll */
const header = document.querySelector('header.sticky');
if (header) {
    const onScroll = () => {
        header.classList.toggle('shadow-sm', window.scrollY > 16);
    };
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
}

/* Menu mobile */
const toggle = document.querySelector('[data-nav-toggle]');
const panel = document.querySelector('[data-nav-panel]');
if (toggle && panel) {
    toggle.addEventListener('click', () => {
        const open = panel.classList.toggle('hidden') === false;
        toggle.setAttribute('aria-expanded', String(open));
    });
}

/* Animasi muncul saat scroll + otomatis stagger untuk elemen berurutan */
document.querySelectorAll('[data-stagger]').forEach((group) => {
    const step = Number(group.dataset.stagger) || 95;
    [...group.querySelectorAll(':scope > .reveal, :scope > li.reveal, :scope > article.reveal, :scope > a.reveal')].forEach((el, idx) => {
        el.style.setProperty('--reveal-delay', `${idx * step}ms`);
    });
});

const reveals = document.querySelectorAll('.reveal');
if ('IntersectionObserver' in window && reveals.length && !reduceMotion) {
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (e.isIntersecting) {
                e.target.classList.add('is-visible');
                io.unobserve(e.target);
            }
        });
    }, { threshold: 0.12, rootMargin: '0px 0px -32px 0px' });
    reveals.forEach((el) => io.observe(el));
} else {
    reveals.forEach((el) => el.classList.add('is-visible'));
}

/* Tombol kembali ke atas */
const topBtn = document.querySelector('[data-back-to-top]');
if (topBtn) {
    const update = () => topBtn.classList.toggle('hidden', window.scrollY < 600);
    window.addEventListener('scroll', update, { passive: true });
    update();
    topBtn.addEventListener('click', () => window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' }));
}

/* Helper animasi angka (tweening) untuk simulasi kredit */
const numberTweens = new WeakMap();
const animateCurrency = (el, targetValue, formatter) => {
    if (!el) return;
    if (reduceMotion) {
        el.dataset.currentValue = String(targetValue);
        el.textContent = formatter.format(Math.round(targetValue));
        return;
    }

    const startValue = Number(el.dataset.currentValue ?? targetValue);
    if (Math.abs(targetValue - startValue) < 1) {
        el.textContent = formatter.format(Math.round(targetValue));
        return;
    }

    if (numberTweens.has(el)) cancelAnimationFrame(numberTweens.get(el));
    const duration = 240;
    const startTime = performance.now();

    const tick = (now) => {
        const progress = Math.min(1, (now - startTime) / duration);
        const eased = 1 - Math.pow(1 - progress, 3);
        const current = startValue + (targetValue - startValue) * eased;
        el.dataset.currentValue = String(current);
        el.textContent = formatter.format(Math.round(current));
        if (progress < 1) {
            numberTweens.set(el, requestAnimationFrame(tick));
        }
    };
    numberTweens.set(el, requestAnimationFrame(tick));
};

/* Simulasi angsuran (anuitas) dengan animasi angka halus */
document.querySelectorAll('[data-simulator]').forEach((root) => {
    const q = (n) => root.querySelector(`[data-sim="${n}"]`);
    const money = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });

    const calc = () => {
        const principal = Number(q('amount').value);
        const months = Number(q('tenor').value);
        const rate = Number(q('rate').value.replace(',', '.'));

        q('amount-label').textContent = money.format(principal);
        q('tenor-label').textContent = `${months} bulan`;

        if (!(principal > 0) || !(months > 0) || !(rate >= 0)) {
            ['result', 'interest', 'total'].forEach((k) => {
                const el = q(k);
                if (el) {
                    delete el.dataset.currentValue;
                    el.textContent = '—';
                }
            });
            return;
        }
        const r = rate / 100 / 12;
        const pay = r === 0 ? principal / months : (principal * r) / (1 - Math.pow(1 + r, -months));
        const total = pay * months;

        animateCurrency(q('result'), pay, money);
        animateCurrency(q('interest'), total - principal, money);
        animateCurrency(q('total'), total, money);
    };

    root.querySelectorAll('input').forEach((i) => i.addEventListener('input', calc));
    calc();
});

/* Simulasi deposito (bunga sederhana sebelum pajak) dengan animasi angka halus */
document.querySelectorAll('[data-deposito-sim]').forEach((root) => {
    const q = (n) => root.querySelector(`[data-dep="${n}"]`);
    const money = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 });

    const calc = () => {
        const principal = Number(q('amount').value);
        const months = Number(q('tenor').value);
        const rate = Number(q('rate').value.replace(',', '.'));

        q('amount-label').textContent = money.format(principal);
        q('tenor-label').textContent = `${months} bulan`;

        if (!(principal > 0) || !(months > 0) || !(rate >= 0)) {
            ['interest', 'total'].forEach((k) => {
                const el = q(k);
                if (el) {
                    delete el.dataset.currentValue;
                    el.textContent = '—';
                }
            });
            return;
        }
        const interest = principal * (rate / 100) * (months / 12);
        const total = principal + interest;

        animateCurrency(q('interest'), interest, money);
        animateCurrency(q('total'), total, money);
    };

    root.querySelectorAll('input').forEach((i) => i.addEventListener('input', calc));
    calc();
});

/* Switcher panel simulasi (Kredit <-> Deposito) */
document.querySelectorAll('[data-switch]').forEach((root) => {
    const tabs = [...root.querySelectorAll('[data-switch-target]')];
    const panels = [...root.querySelectorAll('[data-switch-panel]')];
    tabs.forEach((btn) => btn.addEventListener('click', () => {
        const target = btn.dataset.switchTarget;
        tabs.forEach((t) => t.setAttribute('aria-selected', String(t === btn)));
        panels.forEach((p) => p.classList.toggle('hidden', p.dataset.switchPanel !== target));
    }));
});

/* Slider banner hero dengan Ken Burns, teks bertahap, & progress bar */
document.querySelectorAll('[data-slider]').forEach((root) => {
    const slides = [...root.querySelectorAll('[data-slide]')];
    const dots = [...root.querySelectorAll('[data-dot]')];
    if (slides.length < 2) return;

    let index = 0;
    let timer = null;

    const show = (i) => {
        index = (i + slides.length) % slides.length;
        slides.forEach((s, n) => {
            const on = n === index;
            s.classList.toggle('opacity-100', on);
            s.classList.toggle('opacity-0', !on);
            s.classList.toggle('pointer-events-none', !on);
            s.setAttribute('aria-hidden', String(!on));
        });
        dots.forEach((d, n) => {
            const on = n === index;
            d.setAttribute('aria-current', String(on));
            const fill = d.querySelector('.dot-fill');
            if (fill) {
                fill.style.animation = 'none';
                // Paksa reflow agar animasi progress bar mulai dari 0 saat slide berganti
                void fill.offsetWidth;
                fill.style.animation = '';
            }
        });
    };
    const start = () => { if (!reduceMotion) timer = setInterval(() => show(index + 1), 6500); };
    const stop = () => clearInterval(timer);

    root.querySelector('[data-prev]')?.addEventListener('click', () => { stop(); show(index - 1); start(); });
    root.querySelector('[data-next]')?.addEventListener('click', () => { stop(); show(index + 1); start(); });
    dots.forEach((d, n) => d.addEventListener('click', () => { stop(); show(n); start(); }));
    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);
    show(0);
    start();
});

/* Tab filter (produk, informasi, suku bunga) dengan transisi fade halus */
document.querySelectorAll('[data-tabs]').forEach((root) => {
    const buttons = [...root.querySelectorAll('[data-filter]')];
    const items = [...root.querySelectorAll('[data-category]')];
    buttons.forEach((b) => b.addEventListener('click', () => {
        const f = b.dataset.filter;
        buttons.forEach((x) => x.setAttribute('aria-pressed', String(x === b)));

        if (reduceMotion) {
            items.forEach((el) => el.classList.toggle('hidden', f !== 'all' && el.dataset.category !== f));
            return;
        }

        items.forEach((el) => {
            const match = f === 'all' || el.dataset.category === f;
            if (!match && !el.classList.contains('hidden')) {
                el.classList.add('is-filtering-out');
                setTimeout(() => {
                    el.classList.add('hidden');
                    el.classList.remove('is-filtering-out');
                }, 160);
            } else if (match && el.classList.contains('hidden')) {
                el.classList.add('is-filtering-out');
                el.classList.remove('hidden');
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => el.classList.remove('is-filtering-out'));
                });
            }
        });
    }));
});

/* Loading screen (Preloader) & transisi navigasi antar halaman */
const pageLoader = document.querySelector('[data-loader]');
const navProgress = document.querySelector('[data-nav-progress]');

if (pageLoader) {
    const dismissLoader = () => {
        if (pageLoader.classList.contains('is-loaded')) return;
        pageLoader.classList.add('is-loaded');
        sessionStorage.setItem('bpr_loaded', '1');
        setTimeout(() => {
            pageLoader.style.display = 'none';
        }, 460);
    };

    if (reduceMotion || navigator.webdriver) {
        pageLoader.style.display = 'none';
    } else {
        const firstVisit = !sessionStorage.getItem('bpr_loaded');
        const delay = firstVisit ? 320 : 120;
        setTimeout(dismissLoader, delay);
    }

    // Pastikan tombol Back/Forward browser tidak memunculkan loader yang tertutup
    window.addEventListener('pageshow', (e) => {
        if (e.persisted) {
            pageLoader.style.display = 'none';
        }
    });
}

/* Top progress bar + kemunculan halus saat klik link internal */
if (navProgress && !reduceMotion) {
    document.addEventListener('click', (e) => {
        const link = e.target.closest('a[href]');
        if (!link) return;
        if (link.target === '_blank' || link.hasAttribute('download') || e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;

        const href = link.getAttribute('href') || '';
        if (!href || href.startsWith('#') || href.startsWith('mailto:') || href.startsWith('tel:') || href.startsWith('javascript:')) return;

        try {
            const url = new URL(link.href, window.location.origin);
            if (url.origin !== window.location.origin) return;
            if (url.pathname === window.location.pathname && url.search === window.location.search && url.hash) return;

            navProgress.style.transform = 'scaleX(0.75)';
        } catch {
            // Abaikan URL tidak valid
        }
    });
}

/* Modal pratinjau PDF Laporan Keuangan */
const pdfModal = document.querySelector('[data-pdf-modal]');
if (pdfModal) {
    const frame = pdfModal.querySelector('[data-pdf-frame]');
    const titleEl = pdfModal.querySelector('[data-pdf-modal-title]');
    const downloadEl = pdfModal.querySelector('[data-pdf-modal-download]');
    const closeBtn = pdfModal.querySelector('[data-pdf-close]');

    document.querySelectorAll('[data-pdf-preview]').forEach((btn) => {
        btn.addEventListener('click', () => {
            if (frame) frame.src = btn.dataset.pdfPreview || '';
            if (titleEl) titleEl.textContent = btn.dataset.pdfTitle || 'Pratinjau Laporan PDF';
            if (downloadEl) downloadEl.href = btn.dataset.pdfDownload || btn.dataset.pdfPreview || '#';
            pdfModal.showModal();
        });
    });

    const closeModal = () => {
        pdfModal.close();
        if (frame) frame.src = 'about:blank';
    };

    closeBtn?.addEventListener('click', closeModal);
    pdfModal.addEventListener('click', (e) => {
        if (e.target === pdfModal) closeModal();
    });
}

/* Tab & Filter Panel Admin */
document.querySelectorAll('[data-admin-tabs]').forEach((root) => {
    const btns = [...root.querySelectorAll('[data-admin-tab-btn]')];
    const panels = [...root.querySelectorAll('[data-admin-tab-panel]')];

    const activate = (key) => {
        btns.forEach((b) => {
            const on = b.dataset.adminTabBtn === key;
            b.setAttribute('aria-selected', String(on));
            b.className = `inline-flex cursor-pointer items-center gap-2 border px-4 py-2.5 text-xs font-bold transition-colors ${
                on
                    ? 'border-brand-dark bg-brand-dark text-white'
                    : 'border-line bg-white text-ink hover:border-brand hover:text-brand-dark'
            }`;
        });
        panels.forEach((p) => {
            p.classList.toggle('hidden', p.dataset.adminTabPanel !== key);
        });
    };

    const hashKey = window.location.hash.replace('#', '');
    if (hashKey && panels.some((p) => p.dataset.adminTabPanel === hashKey)) {
        activate(hashKey);
    }

    btns.forEach((b) => {
        b.addEventListener('click', () => {
            const key = b.dataset.adminTabBtn;
            activate(key);
            const url = new URL(window.location.href);
            url.searchParams.set('tab', key);
            url.hash = '';
            window.history.replaceState({}, '', url);
        });
    });
});

document.querySelectorAll('[data-filter-scope]').forEach((scope) => {
    const btns = [...scope.querySelectorAll('[data-filter-btn]')];
    const items = [...scope.querySelectorAll('[data-filter-item]')];
    btns.forEach((b) => {
        b.addEventListener('click', () => {
            const val = b.dataset.filterBtn;
            btns.forEach((x) => {
                const on = x === b;
                x.className = `cursor-pointer border px-3.5 py-2 text-xs font-bold ${
                    on
                        ? 'border-brand-dark bg-brand-dark text-white'
                        : 'border-line bg-soft text-ink hover:border-brand'
                }`;
            });
            items.forEach((el) => {
                el.classList.toggle('hidden', val !== 'all' && el.dataset.filterItem !== val);
            });
        });
    });
});

/* Pemisah Bagian Halaman Tentang Kami (Dropdown & Sub-navigasi) */
const aboutPanels = [...document.querySelectorAll('[data-about-panel]')];
if (aboutPanels.length) {
    const aboutSelect = document.querySelector('[data-about-select]');
    const aboutBtns = [...document.querySelectorAll('[data-about-btn]')];

    const switchAbout = (key) => {
        if (!aboutPanels.some((p) => p.dataset.aboutPanel === key)) return;
        aboutPanels.forEach((p) => {
            p.classList.toggle('hidden', p.dataset.aboutPanel !== key);
        });
        aboutBtns.forEach((b) => {
            const on = b.dataset.aboutBtn === key;
            b.className = `border px-3.5 py-2 text-xs font-bold transition-colors ${
                on
                    ? 'border-brand-dark bg-brand-dark text-white'
                    : 'border-line bg-white text-ink hover:border-brand hover:text-brand-dark'
            }`;
        });
        if (aboutSelect) aboutSelect.value = key;
        const url = new URL(window.location.href);
        url.searchParams.set('bagian', key);
        url.hash = '';
        window.history.replaceState({}, '', url);
    };

    const hashSection = window.location.hash.replace('#', '');
    if (hashSection && aboutPanels.some((p) => p.dataset.aboutPanel === hashSection)) {
        switchAbout(hashSection);
    }

    aboutSelect?.addEventListener('change', (e) => switchAbout(e.target.value));
    aboutBtns.forEach((b) => {
        b.addEventListener('click', (e) => {
            e.preventDefault();
            switchAbout(b.dataset.aboutBtn);
        });
    });
    document.querySelectorAll('[data-about-nav]').forEach((navLink) => {
        navLink.addEventListener('click', (e) => {
            if (window.location.pathname === '/tentang-kami') {
                e.preventDefault();
                switchAbout(navLink.dataset.aboutNav);
            }
        });
    });
}
