document.addEventListener('DOMContentLoaded', () => {
    let avaliacoesTotal = 0;
    let avaliacoesPositivas = 0;
    let avaliacoesNegativas = 0;
    let totalSetores = 0;
    let setoresData = [];
    let mediaSetoresMes = [];

    const apiUrl = '/hospital/scr/API/API-home.php'; 

    let barChart = null;
    let lineChart = null;

function graficoBarras() {
    const hoje = new Date();
    const mesAtual = hoje.getMonth() + 1; 
    const anoAtual = hoje.getFullYear(); 

    // Filtra os dados para o mês atual
    const dadosMesAtual = setoresData.filter(setor => {
        return parseInt(setor.mes, 10) === mesAtual && parseInt(setor.ano, 10) === anoAtual;
    });

    const labels = dadosMesAtual.map(setor => setor.setor);
    const data = dadosMesAtual.map(setor => parseFloat(setor.media_resposta));

    const ctx = document.getElementById('myChart').getContext('2d');

    if (barChart) barChart.destroy();

    barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Média de Avaliações Por Setor',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

    function graficoline() {
        const meses = ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'];

        const somaMeses = new Array(12).fill(0);
        const contagemMeses = new Array(12).fill(0);

        mediaSetoresMes.forEach(item => {
            const mes = parseInt(item.mes, 10) - 1; 
            const media_resposta = parseFloat(item.media_resposta);

            somaMeses[mes] += media_resposta;
            contagemMeses[mes] += 1;
        });

        const mediaMensal = somaMeses.map((soma, index) => contagemMeses[index] > 0 ? soma / contagemMeses[index] : 0);

        const labels = meses;

        const ctx = document.getElementById('myChart-history').getContext('2d');

        if (lineChart) {
            lineChart.destroy();
        }

        lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Média de Avaliações - Estabelecimento (Todos os Setores)',
                    data: mediaMensal,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
}

function updateTable() {
    const tbody = document.querySelector('.Grafic-bar table tbody');
    tbody.innerHTML = ''; 

    ultimasAvaliacoes.forEach(avaliacao => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${avaliacao.id}</td>
            <td>${avaliacao.setor}</td>
            <td>${avaliacao.hora}</td>
            <td>${avaliacao.pergunta}</td>
            <td>${avaliacao.resposta}</td>
        `;
        tbody.appendChild(row);
    });
}
        
    function fetchData() {
        fetch(apiUrl)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Erro na API: ${response.statusText}`);
                }
                return response.json(); 
            })
            .then(data => {
                avaliacoesTotal = data.avaliacoes_total?.[0]?.avaliacoes_totall || 0;
                avaliacoesPositivas = data.avaliacoes_positivas?.[0]?.avaliacoespositivas_total || 0;
                avaliacoesNegativas = data.avaliacoes_negativas?.[0]?.avaliacoesnegativas_total || 0;
                totalSetores = data.total_setores?.[0]?.total_setores || 0;

                setoresData = data.media_setores_mes || [];
                mediaSetoresMes = data.media_setores_mes || [];

                setorMaiorMediaMesAtual = data.setor_maior_media_mes_atual?.[0] || {};

                ultimasAvaliacoes = data.avaliacoes_new || [];

                updateUI();
                updateCharts();
            })
            .catch(error => {
                console.error('Erro ao buscar dados:', error);
            });
    }
    function updateUI() {
        document.getElementById('AvaliacaoTotal').innerText = `${avaliacoesTotal}`;
        document.getElementById('AvaliacaoPositivas').innerText = `${avaliacoesPositivas}`;
        document.getElementById('AvaliacaoNegativas').innerText = `${avaliacoesNegativas}`;
        document.getElementById('totalSetores').innerText = `${totalSetores}`;
        document.getElementById('setor-top').innerText = `${setorMaiorMediaMesAtual.setor}`;
    }

    function updateCharts() {
        graficoBarras(); 
        graficoline();
        updateTable(); 
    }

    setInterval(fetchData, 10000); 
    fetchData(); 
});
