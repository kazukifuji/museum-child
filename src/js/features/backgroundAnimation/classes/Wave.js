import * as PIXI from 'pixi.js';
import SimplexNoise from 'simplex-noise';
import AnimationObject from './AnimationObject';

let count = 0;

//ウェーブ
export default class Wave extends AnimationObject {
  constructor( {
    pixiApp = null,
    pixiTexture = null,
    posX = 0,
    posY = 0,
    tint = 0x000000,
    alpha = 1,
    wDire = 'right',
    wLengLevel = 5,
    wMaxAmp = 50,
    wSpeed = 1,
    seed = 0,
  } = {} ) {
    //テスクチャのポイントを作成
    const pointNum  = 50;
    const pointSpace = pixiTexture.width / pointNum;
    const points = new Array();
    for ( let i = 0; i <= pointNum; i++ ) {
      points.push( new PIXI.Point( i * pointSpace, 0 ) );
    }

    super( new PIXI.SimpleRope( pixiTexture, points ) );

    this.pixiDisObj.x = posX;
    this.pixiDisObj.y = posY;
    this.pixiDisObj.tint = tint;
    this.pixiDisObj.alpha = alpha;
    this.wDire = wDire;
    this.wLengLevel = wLengLevel;
    this.wMaxAmp = wMaxAmp;
    this.wSpeeed = wSpeed;
    this._pixiApp = pixiApp;
    this._count = count;
    this._points = points;
    this._simplex = new SimplexNoise(seed);

    //リサイズイベントを追加
    let timer;
    window.addEventListener( 'resize', () => {
      if (timer) return;
      timer = setTimeout( () => {
        timer = 0;
        this.resize();
      }, 500 );
    } );

    this.resize();
    this.movePoints();
    count++;
  }

  //ポイントを動かす
  movePoints() {
    const pointNum = this._points.length;
    const time = Date.now() + ( this._count * 75 );
    const delay = ( this.wDire === 'right' ) ? 0.0025 : -0.0025;

    for ( let i = 0; i < pointNum; i++ ) {
      const j = ( this.pixiDisObj.scale.x < 1 ) ? i * this.pixiDisObj.scale.x : i;
      
      const paramX = 1 + (0.02 * j); //ここの数値が大きければ後半波がずれる
      const paramY = ( ( ( time / 250000 ) * this.wSpeeed ) - ( delay * j ) ) * this.wLengLevel;
      this._points[i].y = this.wMaxAmp * this._simplex.noise2D( paramX, paramY ) + this.wMaxAmp;
    }
  }
  
  //リサイズ
  resize() {
    this.pixiDisObj.scale.set( this._pixiApp.view.clientWidth / this.pixiDisObj.texture.width, 1 );
  }

  //更新
  update() {
    this.movePoints();
  }
} 