module.exports = {
    context: __dirname,
    entry: './js/index_page/index.js',
    output: {
        path: __dirname + '/public/',
        filename: 'bundle.js'
    },
    module:{
        loaders: [
            {
                test: /\.jsx?$/,
                loader: 'babel-loader',
                query:{
                    presets: ['es2015', 'react']
                }
            }
        ]
    }
}