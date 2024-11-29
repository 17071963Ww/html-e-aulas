let selectedUser = null;
let selectedSetor = null;
let selectedPergunta = null;
let selectedDispositivo = null;

document.addEventListener('DOMContentLoaded', () => {
    loadUsers();
    loadSetores();
    loadPerguntas();
    loadDispositivos();
});

// select
function selectSetor(setor) {
    document.getElementById("selectedSetorName").innerText = setor.nome;
    selectedSetor = setor;
}

function selectUser(user) {
    document.getElementById("selectedUserName").innerText = user.usuario;
    selectedUser = user;
}

function selectPergunta(pergunta) {
    document.getElementById("selectedPerguntaName").innerText = pergunta.pergunta;
    selectedPergunta = pergunta;
}

function selectDispositivo(dispositivo) {
    document.getElementById("selectedDispositivoName").innerText = dispositivo.nome_dispositivo;
    selectedDispositivo = dispositivo;
}

//////////////////////////////////////// load

function loadUsers() {
    fetch('/hospital/scr/API/API-Cadastros-user.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById("usuariosTableBody");
        tableBody.innerHTML = "";
        data.forEach(user => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${user.id_usuarios}</td>
                <td>${user.usuario}</td>
                <td>${user.data_criacao}</td>
            `;
            row.addEventListener("click", () => selectUser(user));
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error("Erro ao carregar usuários:", error));
}

function loadSetores() {
    fetch('/hospital/scr/API/API-Cadastros-setores.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById("setoresTableBody");
        tableBody.innerHTML = "";
        data.forEach(setor => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${setor.id_setor}</td>
                <td>${setor.nome}</td>
                <td>${setor.status}</td>
            `;
            row.addEventListener("click", () => selectSetor(setor));
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error("Erro ao carregar setores:", error));
}

function loadPerguntas() {
    fetch('/hospital/scr/API/API-Cadastros-perguntas.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById("perguntasTableBody");
        tableBody.innerHTML = "";
        data.forEach(pergunta => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${pergunta.id_perguntas}</td>
                <td>${pergunta.pergunta}</td>
                <td>${pergunta.status}</td>
                <td>${pergunta.tipo}</td>
            `;
            row.addEventListener("click", () => selectPergunta(pergunta));
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error("Erro ao carregar perguntas:", error));
}

function loadDispositivos() {
    fetch('/hospital/scr/API/API-Cadastros-dispositivos.php', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        const tableBody = document.getElementById("dispositivosTableBody");
        tableBody.innerHTML = "";
        data.forEach(dispositivo => {   
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${dispositivo.id_dispositivos}</td>
                <td>${dispositivo.nome_dispositivo}</td>
                <td>${dispositivo.status}</td>
            `;
            row.addEventListener("click", () => selectDispositivo(dispositivo));
            tableBody.appendChild(row);
        });
    })
    .catch(error => console.error("Erro ao carregar dispositivos:", error));
}

//////////////////////////////////////// criar

// user
document.getElementById("actionButtonUser").addEventListener("click", () => {
    
    const usuario = prompt("Digite o nome do usuário:");
    const senha = prompt("Digite a senha do usuário:");
    
    if (usuario && senha) {
        const newUser = { usuario, senha };
        createUser(newUser);
    } else {
        alert("Todos os campos são obrigatórios!");
    }
});
function createUser(newUser) {
    fetch('/hospital/scr/API/API-Cadastros-user.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newUser)
    })
    .then(response => response.json())
    .then(data => {
        alert("Usuário criado com sucesso!");
        console.log("Usuário criado:", data);
        loadUsers(); 
    })
    .catch(error => {
        console.error("Erro ao criar usuário:", error);
        alert("Erro ao criar o usuário. Tente novamente.");
    });
}

