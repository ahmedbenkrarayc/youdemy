const articlesContainer = document.getElementById('articlesContainer')
const keyword = document.getElementById('keyword')
const category = document.getElementById('category')
const form = document.getElementById('form')
const clear = document.getElementById('reset')

let data = []
let filteredData = []

const getArticles = async () => {
    try{
        const response = await fetch('/requests/courses.php')
        const res = await response.json()
        if(res.success){
            data = res.data
        }
    }catch(err){
        console.error(err)
    }
}

const display = (data) => {
    articlesContainer.innerHTML = ''
    data.forEach((item) => {
        articlesContainer.innerHTML += `
        <div class="col-sm-6 col-lg-4">
            <div class="card card-sm">
                <a href="./views/course.php?id=${item.id}" class="d-block"><img style="height: 176px;" src="${item.cover}"></a>
                <div class="card-body">
                <div class="d-flex align-items-center">
                    <div>
                    <div>${item.title}</div>
                    <div class="text-secondary">${item.TYPE}</div>
                    <div class="text-secondary">${item.teacher_fname+' '+item.teacher_lname}</div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        `
    })
}

const initializePagination = () => {
    $(paginationContainer).pagination({
        dataSource: filteredData,
        pageSize: 10,
        callback: function (data, pagination) {
            display(data);
        },
    });
};

const filter = () => {
    filteredData = [...data]

    if(category.value != 'all')
        filteredData = filteredData.filter((item) => item.category_id == category.value)
    else
        filteredData = [...data]
    if(keyword.value.trim() != '')
        filteredData = filteredData.filter((item) => item.title.toLowerCase().includes(keyword.value.toLowerCase()) || item.description.toLowerCase().includes(keyword.value.toLowerCase()) || (item.teacher_fname.toLowerCase()+' '+item.teacher_lname.toLowerCase()).includes(keyword.value.toLowerCase()))
}

const reset = () => {
    keyword.value = ''
    category.value = 'all'
}

(async () => {
    await getArticles()
    filteredData = [...data]
    initializePagination()

    form.addEventListener('submit', (e) => {
        e.preventDefault()
        filter()
        initializePagination()
    })

    clear.addEventListener('click', reset)
})()