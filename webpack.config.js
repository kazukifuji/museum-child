const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');

module.exports = {
  mode: 'production',
  devtool: 'source-map',
  entry: {
    main: path.resolve( __dirname, 'src/js/index.js' ),
  },
  output: {
    path: path.resolve( __dirname, 'dist/' ),
    filename: 'js/script.js',
  },
  resolve: {
    modules: [ __dirname, 'node_modules' ]
  },
  cache: true,
  watch: false,
  watchOptions: {
    ignored: [ './node_modules/**', './dist/**' ]
  },
  module: {
    rules: [
      {
        test: /\.css$/,
        use: [ 'style-loader', 'css-loader' ]
      },

      {
        test: /\.scss$/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
            options: {
              publicPath: '../'
            }
          },
          {
            loader: 'css-loader',
            options: {
              importLoaders: 2
            }
          },
          {
            loader: 'postcss-loader',
            options: {
              postcssOptions: {
                plugins: [
                  'autoprefixer',
                ],
              },
            },
          },
          'sass-loader',
          'import-glob-loader'
        ]
      },

      {
        test: /\.js$/,
        exclude: path.resolve( __dirname, 'node_modules/' ),
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
    ],
  },

  plugins: [
    new MiniCssExtractPlugin({
      filename: 'css/style.css',
    })
  ],
};