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

//背景アニメーションを実装
backgroundAnimation.implement();

//ヒーローヘッダースライダーを実装
heroHeaderSlider.implement();
//ヒーローヘッダースライダーの自動再生を一旦停止
heroHeaderSlider.stop();

//ホームページのブログセクションスライダーを実装
homePageBlogSlider.implement();

window.addEventListener( 'load', () => {
  //スクロールエフェクトを実装
  scrollEffects();

  //ヒーローヘッダースライダーの自動再生を再開
  heroHeaderSlider.play();

  //ローディング画面を閉じる
  loadingScreen.close();

  //オープニングアニメーションを再生
  openingAnimation.play();
}, { once: true } );