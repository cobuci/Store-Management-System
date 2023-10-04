import Chart from 'chart.js/auto'

(async function () {

    const ctx = document
        .getElementById("dashboard-line")
        .getContext("2d");
    const gradient = ctx.createLinearGradient(0, 0, 0, 225);
    gradient.addColorStop(0, "rgba(215, 227, 244, 0.2)");
    gradient.addColorStop(1, "rgba(215, 227, 244, 0.4)");

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
                type: 'line',
                label: 'Lucro em R$',
                data: profit,
                fill: true,
                borderColor: "black",
                backgroundColor: gradient,

            }
            , {
                label: 'Vendas em R$',
                data: valores,
                fill: true,
                borderColor: "red",
                backgroundColor: gradient,
            }
        ]
    };
    // Line chart
    new Chart(document.getElementById("dashboard-line"), {
        type: 'bar',
        data: data,
        tension: 0.4,
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    reverse: false,
                    min: 0,
                },
                x: {
                    beginAtZero: true,
                    reverse: false,
                }
            },

            plugins: {
                legend: {
                    display: false,
                },
                tooltips: {
                    enabled: true,
                    intersect: false,

                },
                title: {
                    display: true,
                    text: 'Vendas e Lucro dos últimos ' + monthsChart.value + ' meses'
                },
                filler: {
                    propagate: false,
                },
                maintainAspectRatio: false,

                colors: {
                    forceOverride: true,
                }
            },
            interaction: {
                mode: 'index',
            },

        },
    });

})();
