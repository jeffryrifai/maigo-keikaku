import { tenantChart, renderTenantChart } from './chart-tenant.js';
import { loadQuill } from './quill-artikel.js';


Livewire.on('chart-data-loaded', ({chart_data}) => {

    renderTenantChart(chart_data.data);
    // tenantChart.data.labels = chart_data.data.labels;
    // tenantChart.data.datasets[0].data = chart_data.data.values;
    // tenantChart.update();
})



// Pantau perubahan dark mode
const observer = new MutationObserver(() => {
    // renderTenantChart();
    loadQuill();
});
observer.observe(document.documentElement, {
    attributes: true,
    attributeFilter: ['class']
});