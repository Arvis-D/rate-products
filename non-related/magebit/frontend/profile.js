var add = document.getElementsByClassName("edit")[0];
var edit = document.getElementsByClassName("edit")[1];

function exit(name){
    if(name == "add"){
        add.style.display = "none";
    }
    else{
        edit.style.display = "none";
    }
}

function showAdd(){
    add.style.display = "block";
}
function showEdit(id){
    edit.style.display = "block";
    document.getElementById("edit-attr-id").value = id;
}