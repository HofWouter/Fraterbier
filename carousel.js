let currentIndex = 0;
let currentStyle = document.getElementById('onze-bieren-container');

const bierButtons = Array.from(document.querySelectorAll('.bier__btn'));
const bierContainers = Array.from(document.querySelectorAll('.bier'));
const totalSlides = bierContainers.length || 4;

const carouselImages = document.querySelector('.carousel__images');
const carouselLabels = document.querySelector('.carousel__labels');


function updateBeerFade() {
  bierContainers.forEach((container, idx) => {
    container.classList.toggle('is-active', idx === currentIndex);
  });
  bierButtons.forEach((button, idx) => {
    button.classList.toggle('is-active', idx === currentIndex);
  });
}

function moveSlide(direction) {
  // Rondlopen: -1 vanaf 0 gaat naar laatste, +1 vanaf laatste gaat naar eerste.
  currentIndex = (currentIndex + direction + totalSlides) % totalSlides;

  const offset = -currentIndex * 100;
  if (carouselImages) carouselImages.style.transform = `translateX(${offset}%)`;
  if (carouselLabels) carouselLabels.style.transform = `translateX(${offset}%)`;

  updateBeerFade();
  changeStyle();
}

function changeStyle() {
  if (!currentStyle) return;
  
  // Lees bierkleuren uit data-attribute
  const colorData = currentStyle.getAttribute('data-beer-colors');
  let beerColors = [];
  try {
    beerColors = colorData ? JSON.parse(colorData) : [];
  } catch (e) {
    beerColors = [];
  }

  const entry = beerColors[currentIndex];
  if (!entry) return;

  // entry may be a string (legacy) or an object {bg, text}
  if (typeof entry === 'string') {
    currentStyle.style.backgroundColor = entry;
  } else {
    if (entry.bg) currentStyle.style.backgroundColor = entry.bg;
    if (entry.text) currentStyle.style.color = entry.text;
  }
}

// Initial state (index 0) so the correct bier fades in on first load.
updateBeerFade();
changeStyle();