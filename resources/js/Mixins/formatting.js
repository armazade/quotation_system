export const formatting = {
    methods: {
        formatEuro: (value) => {
            if (typeof value !== "number") {
                return value;
            }
            let formatter = new Intl.NumberFormat('en-NL', {
                style: 'currency',
                currency: 'EUR'
            });
            return formatter.format(value);
        },
    }
}
