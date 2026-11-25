let menu_button = document.getElementById('menu-btn');
let fullscreen_menu = document.querySelector('[data-menu]');

menu_button.addEventListener('click', () =>{
    fullscreen_menu.classList.toggle('is-active');
    fullscreen_menu.classList.toggle('is-open');
});

fullscreen_menu.querySelectorAll('[data-menu-link]').forEach((link) => {
    link.addEventListener('click', () => {
        fullscreen_menu.classList.remove('is-active', 'is-open');
    });
});

const titleHeaders = document.querySelectorAll('[data-reveal]');

if (titleHeaders.length > 0) {
    const titleObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            entry.target.classList.toggle('is-visible', entry.isIntersecting);
        });
    }, {
        threshold: 0.25
    });

    titleHeaders.forEach((header) => {
        titleObserver.observe(header);
    });
}

let language_btn = document.getElementById('language-btn');
let btn_language__selector = document.getElementById('btn-language--selector');

language_btn.addEventListener('click', () => {

    btn_language__selector.classList.toggle('is-active');

});

