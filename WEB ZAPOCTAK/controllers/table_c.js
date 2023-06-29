let curr_page = 0;
let number_of_elements = obj.length;
const prevButton = document.getElementById('prev-button');
const nextButton = document.getElementById('next-button');
const counterHolder = document.getElementById('counter');
const table = document.getElementById('table1');

prevButton.addEventListener('click', prevPage);
nextButton.addEventListener('click', nextPage);
function displayPage(page) {
    table.replaceChildren();
    console.log(page);
    updateCounter();
    updateButtonsVisibility(page);
    displayTableContent(page);
}

function updateCounter() {
    const totalPages = number_of_elements % 10 === 0 ? Math.floor(number_of_elements / 10) : Math.floor(number_of_elements / 10) + 1;
    counterHolder.innerHTML = `${curr_page + 1}/${totalPages}`;
}

function updateButtonsVisibility(page) {
    prevButton.style.visibility = page === 0 ? "hidden" : "visible";
    nextButton.style.visibility = (page === number_of_elements / 10 - 1 || page === Math.floor(number_of_elements / 10)) ? "hidden" : "visible";
}

function displayTableContent(page) {
    const start = 10 * page;
    const limit = Math.min(start + 10, number_of_elements);

    for (let i = start; i < limit; i++) {
        const tr = createTableRow(obj[i]);
        table.appendChild(tr);
    }
}

function createTableRow(item) {
    const tr = document.createElement('tr');
    tr.appendChild(createTableCell(item.name, 'names'));
    tr.appendChild(createTableCell(createLink('Show', `./article/${item.id}`, 'show'), ''));
    tr.appendChild(createTableCell(createLink('Edit', `./article-edit/${item.id}`, 'edit'), ''));
    tr.appendChild(createTableCell(createDeleteButton(item.id), ''));
    return tr;
}

function createTableCell(content, id) {
    const td = document.createElement('td');
    td.setAttribute('id', id);
    if (typeof content === 'string') {
        td.textContent = content;
    } else {
        td.appendChild(content);
    }
    return td;
}

function createLink(text, href, id) {
    const link = document.createElement('a');
    link.textContent = text;
    link.href = href;
    link.setAttribute('id', id);
    return link;
}

function createDeleteButton(id) {
    const deleteButton = createLink('Delete', `https://webik.ms.mff.cuni.cz/~34179985/cms/article-management/article_delete.php?id=${id}`, 'delete');
    deleteButton.addEventListener('click', deleteArticle);
    return deleteButton;
}

function deleteArticle(event) {
    event.preventDefault();
    fetch(event.target.href, { method: 'DELETE' })
        .then(response => {
            if (response.ok) {
                fetch('https://webik.ms.mff.cuni.cz/~34179985/cms/article-management/articles_get.php')
                    .then(response => response.json())
                    .then(data => {
                        obj = data;
                        number_of_elements = obj.length;
                        displayPage(curr_page);
                    });
            }
        });
}

function prevPage() {
    if (curr_page > 0) {
        curr_page--;
    }
    displayPage(curr_page);
}

function nextPage() {
    if (curr_page < Math.floor(number_of_elements / 10)) {
        curr_page++;
    }
    displayPage(curr_page);
}
displayPage(curr_page);