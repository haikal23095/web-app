// Ambil elemen hamburger dan sidebar
const hamburger = document.getElementById("hamburger");
const sidebar = document.getElementsByClassName('sidebar')[0];

// Event listener untuk toggle sidebar
hamburger.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    document.body.classList.toggle('sidebar-active');

    function previewAndSubmit(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePhoto').src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Auto-submit the form
            const form = event.target.closest('form');
            setTimeout(() => {
                form.submit();
            }, 500); // Delay to ensure the preview updates
        }
    }
});
