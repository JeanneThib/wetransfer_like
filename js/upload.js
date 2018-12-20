// Déclaration des variable :
// fichier allant chercher le nom grace à son iD
// filename allant selectionner le nom grace à sa classe
var fichier = document.getElementById("fichier");  
var filename = document.querySelector(".filename");



// Ecouter lors du changement le fichier
fichier.addEventListener('change' , ()=>{
//filename est égale à la valeur du fichier
    filename.innerHTML = fichier.value;
// variable découpant le nom du filename au \ + 1 
    var extension=filename.innerHTML.substring(filename.innerHTML.lastIndexOf("\\") + 1,filename.innerHTML.length);
// filename est égale à la valeur de notre extension faite avant dans la variable 
    filename.innerHTML = extension;
});


