// Ambil elemen hamburger dan sidebar
const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementsByClassName('sidebar')[0];

// Event listener untuk toggle sidebar
hamburger.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    document.body.classList.toggle('sidebar-active');
});

const clickProfile = document.getElementsByClassName('avatar')[0]
clickProfile.addEventListener('click', function(){
    window.location.href = 'profile_admin.php';
})
