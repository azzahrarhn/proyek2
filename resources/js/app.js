let mataPelajaran = [];

function updateSidebar() {
    const sidebar = document.getElementById("nilai-siswa-nav");
    sidebar.innerHTML = "";

    mataPelajaran.forEach((mp) => {
        const li = document.createElement("li");
        li.innerHTML = `
            <a href="#${mp.id}">
                <i class="bi bi-circle"></i>
                <span>${mp.name}</span>
            </a>
        `;
        sidebar.appendChild(li);
    });
}

function tambahMataPelajaran(name) {
    const id = name.toLowerCase().replace(/\s+/g, "_");
    mataPelajaran.push({ id, name });
    updateSidebar();
}

// Inisialisasi
updateSidebar();
