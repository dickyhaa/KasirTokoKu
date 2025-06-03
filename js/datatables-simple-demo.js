window.addEventListener('DOMContentLoaded', event => {
    // Simple Datatables
    //  This script initializes a simple DataTable on an HTML element with the ID 'datatablesSimple'.

    const datatablesSimple = document.getElementById('datatablesSimple');
    if (datatablesSimple) {
        new simpleDatatables.DataTable(datatablesSimple);
    }
});
