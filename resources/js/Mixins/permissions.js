export const permissions = {
    methods: {
        hasPermission: (storedPermissions, permission) => {
            let result = false;
            storedPermissions.forEach(storedPermission => {
                if (storedPermission === permission) {
                    result = true;
                }
            })

            return result;
        },
    }
}
