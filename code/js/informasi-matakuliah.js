// Ambil elemen hamburger dan sidebar
const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementsByClassName('sidebar')[0];

// Event listener untuk toggle sidebar
hamburger.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    document.body.classList.toggle('sidebar-active');
});

const tables_matakuliah = document.getElementsByClassName('table-matakuliah');
const array_tables_matakuliah = Array.from(tables_matakuliah);

function dropdownClick(className, action) {
    const dropdowns_matakuliah = document.getElementsByClassName('dropdown-matakuliah');

    const array_dropdown_matakuliah =   Array.from(dropdowns_matakuliah)
    for(let item = 0; item < array_dropdown_matakuliah.length; item++) {
        const originalText = dropdowns_matakuliah[item].textContent;
        dropdowns_matakuliah[item].addEventListener('click', (e) => {
            e.target.textContent = e.target.textContent === '▼' ? originalText : '▼';
            const table = array_tables_matakuliah[item];
            table.classList.toggle('active');
            
        });
};
};

dropdownClick('dropdown-matakuliah', 'click');

