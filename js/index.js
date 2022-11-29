function onclick() {
    alert('Clicked');
}

function expand(id) {
    if (id == '') return
    let childUl = document.querySelector('#' + id + '>ul')
    for (let li of childUl.children) {

        if (li.style.display == 'list-item') {
            li.style.display = 'none'
        } else if (li.style.display == 'none') {
            li.style.display = 'list-item'
        }


    }
}

function buscar(parent = document.querySelector('#menu-0').children){
    let query = document.getElementById('search').value
    for (let child of parent) {
        if (!child.innerText.includes(query)){
            child.classList.add('is-hidden')
            if (child.children != null){
                buscar(child.children);
            }
        }else{
            child.classList.remove('is-hidden')
            if (child.children != null){
                buscar(child.children);
            }
        }
    }
}

function checkAllChildren(id) {
    let parent = document.querySelector('#' + id + '>ul');
    let children = parent.children;

    for (let child of children) {
        let checkbox = child.querySelector('input');
        if (checkbox.checked) {
            checkbox.checked = false
        } else {
            checkbox.checked = true;
        }

        if (child.id != ''){
            checkAllChildren(child.id)
        }
    }
}

function collapseAll() {
    let folders = document.querySelectorAll('[id^=li]>ul>li')
    for (let folder of folders) {
        folder.style.display = 'none'
    }
}