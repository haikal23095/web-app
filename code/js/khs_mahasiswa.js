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

// Ambil elemen tombol "Lihat" dan tabel
const lihatButton = document.querySelector('.khs');
const tableKhs = document.getElementById('table-khs');
// Tambahkan event listener ke tombol "Lihat"
lihatButton.addEventListener('click', function (event) {
    event.preventDefault(); // Mencegah reload halaman
    tableKhs.style.display = 'block'; // Tampilkan tabel
});

lihatButton.addEventListener('click', function (event) {
    event.preventDefault();

    // Ambil nilai semester yang dipilih
    const semester = document.getElementById('semester').value;
    console.log("Semester yang dipilih:", semester);

    // Anda dapat melakukan manipulasi tambahan di sini
    tableKhs.style.display = 'block'; // Tampilkan tabel
});

lihatButton.addEventListener('click', async function (event) {
    event.preventDefault();

    const semester = document.getElementById('semester').value;

    // Kirim data ke server menggunakan fetch
    const response = await fetch('khs_mahasiswa.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ semester: semester })
    });

    const data = await response.json(); // Asumsikan server mengembalikan JSON
    console.log(data);

    // Contoh: Update tabel berdasarkan data yang diterima
    const tableBody = tableKhs.querySelector('table tbody');
    tableBody.innerHTML = ''; // Kosongkan tabel

    data.forEach(row => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${row.kode}</td>
            <td>${row.matakuliah}</td>
            <td>${row.kelas}</td>
            <td>${row.sks}</td>
            <td>${row.nilai}</td>
        `;
        tableBody.appendChild(tr);
    });

    tableKhs.style.display = 'block'; // Tampilkan tabel
});

document.getElementById('semesterForm').addEventListener('submit', function (e) {
    const semester = document.getElementById('semester').value;
    if (!semester) {
        e.preventDefault();
        alert('Silakan pilih semester terlebih dahulu.');
    }
});