// setor
document.getElementById("actionButtonSetor").addEventListener("click", () => {
    const nome = prompt("Digite o nome do setor:");
    if (nome) {
        const newSetor = { nome, status: "Ativo" }; 
        createSetor(newSetor);
    } else {
        alert("O campo Nome do Setor é obrigatório!");
    }
    
});
function createSetor(newSetor) {
    fetch('/hospital/scr/API/API-Cadastros-setores.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newSetor)
    })
    .then(response => response.json())
    .then(data => {
        alert("Setor criado com sucesso!");
        console.log("Setor criado:", data);
        loadSetores(); 
    })
    .catch(error => {
        console.error("Erro ao criar setor:", error);
        alert("Erro ao criar o setor. Tente novamente.");
    });
}

// perguntas
document.getElementById("actionButtonPergunta").addEventListener("click", () => {
    const pergunta = prompt("Digite a pergunta:");
    if (!pergunta) {
        alert("O campo Pergunta é obrigatório!");
        return;
    }
    const tipoOpcao = prompt("Escolha o tipo da pergunta:\n1 - 0-10\n2 - Resposta Escrita");
    let tipo;

    if (tipoOpcao === "1") {
        tipo = "button"; 
    } else if (tipoOpcao === "2") {
        tipo = "text"; 
    } else {
        alert("Tipo inválido. Operação cancelada.");
        return;
    }

    const newPergunta = { pergunta, tipo, status: "Ativo" }; 
    createPergunta(newPergunta);
});

function createPergunta(newPergunta) {
    fetch('/hospital/scr/API/API-Cadastros-perguntas.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newPergunta)
    })
    .then(response => response.json())
    .then(data => {
        alert("Pergunta criada com sucesso!");
        console.log("Pergunta criada:", data);
        loadPerguntas(); 
    })
    .catch(error => {
        console.error("Erro ao criar pergunta:", error);
        alert("Erro ao criar a pergunta. Tente novamente.");
    });
}

// Dispositivos
document.getElementById("actionButtonDispositivo").addEventListener("click", () => {
    const nome = prompt("Digite o nome do dispositivo:");
    if (!nome) {
        alert("O campo Nome do Dispositivo é obrigatório!");
        return;
    }
    const newDispositivo = { nome, status: "Ativo" };
    createDispositivo(newDispositivo);
   
});
function createDispositivo(newDispositivo) {
    fetch('/hospital/scr/API/API-Cadastros-dispositivos.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(newDispositivo)
    })
    .then(response => response.json())
    .then(data => {
        alert("Dispositivo criado com sucesso!");
        console.log("Dispositivo criado:", data);
        loadDispositivos(); 
    })
    .catch(error => {
        console.error("Erro ao criar dispositivo:", error);
        alert("Erro ao criar o dispositivo. Tente novamente.");
    });
}

//////////////////////////////////////// Atualizar

// Users
document.getElementById("editButtonUsuario").addEventListener("click", () => {
    if (!selectedUser) {
        alert("Por favor, selecione um usuário para editar.");
        return;
    }
    const newName = prompt("Digite o novo nome para o usuário:", selectedUser.usuario);

    if (!newName) {
        alert("O campo Nome do usuário é obrigatório!");
        return;
    }

    const updatedUser = { 
        id_usuarios: selectedUser.id_usuarios, 
        usuario: newName
    };
    
    updateUsuario(updatedUser);
});
function updateUsuario(updatedUser) {
    fetch('/hospital/scr/API/API-Cadastros-user.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedUser)
    })
    .then(response => response.text())  
    .then(data => {
        console.log("Resposta do servidor:", data); 
        try {
            const jsonData = JSON.parse(data);  
            alert("Nome do usuário atualizado com sucesso!");
            console.log("Usuário atualizado:", jsonData);
            loadUsers(); 
        } catch (error) {
            alert("Erro ao atualizar o nome do usuário. Resposta do servidor não é JSON.");
            console.error("Erro ao interpretar resposta JSON:", error);
            console.log("Resposta do servidor:", data);
        }
    })
    .catch(error => {
        console.error("Erro ao atualizar o nome do usuário:", error);
        alert("Erro ao atualizar o nome do usuário. Tente novamente.");
    });
}

