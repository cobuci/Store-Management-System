import Chart from 'chart.js/auto'

(async function () {
    const ctx = document
        .getElementById("dashboard-line")
        .getContext("2d");

    const labels = [];
    const valores = [];
    const profit = [];
    for (let i = monthsChart.value; i >= 0; i--) {
        labels.push(document.getElementById('hiddeninput' + i).value);
        valores.push(document.getElementById('hiddeninputValue' + i).value);
        profit.push(document.getElementById('hiddeninputProfit' + i).value);
    }
    const data = {
        labels: labels,
        datasets: [
            {
                label: 'Vendas em R$',
                data: valores,
                fill: true,
                borderColor: "#000",
                backgroundColor: "rgba(0,0,0,0.4)",
            },
            {
                label: 'Lucro em R$',
                data: profit,
                fill: true,
                borderColor: "#fff",
                backgroundColor: "rgba(255,255,255,0.4)",
            }
        ]
    };
    // Line chart
    new Chart(document.getElementById("dashboard-line"), {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false,
                },
                title: {
                    display: true,
                    text: 'Vendas e Lucro dos últimos ' + monthsChart.value + ' meses'
                },
                filler: {
                    propagate: false,
                },
                hover: {
                    intersect: true,
                },
                maintainAspectRatio: false,
                tooltips: {
                    intersect: false,
                },
            },

        },
    });

})();
