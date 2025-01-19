const form = document.getElementById('form')

form.addEventListener('submit', (e) => {
    e.preventDefault()
    let fname = document.getElementById('fname').value
    let lname = document.getElementById('lname').value
    let email = document.getElementById('email').value
    let password = document.getElementById('password').value
    let role = document.getElementById('role').value
    let formInputs = [
        { type: "string", value: fname, name: "First name", minChars: 3 },
        { type: "string", value: lname, name: "Last name", minChars: 3 },
        { type: "email", value: email, name: "Email" },
        { type: "string", value: password, name: "Password", minChars: 8 },
        { type: "range", value: role, name: "Role", range: ['etudiant', 'enseignant']}
    ]

    const validation = window.validateForm(formInputs)
    if(!validation){
        form.submit()
    }else{
        document.getElementById('errors').style.display = 'block'
        document.getElementById('errors').firstElementChild.innerHTML = ''
        validation.forEach(item => {
            document.getElementById('errors').firstElementChild.innerHTML += `<li>${item}</li>`
        })
    }
})