//ローディング画面を操作
export default {
  //初期設定
  init: function() {
    //ローディング画面要素
    this.element = document.getElementById('loadingScreen');
    //ローディングアニメーション要素
    this.animationElem = this.element.querySelector('.loader-ellips');
  },

  //ローディング画面を閉じる
  close: function() {
    this.element.classList.add('-close');
    this.animationElem.classList.add('-stop');
  }
}