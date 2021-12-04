module.exports = {
    pages: {
        index: {
            entry: 'src/main.js',
            title: 'Что делать если нужен миллион',
            description: '',
        }
    },
    productionSourceMap: false,
    publicPath: process.env.NODE_ENV === 'production' ? '/laroche/test/' : '/',
    css: {
        loaderOptions: {
            scss: {
                additionalData: `
                @import "~@/styles/config/reset.scss";
                @import "~@/styles/config/base.scss";
                @import "~@/styles/main.scss";`,
            },
        },

    }

};
