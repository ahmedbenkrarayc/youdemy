const form = document.getElementById('form')

form.addEventListener('submit', (e) => {
    e.preventDefault()
    let email = document.getElementById('email').value
    let password = document.getElementById('password').value
    let formInputs = [
        { type: "email", value: email, name: "Email" },
        { type: "string", value: password, name: "Password", minChars: 8 }
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