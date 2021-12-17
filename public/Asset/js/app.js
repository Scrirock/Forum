let plusIcon = document.querySelector("#plusIcon");

if (plusIcon){
    /* make the icon pretty */
    plusIcon.addEventListener("mouseenter", ()=>{
        plusIcon.className = "fas fa-plus-square";
    });
    plusIcon.addEventListener("mouseleave", ()=>{
        plusIcon.className = "far fa-plus-square";
    });
}

/* add a category */
let formCategory = document.querySelector("#addCategory form");
if (formCategory){
    plusIcon.addEventListener("click", ()=>{
        if (formCategory.childNodes.length < 1){
            let inputTitle = document.createElement("input");
            inputTitle.name = "categoryName";
            inputTitle.id = "categoryName";
            inputTitle.placeholder = "Nom de la catégorie";
            formCategory.appendChild(inputTitle);

            let textAreaElement = document.createElement("textarea");
            textAreaElement.name = "content";
            textAreaElement.id = "content";
            textAreaElement.cols = 30;
            textAreaElement.rows = 10;
            formCategory.appendChild(textAreaElement);

            let send = document.createElement("input");
            send.type = "submit";
            formCategory.appendChild(send);
        }

    });
}

/*
* Expand and retract the topic list
*/
let showButton = document.querySelectorAll(".show");
let topicList = document.querySelectorAll(".topic");
if (topicList){
    for (let i = 0; i < showButton.length; i++){
        topicList[i].style.display = "none";
        showButton[i].addEventListener("click", (e)=>{
            if (e.target.nextElementSibling.style.display === "none"){
                e.target.nextElementSibling.style.display = "block";
                e.target.lastChild.className = "far fa-caret-square-down";
            }
            else{
                e.target.nextElementSibling.style.display = "none";
                e.target.lastChild.className = "far fa-caret-square-right";
            }
        });
    }
}

/* Add a comment */
let formComment = document.querySelector("#addComment form");
if (formComment){
    plusIcon.addEventListener("click", ()=>{
        if (formComment.childNodes.length < 1){
            let textAreaElement = document.createElement("textarea");
            textAreaElement.name = "content";
            textAreaElement.id = "content";
            textAreaElement.cols = 30;
            textAreaElement.rows = 10;
            formComment.appendChild(textAreaElement);

            let send = document.createElement("input");
            send.type = "submit";
            formComment.appendChild(send);
        }

    });
}

/* Edit a category */
let formDescription = document.querySelectorAll(".description form");
let editDescription = document.querySelectorAll(".category i.edit");
let oneEdit = 0;
if (formDescription){
    for (let i = 0; i < editDescription.length; i++){
        editDescription[i].addEventListener("click", (e)=>{
            for (let ii = 0; ii< formDescription.length; ii++){
                if (formDescription[ii].style.display === "block"){
                    oneEdit = 1;
                }
            }
            if (!oneEdit){
                let desc = e.target.parentNode.parentNode.parentNode.nextSibling.nextSibling.firstChild.nextSibling;
                let input = document.createElement("input");
                input.className = "descriptionInput";
                input.value = desc.innerHTML;
                input.name = "content";
                e.target.parentNode.remove();
                formDescription[i].appendChild(input);
                formDescription[i].style.display = "block";

                let idInput = document.createElement("input");
                idInput.name = "id";
                idInput.value = desc.dataset.id;
                idInput.type = "hidden";
                formDescription[i].appendChild(idInput);

                let send = document.createElement("input");
                send.type = "submit";
                send.value = "Modifier";
                formDescription[i].appendChild(send);
                desc.remove();
            }
        });
    }
}

