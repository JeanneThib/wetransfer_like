link = document.querySelector(".link");
buttonLink = document.querySelector(".buttonLink");
copied = document.querySelector(".copied");

function copie() {
    let range = document.createRange();
    range.selectNodeContents(link); 
    window.getSelection().removeAllRanges();
    window.getSelection().addRange(range);
    document.execCommand("copy");
    window.getSelection().removeAllRanges();
}

buttonLink.addEventListener("click", () => {
    copie();
    copied.innerHTML = "Lien copié";
})
