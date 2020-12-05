import loadingScreen from './features/loadingScreen';
import openingAnimation from './features/openingAnimation';
import backgroundAnimation from './features/backgroundAnimation/main';
import scrollEffects from './features/scrollEffects';
import heroHeaderSlider from './features/heroHeaderSlider';
import homePageBlogSlider from './features/homePageBlogSlider';

//ローディング画面の初期設定
loadingScreen.init();

//オープニングアニメーションの初期設定
openingAnimation.init();

//ヒーローヘッダーのスライダー実装する初期設定
heroHeaderSlider.init();

window.addEventListener( 'load', () => {
  //背景アニメーションを構築
  backgroundAnimation();

  //スクロールエフェクトを実装
  scrollEffects();

  //ヒーローヘッダーのスライダーの自動再生を開始
  heroHeaderSlider.play();

  //ホームページのブログセクションのスライダーを実装
  homePageBlogSlider();

  //ローディング画面を閉じる
  loadingScreen.close();

  //オープニングアニメーションを再生
  openingAnimation.play();
}, { once: true } );