import backgroundAnimation from './features/backgroundAnimation/main';
import heroHeaderSlider from './features/heroHeaderSlider';
import homePageBlogSlider from './features/homePageBlogSlider';
import loadingScreen from './features/loadingScreen';
import openingAnimation from './features/openingAnimation';
import scrollEffects from './features/scrollEffects';

//ローディング画面の初期設定
loadingScreen.init();

//オープニングアニメーションの初期設定
openingAnimation.init();

//ヒーローヘッダーのスライダー実装する初期設定
heroHeaderSlider.init();

//背景アニメーションを実装
backgroundAnimation.implement();

window.addEventListener( 'load', () => {
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