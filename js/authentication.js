const connexion = document.querySelector("#connexion");
const login = document.querySelector("#login");
const pass = document.querySelector("#pass");


connexion.addEventListener("click", () => {
    // console.log(login.value);
    // console.log(pass.value);

    let data = new FormData();
    data.append("login", login.value);
    data.append("pass", pass.value);

    fetch("/wetransfer_like/admin/verifForm", {method: "POST", body: data})
    .then( (result) => { return result.json() } )
    .then( (result) => {
        // console.log(result.error);
        if(!result.error){
            window.location.replace("/wetransfer_like/dashboard");
        } else {
            document.querySelector("#error").innerHTML = result.error;
        }
    });
})
