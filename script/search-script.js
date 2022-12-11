

function search(elem) {
    const searchValue = elem.value;
    const output = document.querySelector('#output');
    
    if (searchValue.length < 3) {
        // clearDropdown(dropdownBody)
        // dropdownBody.parentElement.classList.add('d-none')
        // return
        console.log("CLEAR");
        return;
    }
    
    axios
        .get(`./request/request.php?user=${searchValue}`)
        .then((data) => {
            console.log(data);
            // dropdownBody.parentElement.classList.remove('d-none')
            // clearDropdown(dropdownBody)
    
            // for (ingredient of data.data) {
            //     dropdownBody.append(createSearchResultOption(ingredient))
            // }
        })
        .catch((err) => console.error(err))
}