/* Edit comment */
let editFormComment = document.querySelectorAll(".oneComment form");
let editComment = document.querySelectorAll(".oneComment i.edit");
if (editFormComment){
    for (let i = 0; i < editComment.length; i++){
        editComment[i].addEventListener("click", (e)=>{
            for (let ii = 0; ii< editFormComment.length; ii++){
                if (editFormComment[ii].style.display === "block"){
                    oneEdit = 1;
                }
            }
            if (!oneEdit){
                let content = e.target.parentNode.parentNode.parentNode.nextElementSibling;
                let input = document.createElement("input");
                input.className = "descriptionInput";
                input.value = content.innerHTML;
                input.name = "contentComment";
                content.remove();
                e.target.parentNode.remove();
                editFormComment[i].appendChild(input);
                editFormComment[i].style.display = "block";

                let idInput = document.createElement("input");
                idInput.name = "id";
                idInput.value = content.dataset.id;
                idInput.type = "hidden";
                editFormComment[i].appendChild(idInput);

                let send = document.createElement("input");
                send.type = "submit";
                send.value = "Modifier";
                editFormComment[i].appendChild(send);
            }
        });
    }
}

/* edit a topic */
let editFormTopic = document.querySelectorAll("#topicContainer form");
let editTopic = document.querySelectorAll("#topicContainer i.edit");
if (editFormTopic){
    for (let i = 0; i < editTopic.length; i++){
        editTopic[i].addEventListener("click", (e)=>{
            for (let ii = 0; ii< editFormTopic.length; ii++){
                if (editFormTopic[ii].style.display === "block"){
                    oneEdit = 1;
                }
            }
            if (!oneEdit){
                let content = e.target.parentNode.parentNode.nextSibling.nextSibling.nextSibling.nextSibling;
                let textarea = document.createElement("textarea");
                textarea.className = "contentText";
                textarea.value = content.innerHTML;
                textarea.name = "contentText";
                textarea.rows = 10;
                textarea.cols = 100;
                content.remove();
                e.target.parentNode.remove();
                editFormTopic[i].appendChild(textarea);
                editFormTopic[i].style.display = "block";

                let idInput = document.createElement("input");
                idInput.name = "id";
                idInput.value = content.dataset.id;
                idInput.type = "hidden";
                editFormTopic[i].appendChild(idInput);

                let send = document.createElement("input");
                send.type = "submit";
                send.value = "Modifier";
                editFormTopic[i].appendChild(send);
            }
        });
    }
}

/* change the pseudo */
let formAccount = document.querySelector("#containerAccountPage form");
let pseudo = document.querySelector("#pseudoButton");
let password = document.querySelector("#passwordButton");
if (formAccount){
    pseudo.addEventListener("click", (e)=>{
        if (formAccount.childNodes.length < 1){
            let inputName = document.createElement("input");
            inputName.name = "pseudo";
            inputName.className = "pButton";
            inputName.placeholder = "Nouveau pseudo";
            formAccount.appendChild(inputName);

            let send = document.createElement("input");
            send.type = "submit";
            send.value = "Modifier";
            formAccount.appendChild(send);


            e.target.nextElementSibling.remove();
            e.target.remove();
        }
    });

    password.addEventListener("click", (e)=>{
        if (formAccount.childNodes.length < 1){
            let inputPassword = document.createElement("input");
            inputPassword.name = "password";
            inputPassword.className = "pButton";
            formAccount.appendChild(inputPassword);
            inputPassword.placeholder = "Nouveau mot de passe";

            let send = document.createElement("input");
            send.type = "submit";
            send.value = "Modifier";
            formAccount.appendChild(send);

            e.target.previousSibling.previousSibling.remove();
            e.target.remove();
        }
    });

}

/* Add category list API */

const categoryAddOption = document.getElementById("category");

if (categoryAddOption){
    let xhrCategory = new XMLHttpRequest();
    xhrCategory.onload = function() {
        const category = JSON.parse(xhrCategory.responseText);
        category.forEach(category => {
            categoryAddOption.innerHTML += `
            <option value="${category.id}">${category.name}</option>
        `;
        });
    }

    xhrCategory.open('GET', '../src/api/addOptionAPI.php');
    xhrCategory.send();
}
console.log(process.cwd());