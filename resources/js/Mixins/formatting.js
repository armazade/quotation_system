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
        formatDate: (value) => {
            if (!value) {
                return '-';
            }
            const date = new Date(value);
            if (isNaN(date.getTime())) {
                return value;
            }
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}-${month}-${year}`;
        },
        formatDateTime: (value) => {
            if (!value) {
                return '-';
            }
            const date = new Date(value);
            if (isNaN(date.getTime())) {
                return value;
            }
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            const hours = String(date.getHours()).padStart(2, '0');
            const minutes = String(date.getMinutes()).padStart(2, '0');
            return `${day}-${month}-${year} ${hours}:${minutes}`;
        },
    }
}
