export default {
    install: (app) => {
        app.config.globalProperties.__ = (key) => {
            return window._translations?.[key] || key;
        };
    }
}
