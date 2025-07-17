// Carrega os horários disponíveis
function carregarHorarios() {
    const data = document.getElementById('data').value;
    const barbeiro = document.querySelector('select[name="barbeiro_id"]').value;
    const horaSelect = document.getElementById('hora');

    if (data && barbeiro) {
        fetch(`horarios_disponiveis.php?data=${data}&barbeiro_id=${barbeiro}`)
            .then(res => res.json())
            .then(horarios => {
                horaSelect.innerHTML = '';
                if (horarios.length === 0) {
                    horaSelect.innerHTML = '<option value="">Sem horários disponíveis</option>';
                } else {
                    horarios.forEach(h => {
                        const opt = document.createElement('option');
                        opt.value = h;
                        opt.textContent = h;
                        horaSelect.appendChild(opt);
                    });
                }
            });
    }
}

// Validação para garantir que a data foi escolhida
function validarData() {
    const data = document.getElementById('data').value;
    if (!data) {
        alert('Por favor, selecione uma data clicando em um dos dias disponíveis.');
        return false;
    }
    return true;
}

// Geração dos cards de dias
function gerarProximosDias(quantidade = 7) {
    const diasContainer = document.getElementById('dias');
    diasContainer.innerHTML = '';

    const inputData = document.getElementById('data');
    const hoje = new Date();
    let gerados = 0;
    let i = 0;

    while (gerados < quantidade) {
        const data = new Date();
        data.setDate(hoje.getDate() + i + 1);
        const diaSemana = data.getDay(); // 0 = domingo

        if (diaSemana !== 0) {
            const card = document.createElement('div');
            card.className = 'card-dia';
            const ano = data.getFullYear();
            const mes = String(data.getMonth() + 1).padStart(2, '0');
            const dia = String(data.getDate()).padStart(2, '0');
            card.dataset.data = `${ano}-${mes}-${dia}`;

            card.innerHTML = `
                <strong>${data.toLocaleDateString('pt-BR', { weekday: 'short' })}</strong><br>
                ${data.toLocaleDateString('pt-BR', { day: '2-digit', month: '2-digit' })}
            `;
            card.addEventListener('click', function () {
                document.querySelectorAll('.card-dia').forEach(c => c.classList.remove('selecionado'));
                card.classList.add('selecionado');
                inputData.value = card.dataset.data;
                carregarHorarios();
            });
            diasContainer.appendChild(card);
            gerados++;
        }
        i++;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    gerarProximosDias();

    const barbeiroSelect = document.querySelector('select[name="barbeiro_id"]');
    barbeiroSelect.addEventListener('change', carregarHorarios);
});
