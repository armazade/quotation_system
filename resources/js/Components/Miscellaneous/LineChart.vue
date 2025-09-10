<template>
    <div style="max-width: 960px; width: 100%; height: 320px;">
        <canvas ref="canvas"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, watch } from 'vue';
import {
    Chart,
    BarController,
    BarElement,
    CategoryScale,
    LinearScale,
    Tooltip,
    Legend,
} from 'chart.js';

Chart.register(BarController, BarElement, CategoryScale, LinearScale, Tooltip, Legend);

const props = defineProps({
    weeklyOrderValue: {
        type: Array,
        default: () => []
    },
    label: { type: String, default: 'Weekly total' },
    color: { type: String, default: '#3b82f6' }, // Tailwind blue-500
});

const canvas = ref(null);
let chartInstance = null;

const formatLabel = (dateStr) => {
    const d = new Date(dateStr);
    if (Number.isNaN(d.getTime())) return dateStr;
    return new Intl.DateTimeFormat(undefined, {
        month: 'short',
        day: 'numeric'
    }).format(d);
};

const hexToRgba = (hex, alpha = 0.6) => {
    // supports #rrggbb
    const m = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    if (!m) return hex;
    const r = parseInt(m[1], 16);
    const g = parseInt(m[2], 16);
    const b = parseInt(m[3], 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
};

const renderChart = () => {
    if (!canvas.value) return;

    const labels = props.weeklyOrderValue.map(i => formatLabel(i.week_start));
    const values = props.weeklyOrderValue.map(i => i.total ?? 0);

    if (chartInstance) {
        chartInstance.destroy();
        chartInstance = null;
    }

    const ctx = canvas.value.getContext('2d');

    chartInstance = new Chart(ctx, {
        type: 'bar',
        data: {
            labels,
            datasets: [{
                label: props.label,
                data: values,
                backgroundColor: hexToRgba(props.color, 0.6),
                hoverBackgroundColor: hexToRgba(props.color, 0.75),
                borderColor: props.color,
                borderWidth: 1,
                borderRadius: 6,
                maxBarThickness: 60,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    mode: 'index',
                    intersect: false
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 0,
                        autoSkip: true
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.06)'
                    }
                }
            }
        }
    });
};

watch(
    () => props.weeklyOrderValue,
    () => renderChart(),
    { deep: true, immediate: true }
);

onMounted(renderChart);

onBeforeUnmount(() => {
    if (chartInstance) {
        chartInstance.destroy();
        chartInstance = null;
    }
});
</script>
