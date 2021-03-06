//IntersectionObserverポリフィル
import IntersectionObserverPolyfill from 'intersection-observer';

const target = {
  //機能を適応させる要素（配列）
  elements: [],
  //ターゲット要素を追加
  add: function( selector = '' ) {
    this.elements = this.elements.concat( [].slice.call( document.querySelectorAll( selector ) ) );
  },
};

/*-----------------------
ホームページ
-----------------------*/
//見出し
target.add('#homePageContents .home-page-contents__heading');
//プロフィール画像
target.add('#homePageContents .home-page-contents__profile-avatar');
//プロフィール情報
target.add('#homePageContents .home-page-contents__profile-description');
//投稿リストアイテム
target.add('#homePageContents .home-page-contents__works-list-item');
//ブログスライダー
target.add('#homePageContents .home-page-contents__blogs-swiper-container');

//IntersectionObserverのオプション
const options = {
  root: null,
  rootMargin: '0px 0px -25% 0px',
  threshold: 0,
}

//IntersectionObserverを作成
const observer = new IntersectionObserver( entries => {
  entries.forEach( entry => {
    if ( entry.isIntersecting ) {
      if ( entry.target.classList.contains('observe-target') ) {
        entry.target.classList.add('-trigger');
      }
      observer.unobserve( entry.target );

    } else {
      //画面外でも、すでにターゲットが通過している場合は監視対象から除外
      if ( entry.boundingClientRect.top < entry.rootBounds.height ) {
        observer.unobserve( entry.target );
      } else {
        entry.target.classList.add('observe-target');
      }
    }
  } );
}, options );

export default {
  //スクロールエフェクトを実装
  implement: () => {
    //対象要素の監視を開始
    target.elements.forEach( target => observer.observe( target ) );
  },
}