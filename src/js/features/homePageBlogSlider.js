import Swiper from 'swiper/dist/js/swiper.js';
import 'swiper/dist/css/swiper.min.css';

//ホームページのブログセクションのスワイパーコンテナー要素
const swiperContainer = document.querySelector('#homePageContents > .home-page-contents__blogs > .swiper-container');

export default {
  //ホームページのブログセクションスライダーを実装
  implement: () => {
    if ( !swiperContainer ) return;
    
    //スワイパーインスタンスを生成
    const swiper = new Swiper( swiperContainer, {
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
  
    //スライダー内の投稿画像
    const slidePostImage = {
      elements: swiper.el.querySelectorAll('.swiper-slide .swiper-slide-post-thumbnail > img'),
      resize: function() { objectFitPolyfill( this.elements ) },
    };
  
    //スライダー内の投稿画像をリサイズ
    slidePostImage.resize();
  },
}