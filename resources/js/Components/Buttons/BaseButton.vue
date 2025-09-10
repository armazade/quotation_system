<script setup>
const props = defineProps({
    type: {
        type: String,
        default: 'button',
    },
    href: String,
    disabled: {
        disabled: Boolean,
        default: false,
    },
    target: {
        default: null,
    },
    buttonColor: {
        default: null,
    },
    printTargetUrl: {
        default: null,
    },
});

const printPdf = () => {
    if (!props.printTargetUrl) {
        return;
    }

    try {
        // Replace with your API endpoint that returns the PDF
        const response = axios.get(props.printTargetUrl, {
            responseType: 'blob', // Important: Set the response type to blob
        });

        response.then((value) => {
            const blob = new Blob([value.data], {type: 'application/pdf'});
            const url = window.URL.createObjectURL(blob);

            // Open the PDF in a new tab
            const newTab = window.open(url);

            // Wait for the new tab to load and then print
            newTab.onload = function () {
                newTab.print();
                // Clean up the URL object after printing
                window.URL.revokeObjectURL(url);
            };
        });        // Create a Blob and a URL for the PDF

    } catch (error) {
        console.error('Error fetching PDF:', error);
    }
}

</script>

<template>
    <a
        :class="['link_button', buttonColor] "
        :href="href"
        :target="target"
        @click="printTargetUrl ? printPdf() : null"
    >
        <slot/>
    </a>
</template>