// setor
document.getElementById("editButtonSetor").addEventListener("click", () => {
    if (!selectedSetor) {
        alert("Por favor, selecione um setor para editar.");
        return;
    }

    const newName = prompt("Digite o novo nome para o setor:", selectedSetor.nome);

    if (!newName) {
        alert("O campo Nome do setor é obrigatório!");
        return;
    }

    const updatedSetor = {
        id_setor: selectedSetor.id_setor,
        nome: newName
    };

    updateSetor(updatedSetor);
});
function updateSetor(updatedSetor) {
    fetch('/hospital/scr/API/API-Cadastros-setores.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedSetor)
    })
    .then(response => response.text())
    .then(data => {
        console.log("Resposta do servidor:", data);
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.error) {
                alert("Erro ao atualizar o setor: " + jsonData.error);
                console.error("Erro do servidor:", jsonData.error);
            } else {
                alert("Nome do setor atualizado com sucesso!");
                console.log("Setor atualizado:", jsonData);
                loadSetores();
            }
        } catch (error) {
            alert("Erro ao atualizar o nome do setor. Resposta do servidor não é JSON.");
            console.error("Erro ao interpretar resposta JSON:", error);
            console.log("Resposta do servidor:", data);
        }
    })
    .catch(error => {
        console.error("Erro ao atualizar o nome do setor:", error);
        alert("Erro ao atualizar o nome do setor. Tente novamente.");
    });
}

// pergunta
document.getElementById("editButtonPergunta").addEventListener("click", () => {
    if (!selectedPergunta) {
        alert("Por favor, selecione uma pergunta para editar.");
        return;
    }

    const newPergunta = prompt("Digite a nova pergunta:", selectedPergunta.pergunta);
    if (!newPergunta) {
        alert("O campo Pergunta é obrigatório!");
        return;
    }

    const tipoOpcao = prompt("Escolha o tipo da pergunta:\n1 - 0-10\n2 - Resposta Escrita");
    let newTipo;
    if (tipoOpcao === "1") {
        newTipo = "button";
    } else if (tipoOpcao === "2") {
        newTipo = "text";
    } else {
        alert("Tipo inválido. Operação cancelada.");
        return;
    }

    const updatedPergunta = {
        id_perguntas: selectedPergunta.id_perguntas,
        pergunta: newPergunta,
        tipo: newTipo
    };

    updatePergunta(updatedPergunta);
});
function updatePergunta(updatedPergunta) {
    fetch('/hospital/scr/API/API-Cadastros-perguntas.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedPergunta)
    })
    .then(response => response.text())
    .then(data => {
        console.log("Resposta do servidor:", data);
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.error) {
                alert("Erro ao atualizar a pergunta: " + jsonData.error);
                console.error("Erro do servidor:", jsonData.error);
            } else {
                alert("Pergunta atualizada com sucesso!");
                console.log("Pergunta atualizada:", jsonData);
                loadPerguntas();
            }
        } catch (error) {
            alert("Erro ao atualizar a pergunta. Resposta do servidor não é JSON.");
            console.error("Erro ao interpretar resposta JSON:", error);
            console.log("Resposta do servidor:", data);
        }
    })
    .catch(error => {
        console.error("Erro ao atualizar a pergunta:", error);
        alert("Erro ao atualizar a pergunta. Tente novamente.");
    });
}

// dispositivo
document.getElementById("editButtonDispositivo").addEventListener("click", () => {
    if (!selectedDispositivo) {
        alert("Por favor, selecione um dispositivo para editar.");
        return;
    }

    const newName = prompt("Digite o novo nome do dispositivo:", selectedDispositivo.nome_dispositivo);

    if (!newName) {
        alert("O campo Nome do dispositivo é obrigatório!");
        return;
    }

    const updatedDispositivo = {
        id_dispositivos: selectedDispositivo.id_dispositivos,
        nome_dispositivo: newName
    };

    updateDispositivo(updatedDispositivo);
});
function updateDispositivo(updatedDispositivo) {
    fetch('/hospital/scr/API/API-Cadastros-dispositivos.php', {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(updatedDispositivo)
    })
    .then(response => response.text())
    .then(data => {
        console.log("Resposta do servidor:", data);
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.error) {
                alert("Erro ao atualizar o dispositivo: " + jsonData.error);
                console.error("Erro do servidor:", jsonData.error);
            } else {
                alert("Nome do dispositivo atualizado com sucesso!");
                console.log("Dispositivo atualizado:", jsonData);
                loadDispositivos();
            }
        } catch (error) {
            alert("Erro ao atualizar o nome do dispositivo. Resposta do servidor não é JSON.");
            console.error("Erro ao interpretar resposta JSON:", error);
            console.log("Resposta do servidor:", data);
        }
    })
    .catch(error => {
        console.error("Erro ao atualizar o dispositivo:", error);
        alert("Erro ao atualizar o dispositivo. Tente novamente.");
    });
}

