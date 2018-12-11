const btnEnvoi = document.querySelector('#envoi');

btnEnvoi.addEventListener('click', (e) => {
    e.preventDefault();
    
    let mail = document.querySelector('#mail').value;
    console.log(mail);

    fetch(`controller/mail.php?envoi=${mail}`)
        .then((res) => {
            return res.text()
        })
        .then((res) => {
            console.log(res);
        })

});