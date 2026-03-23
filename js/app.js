const API = "http://localhost/cosmetic-shop/backend/api";

/* ================= PRODUITS ================= */

// Ajouter produit
document.getElementById("productForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const data = {
        name: document.getElementById("name").value,
        brand: document.getElementById("brand").value,
        category: document.getElementById("category").value,
        shade: document.getElementById("shade").value,
        skin: document.getElementById("skin").value,
        expiry: document.getElementById("expiry").value,
        quantity: document.getElementById("quantity").value
    };

    await fetch(`${API}/products.php`, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(data)
    });

    loadProducts();
    e.target.reset();
});

// Charger produits
async function loadProducts() {
    const res = await fetch(`${API}/products.php`);
    const products = await res.json();

    const table = document.getElementById("productTable");
    if (!table) return;

    table.innerHTML = "";

    products.forEach(p => {
        table.innerHTML += `
        <tr>
            <td>${p.name}</td>
            <td>${p.brand}</td>
            <td>${p.category}</td>
            <td>${p.quantity}</td>
            <td>${p.expiry}</td>
        </tr>`;
    });
}

loadProducts();


/* ================= CLIENTS ================= */

// Ajouter client
document.getElementById("clientForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const data = {
        name: document.getElementById("clientName").value,
        phone: document.getElementById("phone").value,
        skin_type: document.getElementById("skinType").value
    };

    await fetch(`${API}/clients.php`, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(data)
    });

    loadClients();
    e.target.reset();
});

// Charger clients
async function loadClients() {
    const res = await fetch(`${API}/clients.php`);
    const clients = await res.json();

    const table = document.getElementById("clientTable");
    if (!table) return;

    table.innerHTML = "";

    clients.forEach(c => {
        table.innerHTML += `
        <tr>
            <td>${c.name}</td>
            <td>${c.phone}</td>
            <td>${c.skin_type}</td>
            <td>${c.points}</td>
        </tr>`;
    });
}

loadClients();


/* ================= VENTES ================= */

// Charger produits et clients dans select
async function loadOptions() {
    const products = await (await fetch(`${API}/products.php`)).json();
    const clients = await (await fetch(`${API}/clients.php`)).json();

    const productInput = document.getElementById("product");
    const clientInput = document.getElementById("client");

    if(productInput){
        productInput.innerHTML = products.map(p =>
            `<option value="${p.id}">${p.name}</option>`
        ).join("");
    }

    if(clientInput){
        clientInput.innerHTML = clients.map(c =>
            `<option value="${c.id}">${c.name}</option>`
        ).join("");
    }
}

loadOptions();

// Ajouter vente
document.getElementById("saleForm")?.addEventListener("submit", async (e) => {
    e.preventDefault();

    const qty = document.getElementById("qty").value;
    const price = document.getElementById("price").value;

    const data = {
        product_id: document.getElementById("product").value,
        client_id: document.getElementById("client").value,
        quantity: qty,
        total: qty * price
    };

    await fetch(`${API}/sales.php`, {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify(data)
    });

    alert("Vente enregistrée !");
});


/* ================= DASHBOARD ================= */

async function loadStats() {
    const res = await fetch(`${API}/stats.php`);
    const stats = await res.json();

    if(document.getElementById("revenue")){
        document.getElementById("revenue").innerText =
            (stats.revenue || 0) + " FCFA";
    }
}

loadStats();

async function loadChart(){
    const res = await fetch(`${API}/stats.php`);
    const data = await res.json();

    const ctx = document.getElementById('salesChart');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.topProducts.map(p=>p.name),
            datasets: [{
                label: 'Ventes',
                data: data.topProducts.map(p=>p.total)
            }]
        }
    });
}

loadChart();

async function checkAlerts(){
    const res = await fetch(`${API}/alerts.php`);
    const alerts = await res.json();

    if(alerts.length > 0){
        alert("⚠️ Produits à vérifier !");
    }
}

checkAlerts();