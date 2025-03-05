// Ambil elemen hamburger dan sidebar
const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementsByClassName('sidebar')[0];

// Event listener untuk toggle sidebar
hamburger.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    document.body.classList.toggle('sidebar-active');
});

// document.querySelector('.add-button').addEventListener('click', () => {
//     alert('Tambah Kalender Akademik!');
// });

// document.getElementById('addbutton').addEventListener('click', function() {
//     document.getElementById('fileinput').click();
// });

document.getElementById('fileinput').addEventListener('change', function() {
    document.getElementById('file').submit();
    
})



const checkboxes = document.querySelectorAll('input[type="checkbox"]');
checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', () => {
        if (checkbox.checked) {
            console.log('Checkbox checked:', checkbox.parentElement.nextElementSibling.textContent);
        } else {
            console.log('Checkbox unchecked');
        }
    });
});