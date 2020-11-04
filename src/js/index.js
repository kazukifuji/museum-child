import backgroundAnimation from './features/backgroundAnimation/main';

window.addEventListener( 'load', () => {
  //背景アニメーションを構築
  backgroundAnimation();
}, { once: true } );