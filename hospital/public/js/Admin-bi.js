document.addEventListener("DOMContentLoaded", () => {
    carregarSetores(); 
    configurarBotao(); 
});

let setores = [];

function carregarSetores() {
    fetch('/hospital/scr/API/API-BI.php')
        .then(response => response.json())
        .then(data => {
            setores = Array.from(new Set(data.avaliacoes.map(avaliacao => avaliacao.nome))); 
            const selectSetores = document.getElementById("setores-pizza");
            selectSetores.innerHTML = ""; 

            setores.forEach(setor => {
                const option = document.createElement("option");
                option.value = setor;
                option.textContent = setor;
                selectSetores.appendChild(option);
            });

            if (setores.length > 0) {
                atualizarGraficosETabela(setores[0], null, null);
            }
        })
        .catch(error => console.error('Erro ao carregar setores:', error));
}

function configurarBotao() {
    document.querySelector('.bt button').addEventListener('click', () => {
        const setorSelecionado = document.getElementById("setores-pizza").value;
        const dataInicio = document.getElementById("inicio").value || null;
        const dataFim = document.getElementById("fim").value || null;

        atualizarGraficosETabela(setorSelecionado, dataInicio, dataFim);
    });
}

function atualizarGraficosETabela(setor, inicio, fim) {
    fetch('/hospital/scr/API/API-BI.php')
        .then(response => response.json())
        .then(data => {
            let avaliacoesFiltradas = data.avaliacoes.filter(avaliacao => avaliacao.nome === setor);

            if (inicio) {
                avaliacoesFiltradas = avaliacoesFiltradas.filter(avaliacao => new Date(avaliacao.data_hora) >= new Date(inicio));
            }
            if (fim) {
                avaliacoesFiltradas = avaliacoesFiltradas.filter(avaliacao => new Date(avaliacao.data_hora) <= new Date(fim));
            }

            const dadosPizza = calcularDadosPizza(avaliacoesFiltradas);
            atualizarGraficoPizza(dadosPizza);

            const dadosLinha = calcularDadosLinha(avaliacoesFiltradas);
            atualizarGraficoLinha(dadosLinha);

            atualizarTabela(avaliacoesFiltradas);
        })
        .catch(error => console.error('Erro ao atualizar gráficos e tabela:', error));
}

function atualizarTabela(avaliacoes) {
    const tbody = document.querySelector(".Grafic-bar.table-2 tbody");
    tbody.innerHTML = "";

    avaliacoes.forEach(avaliacao => {
        const tr = document.createElement("tr");

        tr.innerHTML = `
            <td>${avaliacao.id}</td>
            <td>${avaliacao.nome}</td>
            <td>${avaliacao.data_hora}</td>
            <td>${avaliacao.pergunta}</td>
            <td>${avaliacao.resposta}</td>
        `;

        tbody.appendChild(tr);
    });

    if (avaliacoes.length === 0) {
        const tr = document.createElement("tr");
        tr.innerHTML = `<td colspan="5" class="text-center">Nenhuma avaliação encontrada.</td>`;
        tbody.appendChild(tr);
    }
}

function calcularDadosPizza(avaliacoes) {
    const categorias = { 'Ruim (1-2)': 0, 'Razoavel (3-4)': 0, 'Mediano (5-6)': 0, 'Bom (7-8)': 0, 'Excelente (9-10)': 0 };

    avaliacoes.forEach(avaliacao => {
        const resposta = parseInt(avaliacao.resposta, 10);
        if (resposta >= 1 && resposta <= 2) categorias['Ruim (1-2)']++;
        else if (resposta >= 3 && resposta <= 4) categorias['Razoavel (3-4)']++;
        else if (resposta >= 5 && resposta <= 6) categorias['Mediano (5-6)']++;
        else if (resposta >= 7 && resposta <= 8) categorias['Bom (7-8)']++;
        else if (resposta >= 9 && resposta <= 10) categorias['Excelente (9-10)']++;
    });

    return Object.values(categorias);
}

function atualizarGraficoPizza(dados) {
    const ctx = document.getElementById('myChart-pizza').getContext('2d');
    if (window.myChartPizza) window.myChartPizza.destroy();
    window.myChartPizza = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['Ruim (1-2)', 'Razoavel (3-4)', 'Mediano (5-6)', 'Bom (7-8)', 'Excelente (9-10)'],
            datasets: [{
                data: dados,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true
        }
    });
}

function calcularDadosLinha(avaliacoes) {
    const meses = Array(12).fill(0);
    const contagemMeses = Array(12).fill(0);

    avaliacoes.forEach(avaliacao => {
        const mes = new Date(avaliacao.data_hora).getMonth();
        const resposta = parseInt(avaliacao.resposta, 10);

        if (!isNaN(resposta)) {
            meses[mes] += resposta;
            contagemMeses[mes]++;
        }
    });

    return meses.map((soma, idx) => (contagemMeses[idx] > 0 ? soma / contagemMeses[idx] : 0));
}

function atualizarGraficoLinha(dados) {
    const ctx = document.getElementById('myChart-line').getContext('2d');
    if (window.myChartLinha) window.myChartLinha.destroy();
    window.myChartLinha = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            datasets: [{
                label: 'Média de Avaliações por Mês',
                data: dados,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}