//////////////////////////////////////// Excluir

// user
document.getElementById("deleteButtonUsuario").addEventListener("click", () => {
    if (!selectedUser) {
        alert("Por favor, selecione um usuário para excluir.");
        return;
    }

    const confirmDelete = confirm(`Tem certeza de que deseja excluir o usuário "${selectedUser.usuario}"?`);
    if (!confirmDelete) {
        return;
    }

    deleteUsuario(selectedUser.id_usuarios);
});
function deleteUsuario(userId) {
    fetch('/hospital/scr/API/API-Cadastros-user.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_usuarios: userId })
    })
    .then(response => response.text())
    .then(data => {
        console.log("Resposta do servidor:", data);
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.error) {
                alert("Erro ao excluir o usuário: " + jsonData.error);
                console.error("Erro do servidor:", jsonData.error);
            } else {
                alert("Usuário excluído com sucesso!");
                console.log("Usuário excluído:", jsonData);
                loadUsers();
            }
        } catch (error) {
            alert("Erro ao excluir o usuário. Resposta do servidor não é JSON.");
            console.error("Erro ao interpretar resposta JSON:", error);
            console.log("Resposta do servidor:", data);
        }
    })
    .catch(error => {
        console.error("Erro ao excluir o usuário:", error);
        alert("Erro ao excluir o usuário. Tente novamente.");
    });
}

// setor
document.getElementById("deleteButtonSetor").addEventListener("click", () => {
    if (!selectedSetor) {
        alert("Por favor, selecione um setor para excluir.");
        return;
    }

    const confirmDelete = confirm(`Tem certeza de que deseja excluir o setor "${selectedSetor.nome}"?`);
    if (!confirmDelete) {
        return;
    }

    deleteSetor(selectedSetor.id_setor);
});
function deleteSetor(setorId) {
    fetch('/hospital/scr/API/API-Cadastros-setores.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_setor: setorId })
    })
    .then(response => response.text())
    .then(data => {
        console.log("Resposta do servidor:", data);
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.error) {
                alert("Erro ao excluir o setor: " + jsonData.error);
                console.error("Erro do servidor:", jsonData.error);
            } else {
                alert("Setor excluído com sucesso!");
                console.log("Setor excluído:", jsonData);
                loadSetores();
            }
        } catch (error) {
            alert("Erro ao excluir o setor. Resposta do servidor não é JSON.");
            console.error("Erro ao interpretar resposta JSON:", error);
            console.log("Resposta do servidor:", data);
        }
    })
    .catch(error => {
        console.error("Erro ao excluir o setor:", error);
        alert("Erro ao excluir o setor. Tente novamente.");
    });
}

