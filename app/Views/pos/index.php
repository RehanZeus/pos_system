<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<style>
    /* 1. LAYOUT UTAMA (FIXED HEIGHT) */
    .pos-wrapper {
        height: calc(100vh - 100px); 
        overflow: hidden; 
        padding-bottom: 5px;
    }

    /* 2. CARD POS */
    .card-pos {
        height: 100%;
        border-radius: 8px; /* Radius dikurangi sedikit biar ga boros tempat */
        border: 1px solid #e0e0e0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        background: white;
    }

    /* 3. AREA SCROLL (PRODUK & KERANJANG) */
    .scroll-area {
        flex-grow: 1; /* Mengisi sisa ruang kosong */
        overflow-y: auto;
        padding: 10px;
        background-color: #f9f9f9;
    }
    
    /* Scrollbar Tipis */
    .scroll-area::-webkit-scrollbar { width: 5px; }
    .scroll-area::-webkit-scrollbar-track { background: #f1f1f1; }
    .scroll-area::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }

    /* 4. PRODUK CARD COMPACT */
    .product-card {
        cursor: pointer;
        transition: 0.1s;
        border: 1px solid #eee;
        border-radius: 6px;
        background: #fff;
    }
    .product-card:hover {
        border-color: #0d6efd;
        background-color: #f0f8ff;
    }

    /* Hapus panah input number */
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
        -webkit-appearance: none; margin: 0; 
    }
</style>

