const mostrarModal = document.getElementById("mostrar-modal-botao");
const closeModalButton = document.getElementById("closeModal");
const modal = document.getElementById("modal");
const form = document.getElementById("form");
const corpoTabela = document.getElementById("corpoTabela");
const insertButton = document.getElementById("insertButton");

let rowIndex = 1;

function showModal() {
    modal.style.display = 'block';
}

function closeModal() {
    modal.style.display = 'none';
}

function insertData(event) {
    event.preventDefault();
    const nome = document.getElementById('nomeModal').value;
    const cargo = document.getElementById('cargo').value;
    const data = document.getElementById('data').value;
    const hd = document.getElementById('hd').value;

    const newRow = corpoTabela.insertRow();
    newRow.innerHTML = `
        <td>${rowIndex}</td>
        <td>${nome}</td>
        <td>${cargo}</td>
        <td>${data}</td>
        <td>${hd}</td>
        <td>
            <button type="button" class=""><i class="fa-solid fa-pen-to-square"></i></button>
            <button type="button" class=""><i class="fa-solid fa-trash"></i></button>
        </td>
    `;
    
    rowIndex++;
    closeModal();
    form.reset();
}

mostrarModal.addEventListener('click', showModal);
closeModalButton.addEventListener('click', closeModal);
insertButton.addEventListener('click', insertData);

