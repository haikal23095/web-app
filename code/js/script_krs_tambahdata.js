// Ambil elemen hamburger dan sidebar
const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementsByClassName('sidebar')[0];

// Event listener untuk toggle sidebar
hamburger.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    document.body.classList.toggle('sidebar-active');
});

document.getElementById('mataKuliahForm').addEventListener('submit', function(event) {
    event.preventDefault();
    alert('Data mata kuliah berhasil ditambahkan!');
});
