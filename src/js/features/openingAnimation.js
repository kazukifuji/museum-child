import anime from 'animejs';

//オープニングアニメーションを実装
export default {
  //初期設定
  init: function() {
    //ホームページでなければ処理を終了
    if ( !isHome() ) return;

    //ヒーローヘッダー要素
    this.heroHeader = document.getElementById('heroHeader');
    this.heroHeader.style.pointerEvents = 'none';

    //アニメーションに使用される要素
    this.elements = {
      //グリッドライン
      gridLineSVG: this.heroHeader.querySelector('.hero-header__bg-grid-line-svg'),
      //グリッドラインのパス
      gridLinePaths: this.heroHeader.querySelectorAll('.hero-header__bg-grid-line-svg > path'),
      //見出しのロゴ
      headingLogo: this.heroHeader.querySelector('.hero-header__heading-logo'),
      //見出しのキャッチコピー
      headingCatchCopy: this.heroHeader.querySelector('.hero-header__heading-catch-copy'),
      //スライダーのページネーション
      sliderPagination: this.heroHeader.querySelector('.swiper-pagination'),
    };

    //各要素に初期スタイルを設定
    anime.set( this.elements.gridLineSVG, { opacity: 1 } );
    anime.set( this.elements.gridLinePaths, {
      strokeDashoffset: anime.setDashoffset,
    } );
    anime.set( [
      this.elements.headingLogo,
      this.elements.headingCatchCopy,
      this.elements.sliderPagination,
    ], { opacity: 0 } );

    //アニメーションのタイムライン要素
    this.timeline = anime.timeline({
      autoplay: false,
    })
    .add({
      targets: this.elements.gridLinePaths,
      duration: 1000,
      easing: 'easeInOutSine',
      delay: anime.stagger( 200, { start: 1000 } ),
      strokeDashoffset: [ anime.setDashoffset, 0 ],
    })
    .add({
      targets: this.elements.gridLineSVG,
      duration: 1000,
      easing: 'linear',
      opacity: 0.25,
    }, '+=100')
    .add({
      targets: this.elements.headingLogo,
      duration: 2000,
      opacity: { easing: 'linear', value: 1 },
      scale: { easing: 'easeOutExpo', value: [ 2, 1 ] },
    }, '-=1000')
    .add({
      targets: [ this.elements.headingCatchCopy, this.elements.sliderPagination ],
      duration: 500,
      easing: 'linear',
      delay: anime.stagger( 200 ),
      opacity: 1,
    }, '-=1000');

    //アニメーション終了後、ポインターイベントを有効にする
    this.timeline.finished.then( () => {
      this.heroHeader.style.pointerEvents = 'auto';
    } );
  },

  //再生
  play: function() {
    if ( isHome() ) this.timeline.play();
  },
}

//ホームページ判定
function isHome() {
  return ( document.body.classList.contains('home') ) ? true : false;
}