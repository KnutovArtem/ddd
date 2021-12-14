module.exports = {
    pages: {
        index: {
            entry: 'src/main.js',
            title: 'Что делать если нужен миллион',
            description: '',
        }
    },
    productionSourceMap: false,
    publicPath: process.env.NODE_ENV === 'production' ? '/tinkoff/tinkoff-loan-special-project/' : '/',
    css: {
        loaderOptions: {
            scss: {
                additionalData: `
                @import "~@/styles/reset.scss";
                @import "~@/styles/main.scss";`,
            },
        },

    }

};
