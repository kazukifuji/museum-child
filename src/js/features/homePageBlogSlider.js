import Swiper from 'swiper/dist/js/swiper.js';
import 'swiper/dist/css/swiper.min.css';

//ホームページのブログセクションのスライダーを実装
export default () => {
  const containerElem = document.querySelector('#homePageContents > .home-page-contents__blogs > .swiper-container');
  if ( !containerElem ) return;

  const swiper = new Swiper( containerElem, {
    breakpoints: {
      479: {
        slidesPerView: 1.5,
        spaceBetween: 10,
      },
      895: {
        slidesPerView: 2,
        spaceBetween: 30,
      }
    },
    centeredSlides: true,
    coverflowEffect: {
      rotate: 40,
      slideShadows: false,
    },
    effect: 'coverflow',
    loop: true,
    loopAdditionalSlides: 1,
    on: {
      resize: () => {
        slidePostImage.resize();
      },
    },
    pagination: {
      el: '#homePageContents > .home-page-contents__blogs > .swiper-pagination',
      clickable: true,
    },
    slidesPerView: 2.5,
    spaceBetween: 50,
    speed: 500,
  } );

  const slidePostImage = {
    elements: swiper.el.querySelectorAll('.swiper-slide .swiper-slide-post-thumbnail > img'),
    resize: function() { objectFitPolyfill( this.elements ) },
  };

  slidePostImage.resize();
}