import Swiper from 'swiper/bundle';
import 'swiper/swiper-bundle.css';

//ヒーローヘッダーのスライダーを実装
export default {
  //初期設定
  init: function() {
    this.element = document.querySelector('#heroHeader .swiper-container');
    if ( !this.element ) return;

    this.swiper = new Swiper( this.element, {
      autoplay: {
        delay: 8000,
        disableOnInteraction: false,
      },
      effect: 'fade',
      on: {
        init: function(swiper) {
          swiper.autoplay.stop();
        },
        slideChangeTransitionStart: function(swiper) {
          const activeSlideImg = swiper.slides[ swiper.activeIndex ].children[0];
          const previousSlideImg = swiper.slides[ swiper.previousIndex ].children[0];
          activeSlideImg.style.animation = 'zoom-out 10s cubic-bezier(0.5, 1, 0.89, 1) both';
          setTimeout( () => {
            previousSlideImg.style.animation = '';
          }, swiper.params.speed );
        },
        paginationUpdate: function(swiper, paginationEl) {
          paginationEl.style.pointerEvents = 'none';
          setTimeout( () => {
            paginationEl.style.pointerEvents = '';
          }, swiper.params.speed );
        },
      },
      pagination: {
        el: '.swiper-pagination',
        clickable: true,
        renderBullet: function( index, className ) {
          //pathタグのd属性値
          const dValue = ( index % 2 === 0 ) ?
            'm 12.406061,20.506419 c 0.0947,-1.325816 0.18215,-2.419215 0.19415,-2.429773 0.0906,-0.07968 2.661819,-0.493898 3.908239,-0.6296 0.86656,-0.09435 3.61621,-0.09284 4.2857,0.0024 1.25301,0.17815 2.45806,0.624401 3.0691,1.136532 0.80744,0.676747 1.13529,1.42002 1.13507,2.573337 -2.1e-4,1.136958 -0.22076,1.765045 -0.85068,2.422547 -1.68875,1.762678 -5.1503,1.886436 -9.715499,0.347351 -1.50159,-0.506239 -2.18109,-0.788956 -2.19059,-0.911431 -0.004,-0.05541 0.0699,-1.185499 0.16451,-2.511316 z M 5.0523905,19.801024 c 0.0971,-0.427259 0.33289,-0.81856 0.70068,-1.162791 0.9682301,-0.906161 2.4467401,-1.1916 4.3658605,-0.842861 0.43874,0.07972 0.81398,0.162131 0.83386,0.183124 0.0478,0.05043 -0.29173,5.000662 -0.34676,5.055716 -0.0234,0.02342 -0.58559,0.04224 -1.2493004,0.04183 -1.09399,-6.77e-4 -1.24903,-0.01226 -1.65927,-0.12398 C 5.8430405,22.447064 4.7476705,21.14217 5.0524005,19.801025 Z' :
            'M 12.796151,6.6585949 C 18.263,4.4976069 22.40101,4.4461839 24.2452,6.5163169 24.79049,7.1284109 25,7.7835729 25,8.8765009 c 0,0.946369 -0.2428,1.6128921 -0.80759,2.2169581 -0.7063,0.755399 -1.7575,1.204771 -3.38224,1.445853 -0.77316,0.114725 -3.10372,0.130125 -4.11539,0.02719 -1.40705,-0.143158 -3.957939,-0.553239 -4.068509,-0.654052 -0.027,-0.02457 -0.11482,-1.010142 -0.19525,-2.1901531 -0.0804,-1.18001 -0.15973,-2.301272 -0.17617,-2.491693 l -0.0299,-0.346219 z m -7.7436505,2.649329 c 0.30418,-1.336707 1.8858501,-2.349264 3.7629701,-2.408985 0.73798,-0.02348 1.6712504,0.01006 1.7550304,0.06308 0.0625,0.03954 0.11183,0.545247 0.24802,2.542424 0.11317,1.6594881 0.15194,2.5042401 0.11595,2.5264911 -0.0298,0.01839 -0.36893,0.09036 -0.75379,0.159932 -0.9799404,0.177161 -2.2656204,0.180018 -2.8680404,0.0064 C 5.6709305,11.724046 4.7659605,10.567141 5.0525005,9.3079539 Z';

          return '<svg class="' + className + '" xmlns="http://www.w3.org/2000/svg" version="1.1" width="30" height="30" viewBox="0 0 30 30">' +
                   '<path d="' + dValue + '"></path>' +
                 '</svg>';
        },
      },
      simulateTouch : false,
      speed: 2000,
    } );
  },

  //スライダーの自動再生を開始
  play: function() {
    if ( !this.element ) return;
    this.swiper.autoplay.start();
    this.swiper.slides[0].style.animation = 'zoom-out 10s cubic-bezier(0.5, 1, 0.89, 1) both';
  },
}