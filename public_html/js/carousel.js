let currentIndex = 0;
const container = document.getElementById('onze-bieren-container');

const bierButtons = Array.from(document.querySelectorAll('[data-beer-btn]'));
const bierContainers = Array.from(document.querySelectorAll('[data-beer]'));
const totalSlides = bierContainers.length;

const carouselImages = document.querySelector('[data-carousel-images]');
const carouselLabels = document.querySelector('[data-carousel-labels]');

// Bierkleuren ({bg, text} per bier) één keer inlezen uit het data-attribute
const beerColors = (() => {
  try {
    return JSON.parse(container?.dataset.beerColors || '[]');
  } catch (e) {
    return [];
  }
})();

function updateBeerFade() {
  bierContainers.forEach((el, idx) => el.classList.toggle('is-active', idx === currentIndex));
  bierButtons.forEach((el, idx) => el.classList.toggle('is-active', idx === currentIndex));
}

function changeStyle() {
  const colors = beerColors[currentIndex];
  if (!container || !colors) return;

  if (colors.bg) container.style.backgroundColor = colors.bg;
  if (colors.text) container.style.color = colors.text;
}

function moveSlide(direction) {
  if (!totalSlides) return;

  // Rondlopen: -1 vanaf 0 gaat naar laatste, +1 vanaf laatste gaat naar eerste.
  currentIndex = (currentIndex + direction + totalSlides) % totalSlides;

  const offset = -currentIndex * 100;
  if (carouselImages) carouselImages.style.transform = `translateX(${offset}%)`;
  if (carouselLabels) carouselLabels.style.transform = `translateX(${offset}%)`;

  updateBeerFade();
  changeStyle();
}

// Beginstand (index 0), zodat het juiste bier en de juiste kleuren direct zichtbaar zijn.
updateBeerFade();
changeStyle();

// Swipen op de fotocarousel: naar links = volgend bier, naar rechts = vorig bier.
// Alleen horizontale vegen tellen; verticaal scrollen van de pagina blijft gewoon werken.
(function enableSwipe() {
  const area = carouselImages ? carouselImages.parentElement : null;
  if (!area || totalSlides < 2) return;

  const THRESHOLD = 40; // minimale veeglengte in px
  let startX = null;
  let startY = null;

  area.style.touchAction = 'pan-y';

  area.addEventListener('pointerdown', (e) => {
    if (e.pointerType === 'mouse' && e.button !== 0) return;
    startX = e.clientX;
    startY = e.clientY;
    // Ook een pointerup buiten de carousel (muis losgelaten ernaast) komt hier binnen
    area.setPointerCapture(e.pointerId);
  });

  const end = (e) => {
    if (startX === null) return;
    const dx = e.clientX - startX;
    const dy = e.clientY - startY;
    startX = startY = null;

    if (Math.abs(dx) >= THRESHOLD && Math.abs(dx) > Math.abs(dy)) {
      moveSlide(dx < 0 ? 1 : -1);
    }
  };

  area.addEventListener('pointerup', end);
  area.addEventListener('pointercancel', () => { startX = startY = null; });

  // Voorkom dat de browser de afbeelding gaat "slepen" met de muis
  area.addEventListener('dragstart', (e) => e.preventDefault());
})();
