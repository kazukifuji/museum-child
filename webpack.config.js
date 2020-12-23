module.exports = {
  mode: 'production',
  devtool: 'source-map',
  entry: './src/js/index.js',
  output: {
    filename: 'script.js',
    path: __dirname + '/dist/js'
  },
  cache: true,
  watch: false,
  watchOptions: {
    ignored: [ '/node_modules/**', '/dist/**' ]
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        exclude: /node_modules/,
        use: {
          loader: 'babel-loader',
          options: {
            presets: [
              [
                '@babel/preset-env',
                {
                  useBuiltIns: 'usage',
                  corejs: 3,
                  debug: true
                }
              ]
            ]
          }
        }
      },
      
      {
        test: /\.css$/,
        use: [
          "style-loader",
          {
            loader: "css-loader",
            options: { url: false }
          }
        ]
      }
    ],
  }
};