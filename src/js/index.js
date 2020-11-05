import backgroundAnimation from './features/backgroundAnimation/main';
import heroHeaderSlider from './features/heroHeaderSlider';

//IE判定
if (!document.documentMode && !document.uniqueID) {
  //ヒーローヘッダーのスライダー実装する初期設定
  heroHeaderSlider.init();
}

window.addEventListener( 'load', () => {
  //背景アニメーションを構築
  backgroundAnimation();

  //IE判定
  if (!document.documentMode && !document.uniqueID) {
    //ヒーローヘッダーのスライダーの自動再生を開始
    heroHeaderSlider.play();
  }
}, { once: true } );