import anime from 'animejs';

let heroHeader, animeElems, timeline;

//ホームページ判定
if ( isHome() ) {
  //ヒーローヘッダー要素
  heroHeader = document.getElementById('heroHeader');
  //ポインターイベントを一旦無効化
  heroHeader.style.pointerEvents = 'none';

  //アニメーションに使用される要素
  animeElems = {
    //グリッドライン
    gridLineSVG:　heroHeader.querySelector('.hero-header__bg-grid-line-svg'),
    //グリッドラインのパス
    gridLinePaths:　heroHeader.querySelectorAll('.hero-header__bg-grid-line-svg > path'),
    //見出しのロゴ
    headingLogo:　heroHeader.querySelector('.hero-header__heading-logo'),
    //見出しのキャッチコピー
    headingCatchCopy:　heroHeader.querySelector('.hero-header__heading-catch-copy'),
    //スライダーのページネーション
    sliderPagination:　heroHeader.querySelector('.swiper-pagination'),
  };

  //初期スタイルを設定
  anime.set( animeElems.gridLineSVG, { opacity: 1 } );
  anime.set( animeElems.gridLinePaths, {
    strokeDashoffset: anime.setDashoffset,
  } );
  anime.set( [
    animeElems.headingLogo,
    animeElems.headingCatchCopy,
    animeElems.sliderPagination,
  ], { opacity: 0 } );

  //アニメーションのタイムラインオブジェクト
  timeline = anime.timeline({
    autoplay: false,
  })
  .add({
    targets: animeElems.gridLinePaths,
    duration: 1000,
    easing: 'easeInOutSine',
    delay: anime.stagger( 200, { start: 1000 } ),
    strokeDashoffset: [ anime.setDashoffset, 0 ],
  })
  .add({
    targets: animeElems.gridLineSVG,
    duration: 1000,
    easing: 'linear',
    opacity: 0.25,
  }, '+=100')
  .add({
    targets: animeElems.headingLogo,
    duration: 2000,
    opacity: { easing: 'linear', value: 1 },
    scale: { easing: 'easeOutExpo', value: [ 2, 1 ] },
  }, '-=1000')
  .add({
    targets: [ animeElems.headingCatchCopy, animeElems.sliderPagination ],
    duration: 500,
    easing: 'linear',
    delay: anime.stagger( 200 ),
    opacity: 1,
  }, '-=1000');

  //アニメーション終了後、ポインターイベントを有効にする
  timeline.finished.then( () => {
    heroHeader.style.pointerEvents = 'auto';
  } );
}

export default {
  //オープニングアニメーションを再生
  play: function() {
    if ( isHome() ) timeline.play();
  },
}

//ホームページ判定
function isHome() {
  return ( document.body.classList.contains('home') ) ? true : false;
}