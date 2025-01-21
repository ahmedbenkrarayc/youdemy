const form = document.getElementById('form')

form.addEventListener('submit', (e) => {
    e.preventDefault()
    
    let title = document.getElementById('title').value
    let cover = document.getElementById('cover')
    let content = document.getElementById('content')
    let category = document.getElementById('category').value
    let type = document.getElementById('type').value
    let description = document.getElementById('description').value
    
    let formInputs = [
        { type: "string", value: title, name: "Title", minChars: 3 },
        { type: "range", value: type, name: "Type", range: ['video', 'document']},
        { type: "number", value: category, name: "Category" },
        // { type: "string", value: description, name: "Description", minChars: 200 }
    ]

    if(!cover.getAttribute('attrequired')){
        formInputs.push({ type: "image", value: cover, name: "Cover" })
    }

    if(!content.getAttribute('attrequired')){
        formInputs.push({ type: type, value: content, name: "Content" })
    }

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