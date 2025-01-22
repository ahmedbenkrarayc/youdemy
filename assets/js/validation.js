window.validateForm = (inputs) => {
    const errors = []
  
    inputs.forEach((input) => {
      const { type, value, name, minChars, range } = input
  
      if(type === "email") {
        const emailRegex = /\S+@\S+\.\S+/
        if (!emailRegex.test(value)){
          errors.push(`${name} must be a valid email.`)
        }
      }else if(type === "string"){
          if (typeof value != "string" || value.trim() === "") {
            errors.push(`${name} must be a non-empty string.`)
          }else if(minChars && value.trim().length < minChars) {
          errors.push(`${name} must have at least ${minChars} characters.`)
        }
      }else if(type === "number"){
        if (isNaN(value) || value.trim() === ""){
          errors.push(`${name} must be a valid number.`)
        }
      }else if(type === 'range'){
        if(!range.includes(value.toLowerCase())){
          errors.push(`${name} must be one of these values ${range.join(', ')}.`)
        }
      }else if(type === "image"){
        if(!value.value){
          errors.push(`${name} is required and must be an image.`)
        }else if(!/\.(jpg|jpeg|png|gif|bmp)$/i.test(value.files[0].name)) {
          errors.push(`${name} must be a valid image file (jpg, jpeg, png, gif, bmp).`)
        }
      }else if(type === "video"){
        if(!value.value){
          errors.push(`${name} is required and must be a video.`)
        }else if(!/\.(mp4|avi|mkv|mov|wmv)$/i.test(value.files[0].name)) {
          errors.push(`${name} must be a valid video file (.mp4, .avi, .mkv, .mov, .wmv).`)
        }
      }else if(type === "document"){
        if(!value.value){
          errors.push(`${name} is required and must be a document.`)
        }else if(!/\.(pdf|doc|docx|txt)$/i.test(value.files[0].name)) {
          errors.push(`${name} must be a valid document (.pdf, .doc, .docx, .txt).`)
        }
      }
    })
  
    return errors.length ? errors : null
}