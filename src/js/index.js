import loadingScreen from './features/loadingScreen';
import backgroundAnimation from './features/backgroundAnimation/main';
import heroHeaderSlider from './features/heroHeaderSlider';

//ローディング画面の初期設定
loadingScreen.init();

//ヒーローヘッダーのスライダー実装する初期設定
heroHeaderSlider.init();

window.addEventListener( 'load', () => {
  //背景アニメーションを構築
  backgroundAnimation();

  //ヒーローヘッダーのスライダーの自動再生を開始
  heroHeaderSlider.play();

  //ローディング画面を閉じる
  loadingScreen.close();
}, { once: true } );