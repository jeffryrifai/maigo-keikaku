import Chart from 'chart.js/auto';

export let tenantChart = null;
export function renderTenantChart(initialData = { labels: [], values: [] }) {
    const canvas = document.getElementById('tenantIssuesChart');
    if (!canvas) return;

    // Hapus chart lama kalau ada
    if (tenantChart) {
        tenantChart.destroy();
    }

    const isDark = Flux.dark;
    const textColor = isDark ? '#ffffff' : '#000000';


    const data = {
        labels: initialData.labels,
        datasets: [{
            label: 'Jumlah Kekurangan',
            data: initialData.values,
            borderWidth: 2
        }]
    };

    const config = {
        type: 'pie',
        data,
        options: {
            maintainAspectRatio: false,
            plugins: {
                title: {
                    display: true,
                    text: 'Jumlah Kekurangan Tiket Tenant',
                    color: textColor
                },
                legend: {
                    position: 'bottom',
                    labels: {
                        color: textColor
                    }
                }
            }
        }
    };

    tenantChart = new Chart(canvas, config);
    
}


