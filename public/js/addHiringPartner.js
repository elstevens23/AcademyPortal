let getCompletedFormData = () => {
    let formData = document.querySelectorAll(".submitHiringPartner")
    let data = {}
    formData.forEach(formItem=> {
        data[formItem.name] = formItem.value
    })
    return data
}

let makeApiRequest = async(data) => {
    return fetch('/api/createHiringPartner', {
        credentials: 'same-origin',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
        },
        method: 'post',
        body: JSON.stringify(data)
    })
        .then(response => response.json())
        .then((data) => {
            if (data.success) {
                document.getElementById('.successMsg').innerHTML = '<p>Hiring Partner successfully added</p>'
            } else {
                document.getElementById('.successMsg').innerHTML = '<p>Hiring Partner not added</p>'
            }
        })

}

document.getElementById('submitHiringPartner').addEventListener('click', e => {
    e.preventDefault()
    let data = getCompletedFormData()
    let validate = validateForm(data)
    if(validate) {
        makeApiRequest(data)
    }
})