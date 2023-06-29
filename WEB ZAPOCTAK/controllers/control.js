const createButton = document.getElementById('create-button');
const createDialog = document.getElementById('create-dialog');
const createCancel = document.getElementById('create-cancel');
const articleName = document.getElementById('article-name');
const createSubmit = document.getElementById('create-submit');
const createForm = document.getElementById('create-form');

createButton.addEventListener('click', openCreateDialog);
createCancel.addEventListener('click', closeCreateDialog);
articleName.addEventListener('input', toggleSubmitButton);
createForm.addEventListener('submit', submitArticle);

function openCreateDialog() {
    createDialog.style.display = 'block';
}

function closeCreateDialog() {
    createDialog.style.display = 'none';
}

function toggleSubmitButton() {
    createSubmit.disabled = articleName.value === '';
}

function submitArticle(event) {
    event.preventDefault();

    const name = articleName.value;

    fetch('https://webik.ms.mff.cuni.cz/~34179985/cms/article-management/article_create.php', {
        method: 'POST',
        body: JSON.stringify({ name })
    })
    .then(response => response.json())
    .then(data => {
        closeCreateDialog();
        window.location.href = `./article-edit/${data.id}`;
    });
}