<div class="row g-2 pos-wrapper">
    
    <div class="col-md-7 h-100">
        <div class="card card-pos shadow-sm">
            <div class="card-header bg-white py-2 border-bottom">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control bg-light border-0 fw-bold" placeholder="Cari Produk / Scan Barcode..." autofocus autocomplete="off">
                </div>
            </div>

            <div id="productResults" class="scroll-area">
                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                    <i class="bi bi-upc-scan display-6 opacity-50 mb-2"></i>
                    <small class="fw-bold">Siap Transaksi</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-5 h-100">
        <div class="card card-pos shadow-sm">
            <div class="card-header bg-primary text-white py-2 d-flex justify-content-between align-items-center">
                <small class="fw-bold"><i class="bi bi-cart4 me-1"></i> Keranjang</small>
                <button onclick="resetCart()" class="btn btn-sm btn-outline-light border-0 py-0" style="font-size: 0.8rem;">
                    <i class="bi bi-trash"></i> Reset
                </button>
            </div>

            <div class="scroll-area p-0 bg-white">
                <table class="table table-sm table-striped align-middle mb-0">
                    <thead class="bg-light sticky-top shadow-sm">
                        <tr>
                            <th class="ps-2 py-2 small text-muted">Produk</th>
                            <th class="text-center py-2 small text-muted" width="15%">Qty</th>
                            <th class="text-end py-2 small text-muted pe-2">Subtotal</th>
                            <th width="5%"></th>
                        </tr>
                    </thead>
                    <tbody id="cartTableBody">
                        </tbody>
                </table>
            </div>

            <div class="card-footer bg-white border-top p-2">
                
                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <div class="p-2 rounded bg-primary text-white text-center">
                            <div class="small opacity-75" style="font-size: 10px;">TOTAL BAYAR</div>
                            <div class="fw-bold fs-5" id="grandTotalText">Rp 0</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-2 rounded bg-light border text-center">
                            <div class="small text-muted" style="font-size: 10px;">KEMBALIAN</div>
                            <div class="fw-bold fs-5 text-success" id="changeText">Rp 0</div>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted small ps-2">Tunai</span>
                    <input type="number" id="payInput" class="form-control fw-bold border-start-0" placeholder="0">
                    <button class="btn btn-success fw-bold px-4" onclick="processPayment()">
                        <i class="bi bi-printer-fill me-1"></i> PROSES
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalStruk" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-success text-white py-2">
                <small class="fw-bold">Transaksi Sukses</small>
                <button type="button" class="btn-close btn-close-white btn-sm" onclick="closeStruk()"></button>
            </div>
            <div class="modal-body p-0">
                <iframe id="strukFrame" style="width: 100%; height: 350px; border: none;"></iframe>
            </div>
            <div class="modal-footer p-1 flex-column">
                <button class="btn btn-primary w-100 btn-sm fw-bold mb-1" onclick="printStruk()">CETAK</button>
                <button class="btn btn-light w-100 btn-sm text-muted" onclick="closeStruk()">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    let cart = [];
    let bootstrapModalStruk;

    const searchInput = document.getElementById('searchInput');
    const productResults = document.getElementById('productResults');
    const cartTableBody = document.getElementById('cartTableBody');
    const grandTotalText = document.getElementById('grandTotalText');
    const payInput = document.getElementById('payInput');
    const changeText = document.getElementById('changeText');

    document.addEventListener('DOMContentLoaded', function() {
        const modalElem = document.getElementById('modalStruk');
        if (typeof bootstrap !== 'undefined' && modalElem) {
            bootstrapModalStruk = new bootstrap.Modal(modalElem);
        }
    });

    searchInput.addEventListener('keyup', function(e) {
        let keyword = this.value;
        if(e.key === 'Enter') { fetchProducts(keyword, true); } 
        else if(keyword.length > 1) { fetchProducts(keyword, false); }
        
        if(keyword.length === 0) {
            productResults.innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center h-100 text-muted">
                    <i class="bi bi-upc-scan display-6 opacity-50 mb-2"></i><small class="fw-bold">Siap Transaksi</small>
                </div>`;
        }
    });

    async function fetchProducts(keyword, autoAdd) {
        try {
            let response = await fetch(`<?= base_url('pos/search') ?>?term=${keyword}`);
            let data = await response.json();
            
            productResults.innerHTML = '<div class="row g-2">';
            let content = '';

            if(data.length === 0) {
                productResults.innerHTML = '<div class="text-center py-5 text-muted small">Tidak ditemukan</div>';
                return;
            }

            if(autoAdd && data.length > 0) {
                addToCart(data[0]);
                searchInput.value = ''; 
                return;
            }

            data.forEach(p => {
                content += `
                    <div class="col-md-4 col-6">
                        <div class="card product-card h-100" onclick='addToCart(${JSON.stringify(p)})'>
                            <div class="card-body text-center p-2">
                                <div class="fw-bold text-dark text-truncate small">${p.name}</div>
                                <div class="fw-bold text-primary my-1 small">Rp ${parseInt(p.price).toLocaleString('id-ID')}</div>
                                <div class="badge bg-light text-secondary border" style="font-size:9px">Stok: ${p.stock}</div>
                            </div>
                        </div>
                    </div>`;
            });
            productResults.innerHTML += content + '</div>';
        } catch (error) { console.error(error); }
    }

    function addToCart(product) {
        if(product.stock <= 0) return alert('Stok Habis!');
        let existingItem = cart.find(item => item.id == product.id);
        if(existingItem) {
            if(existingItem.qty + 1 > product.stock) return alert('Stok Maksimal!');
            existingItem.qty++;
        } else {
            cart.push({ id: product.id, name: product.name, price: parseInt(product.price), qty: 1, maxStock: parseInt(product.stock) });
        }
        renderCart();
    }

    function resetCart() {
        if(cart.length > 0 && confirm("Reset keranjang?")) { cart = []; payInput.value = ''; renderCart(); }
    }

    function renderCart() {
        cartTableBody.innerHTML = '';
        let total = 0;
        if(cart.length === 0) {
            cartTableBody.innerHTML = `<tr><td colspan="4" class="text-center py-5 text-muted small">Keranjang Kosong</td></tr>`;
        }
        cart.forEach((item, index) => {
            let subtotal = item.price * item.qty;
            total += subtotal;
            cartTableBody.innerHTML += `
                <tr>
                    <td class="ps-2"><div class="fw-bold text-dark" style="font-size:11px; line-height:1.2;">${item.name}</div></td>
                    <td class="text-center"><input type="number" class="form-control form-control-sm text-center border p-0" value="${item.qty}" min="1" max="${item.maxStock}" onchange="updateQty(${index}, this.value)" style="width: 35px; margin: auto; height: 25px; font-size:11px;"></td>
                    <td class="text-end fw-bold pe-2" style="font-size:11px;">${subtotal.toLocaleString()}</td>
                    <td class="text-center"><button class="btn btn-sm text-danger p-0" onclick="cart.splice(${index},1); renderCart()"><i class="bi bi-x"></i></button></td>
                </tr>`;
        });
        grandTotalText.innerText = 'Rp ' + total.toLocaleString('id-ID');
        calculateChange(total);
    }

    function updateQty(index, val) {
        let qty = parseInt(val);
        if(isNaN(qty) || qty < 1) qty = 1;
        if(qty > cart[index].maxStock) { qty = cart[index].maxStock; alert('Stok Mentok!'); }
        cart[index].qty = qty;
        renderCart();
    }

    payInput.addEventListener('input', () => {
        let total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        calculateChange(total);
    });

    function calculateChange(total) {
        let pay = parseInt(payInput.value) || 0;
        let change = pay - total;
        changeText.innerText = 'Rp ' + change.toLocaleString('id-ID');
        changeText.className = (pay > 0 && change < 0) ? 'fw-bold fs-5 text-danger' : 'fw-bold fs-5 text-success';
    }

    async function processPayment() {
        if(cart.length === 0) return alert("Keranjang kosong!");
        let total = cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        let pay = parseInt(payInput.value) || 0;
        if(pay < total) return alert("Uang kurang!");
        if(!confirm("Proses?")) return;

        try {
            let response = await fetch('<?= base_url('pos/processPayment') ?>', {
                method: 'POST', headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ cart, total, pay })
            });
            let result = await response.json();
            if(result.status === 'success') {
                document.getElementById('strukFrame').src = '<?= base_url('pos/struk') ?>/' + result.invoice;
                if (bootstrapModalStruk) bootstrapModalStruk.show();
            } else { alert(result.message); }
        } catch (error) { alert("Error koneksi"); }
    }

    function printStruk() {
        let frame = document.getElementById('strukFrame');
        frame.contentWindow.focus(); frame.contentWindow.print();
    }

    function closeStruk() {
        if (bootstrapModalStruk) bootstrapModalStruk.hide();
        cart = []; payInput.value = ''; renderCart(); searchInput.value = ''; searchInput.focus();
    }
</script>

<?= $this->endSection() ?>