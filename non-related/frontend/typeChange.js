var type = document.getElementsByTagName("select")[0];
var disk = document.getElementsByClassName("disk");
var furniture = document.getElementsByClassName("furniture");
var book = document.getElementsByClassName("book");
var typeSpecific = {"book": book, "furniture": furniture, "disk": disk};

function change(){
    var value = type.options[type.selectedIndex].value;

    for(let key in typeSpecific){
        Array.from(typeSpecific[key], e =>{
            e.style.display = "none";
        })
    }
    
    Array.from(typeSpecific[value], e=>{
        e.style.display = "block";
    })
}