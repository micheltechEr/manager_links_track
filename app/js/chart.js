window.onload = function(){
     const ctx = document.getElementById('dashboardChart').getContext('2d');

    fetch('api/api_dashboard_chart.php')
        .then(response => response.json())
        .then(chartData => {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Total de Cliques por Dia',
                        data: chartData.data,
                        borderColor: 'rgb(54, 162, 235)', 
                        tension: 0.1
                    }]
                },
                options:{
                    responsive:true,
                    scales:{
                        y:{
                            beginAtZero:true,
                            ticks:{
                                precision:0
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Erro ao buscar dados do gráfico:', error));
}