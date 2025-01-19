const form = document.getElementById('form')

form.addEventListener('submit', (e) => {
    e.preventDefault()
    let name = document.getElementById('name').value
    let formInputs = [
        { type: "string", value: name, name: "Name", minChars: 3 }
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