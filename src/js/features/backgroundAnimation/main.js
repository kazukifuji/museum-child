import * as PIXI from 'pixi.js';
import Wave from './classes/Wave';

const animationObjects = [];

const app = new PIXI.Application({
  autoStart: false,
  resizeTo: document.querySelector('#backgroundCanvasWrap'),
  transparent: true,
  view: document.querySelector('#backgroundCanvas'),
});

//ラインウェーブアニメーションオブジェクトを作成
function createLineWaves() {
  const num = 50;
  const texture = ( () => {
    const graphics = new PIXI.Graphics()
    .lineStyle( 1, 0xFFFFFF, 1, 0 )
    .moveTo( 0, 0 )
    .lineTo( 1000, 0 );
    return app.renderer.generateTexture( graphics );
  } )();
  const container = new PIXI.Container();
  const seed = Math.random();

  for ( let i = 0; i < num; i++ ) {
    const lineWave = new Wave({
      pixiApp: app,
      pixiTexture: texture,
      tint: 0xDDDDDD,
      alpha: 0.3,
      wDire: 'left',
      wLengLevel: 8,
      wMaxAmp: 80,
      wSpeed: 4,
      seed: seed,
    });

    container.addChild( lineWave.pixiDisObj );
    animationObjects.push( lineWave );
  }

  return container;
}

//背景アニメーションを実装
export default () => {

  //ラインウェーブを作成
  const lineWaves = createLineWaves();

  //ステージに追加
  app.stage.addChild( lineWaves );

  //ループ処理
  app.ticker.add( () => {
    const aniObjNum = animationObjects.length;

    for ( let i = 0; i < aniObjNum; i++ ) {
      if ( animationObjects[i].flags.exist ) {
        if ( animationObjects[i].flags.update ) animationObjects[i].update();
      } else {
        animationObjects[i].pixiDisObj.destroy();
        animationObjects.splice(i, 1);
      }
    }
  } );

  //アニメーションを開始
  app.start();
} 