// pergunta
document.getElementById("deleteButtonPergunta").addEventListener("click", () => {
    if (!selectedPergunta) {
        alert("Por favor, selecione uma pergunta para excluir.");
        return;
    }

    const confirmDelete = confirm(`Tem certeza de que deseja excluir a pergunta "${selectedPergunta.pergunta}"?`);
    if (!confirmDelete) {
        return;
    }

    deletePergunta(selectedPergunta.id_perguntas);
});
function deletePergunta(perguntaId) {
    fetch('/hospital/scr/API/API-Cadastros-perguntas.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_perguntas: perguntaId })
    })
    .then(response => response.text())
    .then(data => {
        console.log("Resposta do servidor:", data);
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.error) {
                alert("Erro ao excluir a pergunta: " + jsonData.error);
                console.error("Erro do servidor:", jsonData.error);
            } else {
                alert("Pergunta excluída com sucesso!");
                console.log("Pergunta excluída:", jsonData);
                loadPerguntas();
            }
        } catch (error) {
            alert("Erro ao excluir a pergunta. Resposta do servidor não é JSON.");
            console.error("Erro ao interpretar resposta JSON:", error);
            console.log("Resposta do servidor:", data);
        }
    })
    .catch(error => {
        console.error("Erro ao excluir a pergunta:", error);
        alert("Erro ao excluir a pergunta. Tente novamente.");
    });
}

// dispositivo
document.getElementById("deleteButtonDispositivo").addEventListener("click", () => {
    if (!selectedDispositivo) {
        alert("Por favor, selecione um dispositivo para excluir.");
        return;
    }

    const confirmDelete = confirm(`Tem certeza de que deseja excluir o dispositivo "${selectedDispositivo.nome_dispositivo}"?`);
    if (!confirmDelete) {
        return;
    }

    deleteDispositivo(selectedDispositivo.id_dispositivos);
});
function deleteDispositivo(dispositivoId) {
    fetch('/hospital/scr/API/API-Cadastros-dispositivos.php', {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ id_dispositivos: dispositivoId })
    })
    .then(response => response.text())
    .then(data => {
        console.log("Resposta do servidor:", data);
        try {
            const jsonData = JSON.parse(data);
            if (jsonData.error) {
                alert("Erro ao excluir o dispositivo: " + jsonData.error);
                console.error("Erro do servidor:", jsonData.error);
            } else {
                alert("Dispositivo excluído com sucesso!");
                console.log("Dispositivo excluído:", jsonData);
                loadDispositivos();
            }
        } catch (error) {
            alert("Erro ao excluir o dispositivo. Resposta do servidor não é JSON.");
            console.error("Erro ao interpretar resposta JSON:", error);
            console.log("Resposta do servidor:", data);
        }
    })
    .catch(error => {
        console.error("Erro ao excluir o dispositivo:", error);
        alert("Erro ao excluir o dispositivo. Tente novamente.");
    });
}

//////////////////////////////////////// Ativar / desativar ( excessão de usuarios )

// setor
document.getElementById("toggleStatusButtonSetor").addEventListener("click", () => {
    if (!selectedSetor) {
        alert("Selecione um setor antes de alterar o status.");
        return;
    }

    if (confirm("Você tem certeza que deseja alterar o status do setor?")) {
        alterarStatusSetor(selectedSetor);
    }
});

function alterarStatusSetor(idSetor) {
    const url = '/hospital/scr/API/API-Cadastros-setores.php';  

    const data = {
        id_setor: idSetor  
    };

    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)  
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
            alert(`${data.status} Nome do Setor: ${data.nome_setor}. Novo Status: ${data.novo_status}`);
            loadSetores();
        } else {
            alert(data.error);  
        }
    })
    .catch(error => {
        console.error("Erro ao alterar o status do setor:", error);
        alert("Ocorreu um erro ao tentar alterar o status.");
    });
}

//////////////////////////////////////// Alterar senha

function promptChangePassword() {
    if (selectedUser) {
        const newPassword = prompt('Digite a nova senha para o usuário ' + selectedUser.usuario);
    
        if (newPassword) {
            changePassword(selectedUser.id_usuarios, newPassword);
        }
    } else {
        alert("Nenhum usuário selecionado!");
    }
}

function changePassword(userId, newPassword) {
    
    fetch('/hospital/scr/API/API-Cadastros-users.php', {
        method: 'PATCH', 
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id_usuario: userId,
            nova_senha: newPassword
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'Senha do usuário atualizada com sucesso.') {
            alert('Senha alterada com sucesso!');
        } else {
            alert('Erro ao alterar senha: ' + data.error);
        }
    })
    .catch(error => {
        alert('Erro na comunicação com o servidor: ' + error);
    });
}
