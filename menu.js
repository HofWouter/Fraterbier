let menu_button = document.getElementById('menu-btn');
let fullscreen_menu = document.querySelector('.menu');

let newsletterLink = document.getElementById('newsletter-link');

if (newsletterLink) {
    newsletterLink.addEventListener('click', () => {
        fullscreen_menu.classList.toggle('is-active');
        fullscreen_menu.classList.toggle('is-open');
    });
}

menu_button.addEventListener('click', () =>{
    fullscreen_menu.classList.toggle('is-active');
    fullscreen_menu.classList.toggle('is-open');
});

const titleHeaders = document.querySelectorAll('.section__title h2, .header .header__wrapper h1');

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

/////

const submitNewsletter = document.getElementById('submitNewsletter');

submitNewsletter.addEventListener('submit', async (e) => {
    e.preventDefault();

    const mailInput = document.getElementById('email');

    const data = {
        Mail : mailInput
    };

    console.log(data);
    
    try{
      const response = await fetch(`${supabaseURL}/rest/v1/Nieuwsbrief`, {
            method: "POST",
            headers: {
                "apikey": supabaseANON,
                "Authorization": `Bearer ${supabaseANON}`,
                "Content-Type": "application/json"
            },
            body: JSON.stringify(data)
      });

      if (response.ok){
        console.log('Data is verzonden naar de server!');
      }
      else{
        console.log('Data kan niet worden verzonden!');
      }

    }
    catch{
      console.log('Er gaat iets mis met het verzenden naar de server!');
    }

});

/////

let language_btn = document.getElementById('language-btn');
let btn_language__selector = document.getElementById('btn-language--selector');

language_btn.addEventListener('click', () => {

    console.log('Taal wijzigen');
    btn_language__selector.classList.toggle('is-active');

});

