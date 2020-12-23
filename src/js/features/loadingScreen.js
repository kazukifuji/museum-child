//ローディングスクリーン要素
const loadingScreen = document.getElementById('loadingScreen');
//ローディングアニメーション要素
const loadingAnimation = loadingScreen.querySelector('.loader-ellips');

export default {
  //ローディングスクリーンを閉じる
  close: () => {
    //それぞれの要素にクラスを追加
    loadingScreen.classList.add('-close');
    loadingAnimation.classList.add('-stop');
  },
}