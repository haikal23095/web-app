// Ambil elemen hamburger dan sidebar
const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementsByClassName('sidebar')[0];

// Event listener untuk toggle sidebar
hamburger.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    document.body.classList.toggle('sidebar-active');
});

document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("proposal-skripsi").addEventListener("change", function () {
        const fileNameSpan = document.getElementById("file-name");
        const fileName = this.files.length > 0 ? this.files[0].name : "Tidak ada file yang dipilih";
        fileNameSpan.textContent = fileName;
    });
});
