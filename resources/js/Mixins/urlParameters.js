export const urlParameters = {
    methods: {
        getParameterValue: (key) => {
            return (new URL(document.location)).searchParams.get(key) ?? null;
        }
    }
}
