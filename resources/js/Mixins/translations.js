export const translations = {
    methods: {
        __(key, replacements = {}) {
            let translation = window._translations[key] || key;

            Object.keys(replacements).forEach(replacementKey => {
                translation = translation.replace(`:${replacementKey}`, replacements[replacementKey]);
            });

            return translation;
        }
    }
}
