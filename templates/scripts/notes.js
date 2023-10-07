class Note{
    id;
    title;
    text;
    bgColor;
    textColor;
    updatedAt


    constructor(id, title, text, bgColor, textColor, updatedAt)
    {
        this.id = id;
        this.title = title;
        this.text = text;
        this.bgColor = bgColor;
        this.textColor = textColor;
        this.updatedAt = updatedAt;
    }

    getCardView()
    {
        let title = this.title;
        if(title === null)
            title = `Заметка №${this.id}`
        else if(title.length > 19)
            title = title.slice(0, 17) + "...";

        let text = this.text;
        if(text === null)
            text = ""
        else if(text.length > 146)
            text = text.slice(0, 146) + "...";

        return `
        <div class="note-card" attrId="${this.id}" style="background: #${this.bgColor}; color: #${this.textColor}">
            <div class="note-card_main-content">
                <span class="note-card_title">${title}</span>
                <span class="note-card_text">${text}</span>
            </div>
            <span class="note-card_date">${this.updatedAt}</span>
        </div>
        `;
    }

    outputNote()
    {
        titleField.value = "";
        textField.value = ""
        dateField.innerText = ""

        if(this.title !== null)
            titleField.value = this.title;

        if(this.text !== null)
            textField.value = this.text;

        dateField.innerText = this.updatedAt;

        bgColorInput[0].checked = true;
        bgColorInput.forEach((btn) => {
            if(btn.value === this.bgColor)
                btn.checked = true;
        })

        noteContainer.setAttribute('attrId', this.id)
    }
}

const API_URL = "http://notes/api/v1"

// Массив заметок
let notesList = [];
console.log('after create: ', notesList)

// Элемент, куда будут выводится заметки
const notesListBody = document.querySelector(".notes");

// Элементы для вывода заметки
const note = document.querySelector(".note-bg")
const noteContainer = document.querySelector(".note")

// Кнопка для закрытия заметки
const noteCloseBtn = document.querySelector(".settings_close")

// Элементы для данных заметки (вывода и дальнейшего ввода)
const titleField = document.querySelector(".text-data_title");
const textField = document.querySelector(".text-data_text");
const dateField = document.querySelector(".text-data_date");
const bgColorInput = document.querySelectorAll(".palette_colors label input[type=radio]")

// Закрывание записки
noteCloseBtn.addEventListener('click', () => {
    clearNoteForm()

    // Скрытие формы
    noteContainer.removeAttribute('attrId')
    note.classList.remove('display-flex')
    noteDeleteConfirm.classList.remove('display-block')
})

// Кнопка для удаления заметки
const noteDeleteBtn = document.querySelector(".settings_delete")

// Подтверждение удаления
const noteDeleteConfirm = document.querySelector(".note_delete-confirm")
const noteDeleteConfirmYes = document.querySelector(".submit_yes")
const noteDeleteConfirmNo = document.querySelector(".submit_no")

noteDeleteBtn.addEventListener('click', () => noteDeleteConfirm.classList.toggle('display-block'))
noteDeleteConfirmYes.addEventListener('click', () => {
    let id = noteContainer.getAttribute('attrId')

    deleteNote(id).then(() =>{
        getNotes().then( () =>
            outputNotes().then(
                addNoteClickListener
            )
        )
    });

    noteDeleteConfirm.classList.remove('display-block')
    note.classList.remove('display-flex')
})
noteDeleteConfirmNo.addEventListener('click', () => noteDeleteConfirm.classList.remove('display-block'))

// Кнопка для создания заметки
const noteOpenCreateFormBtn = document.querySelector(".create-btn")
// let isCreatingNote = false;
noteOpenCreateFormBtn.addEventListener('click', () => {
    clearNoteForm()
    handleCreateBtnClick()
    //isCreatingNote = true;
})


// Кнопка создания/редактирования заметки
let saveNoteBtn = document.querySelector(".note_panel_save")


getNotes().then(() => {
    outputNotes().then(addNoteClickListener);
});


