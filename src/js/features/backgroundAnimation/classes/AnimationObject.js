//アニメーションオブジェクト（抽象クラス）
export default class AnimationObject {
  constructor( pixiDisObj ) {
    if ( typeof pixiDisObj === 'undefined' ) {
      throw new Error('引数「pixiDisObj」が指定されていません。');
    }

    //PIXIJSの表示オブジェクト
    this.pixiDisObj = pixiDisObj;

    this.flags = {
      //更新フラグ
      update: true,
      //存在フラグ
      exist: true,
    };
  }

  //更新
  update() {
    throw new Error('メソッド「update」が定義されていません。');
  }
}  