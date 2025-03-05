document.addEventListener("DOMContentLoaded", () => {
    const links = document.querySelectorAll(".semester-link");
    const tables = document.querySelectorAll(".table-container");

    links.forEach(link => {
        link.addEventListener("click", (e) => {
            e.preventDefault(); // Mencegah tautan default
            const semester = link.getAttribute("data-semester");

            // Sembunyikan semua tabel
            tables.forEach(table => table.style.display = "none");

            // Tampilkan tabel sesuai semester
            const selectedTable = document.getElementById(`semester-${semester}`);
            if (selectedTable) {
                selectedTable.style.display = "block";
            }
        });
    });
});