// Парсинг заметок и запись их в массив
function parseNotesJson(notesJson) {
    clearNoteList()
    let notesArray = JSON.parse(notesJson);

    // Запись в массив
    notesArray.forEach((note) => {
        notesList.push(new Note(
            note['id'],
            note['title'],
            note['text'],
            note['bgColor'],
            note['textColor'],
            note['updatedAt']
        ))
    })
    console.log('after push: ', notesList)
}

// Вывод заметок
async function outputNotes(){
    notesListBody.innerHTML = "";

    // Вывод списка в DOM
    for (const note of notesList) {
        notesListBody.innerHTML += await note.getCardView();
        //console.log(note)
    }
}

// Очистка заметок
function clearNoteList()
{
    let listSize = notesList.length;
    for(let i = 0; i < listSize; ++i){
        delete notesList[i];
    }
    notesList = [];
}

// Добавление слушателей на клик для каждой заметки
function addNoteClickListener(){
    let notesListDOM = document.querySelectorAll("div.note-card")

    const listSize = notesListDOM.length

    for(let i = 0; i < listSize; ++i){
        notesListDOM[i].addEventListener('click', ()=>{
            //notesList[i].outputNote()
            handleNoteClick(i)
        })
    }
}


// Обработчик клика плюс
function handleCreateBtnClick() {
    note.classList.add("display-flex");
    noteDeleteBtn.classList.add('display-none');
    // Remove the event listener first, if any
    saveNoteBtn.removeEventListener('click', handleSaveNoteBtnClick);
    // Attach the event listener to the saveNoteBtn
    saveNoteBtn.addEventListener('click', handleSaveNoteBtnClick);
}

// Вынес в отдельную функцию, чтобы сбрасывать обработчик
function handleSaveNoteBtnClick() {
    let id = noteContainer.getAttribute('attrId');
    if (id) return;
    let params = readNoteForm();
    createNote(params).then(() => {
        getNotes().then(() => outputNotes().then(addNoteClickListener));
    });
    note.classList.remove("display-flex");
    noteDeleteBtn.classList.remove('display-none');
}

// Обработчик клика на заметку
function handleNoteClick(index){
    note.classList.add("display-flex")
    notesList[index].outputNote();

    saveNoteBtn.addEventListener('click', () =>{

        let id = noteContainer.getAttribute('attrId');

        if(!id) return ;


        let params = readNoteForm();

        editNote(id, params).then(() =>{
            getNotes().then( () =>
                outputNotes().then(
                    addNoteClickListener
                )
            )
        });

        note.classList.remove("display-flex")
        noteContainer.removeAttribute('attrId');
    })
}

// Считывание данных с формы
function readNoteForm(){
    let params = {};
    params['title'] = titleField.value;
    params['text'] = textField.value;

    let bgColor;
    bgColorInput.forEach((input) => {
        if(input.checked === true)
            bgColor = input.value
    })
    let textColor = bgColor === "FFFFFF" ? "000000" : "FFFFFF";

    params['bgColor'] = bgColor;
    params['textColor'] = textColor;

    return params;
}

function clearNoteForm(){
    titleField.value = ""
    textField.value = ""
    bgColorInput[0].checked = true;
    dateField.innerText = "";
}

// Считывание всех заметок с сервера
async function getNotes() {
    await fetch(API_URL + "/notes")
        .then(response => response.text())
        .then(response => parseNotesJson(response))
}

// Удаление заметки
async function deleteNote(id){
    await fetch(API_URL + '/note/' + id, {
        method: 'DELETE'
    }).then();
}

async function editNote(id, params){
    let paramsPUT = new URLSearchParams()
    paramsPUT.set('title', params.title);
    paramsPUT.set('text', params.text);
    paramsPUT.set('bgColor', params.bgColor);
    paramsPUT.set('textColor', params.textColor)

    await fetch(API_URL + '/note/' + id, {
        method: 'PUT',
        headers:{
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: paramsPUT
    }).then();
}

async function createNote(params){
    let paramsPOST = new URLSearchParams()
    paramsPOST.set('title', params.title);
    paramsPOST.set('text', params.text);
    paramsPOST.set('bgColor', params.bgColor);
    paramsPOST.set('textColor', params.textColor);

    const data = await fetch(API_URL + '/note', {
        method: 'POST',
        body: paramsPOST
    });
    console.log(data)
}