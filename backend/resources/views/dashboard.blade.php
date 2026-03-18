<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Obsidian OS Mini - Constructor Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --secondary: #a855f7;
            --bg: #f8fafc;
            --card: #ffffff;
            --text: #1e293b;
        }
        body { font-family: 'Outfit', sans-serif; background: var(--bg); color: var(--text); margin: 0; min-height: 100vh; }
        
        #loginOverlay { position: fixed; inset: 0; background: #f1f5f9; z-index: 1000; display: flex; align-items: center; justify-content: center; padding: 20px; }
        .login-card { background: white; padding: 50px 40px; border-radius: 30px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.1); width: 100%; max-width: 400px; text-align: center; }
        
        .admin-nav { background: white; padding: 20px 40px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 2px 15px rgba(0,0,0,0.03); }
        .logo-brand { font-size: 22px; font-weight: 800; background: linear-gradient(to right, var(--primary), var(--secondary)); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        
        .container { max-width: 1100px; margin: 50px auto; padding: 0 20px; }
        
        .dashboard-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; }
        .project-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 25px; }
        .project-card { background: white; padding: 30px; border-radius: 24px; border: 1px solid #e2e8f0; transition: all 0.3s; }
        .project-card:hover { transform: translateY(-8px); border-color: var(--primary); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.05); }
        .project-card h3 { margin: 0 0 10px; font-size: 20px; font-weight: 700; }
        .project-card .slug { color: #64748b; font-size: 13px; margin-bottom: 25px; font-family: 'Courier New', monospace; background: #f1f5f9; padding: 5px 10px; border-radius: 8px; }
        
        #editorView { display: none; background: white; padding: 50px; border-radius: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); border: 1px solid #e2e8f0; }
        .editor-header { display: flex; align-items: center; gap: 20px; margin-bottom: 40px; }
        
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px; }
        .form-group { margin-bottom: 25px; position: relative; }
        label { display: block; font-weight: 700; margin-bottom: 12px; font-size: 14px; color: #334155; }
        input, select { width: 100%; padding: 15px 20px; border: 1.5px solid #e2e8f0; border-radius: 16px; font-size: 15px; transition: all 0.2s; background: #fff; box-sizing: border-box; }
        input:focus { border-color: var(--primary); outline: none; box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1); }
        
        .btn { padding: 15px 30px; border-radius: 18px; border: none; cursor: pointer; font-weight: 700; display: inline-flex; align-items: center; justify-content: center; gap: 10px; transition: all 0.2s; font-size: 15px; box-sizing: border-box; }
        .btn-primary { background: var(--primary); color: white; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.3); }
        .btn-primary:hover { transform: translateY(-2px); background: #4f46e5; }
        .btn-secondary { background: #f1f5f9; color: #475569; }
        .btn-secondary:hover { background: #e2e8f0; }
        .btn-danger { background: #fee2e2; color: #ef4444; }
        .btn-danger:hover { background: #fecaca; }
        
        .link-item { 
            background: #ffffff; 
            padding: 25px; 
            border-radius: 24px; 
            margin-bottom: 20px; 
            display: grid; 
            grid-template-columns: 1fr 1fr 1fr auto; 
            gap: 20px; 
            align-items: end; 
            border: 1.5px solid #e2e8f0; 
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        }
        
        .hidden { display: none !important; }
        h3 { 
            margin-top: 50px; 
            margin-bottom: 25px;
            border-bottom: 2px solid #f1f5f9; 
            padding-bottom: 15px; 
            font-weight: 800; 
            color: #0f172a; 
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>
<body>

<!-- Login Overlay (Removed for Laravel Auth) -->

<nav class="admin-nav">
    <div class="logo-brand">Obsidian OS Mini</div>
    <div id="navActions">
        <button class="btn btn-secondary" onclick="showDashboard()"><i class="fa-solid fa-house"></i> Dashbord</button>
        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button class="btn btn-danger" type="submit"><i class="fa-solid fa-right-from-bracket"></i> Chiqish</button>
        </form>
    </div>
</nav>

<div class="container">
    <!-- Dashboard View -->
    <div id="dashboardView">
        <div class="dashboard-header">
            <h2>Loyihalar Dashbordi</h2>
            <button class="btn btn-primary" onclick="createNewProject()"><i class="fa-solid fa-plus"></i> Yangi Vizitka</button>
        </div>
        <div id="projectGrid" class="project-grid">
            <!-- Loyihalar shu yerga tushadi -->
            <div style="grid-column: 1/-1; text-align: center; color: #64748b;">Firebase UI yuklanmoqda...</div>
        </div>
    </div>

    <!-- Editor View -->
    <div id="editorView">
        <div class="editor-header">
            <button class="btn btn-secondary" onclick="showDashboard()"><i class="fa-solid fa-arrow-left"></i></button>
            <h2 id="editorTitle">Yangi Vizitka</h2>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Loyiha Slugi (URL manzili uchun):</label>
                <input type="text" id="projectSlug" placeholder="masalan: delta-edu">
            </div>
            <div class="form-group">
                <label>Kompaniya Nomi:</label>
                <input type="text" id="companyName">
            </div>
            <div class="form-group">
                <label>Kasbi / Slogon:</label>
                <input type="text" id="subtitle">
            </div>
            <div class="form-group">
                <label>Logo (Fayl yoki URL):</label>
                <div style="display: flex; gap: 10px;">
                    <input type="text" id="logoUrl" placeholder="Rasm manzili..." style="flex: 1;">
                    <input type="file" id="logoUpload" style="display: none;" onchange="handleFileUpload(this)">
                    <button class="btn btn-secondary" onclick="document.getElementById('logoUpload').click()"><i class="fa-solid fa-upload"></i></button>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label>Mavzu Rangini tanlang:</label>
            <select id="themeSelect">
                <option value="linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%)">Binafsha-Havorang</option>
                <option value="linear-gradient(135deg, #1e293b 0%, #0f172a 100%)">Dark Night</option>
                <option value="linear-gradient(135deg, #f093fb 0%, #f5576c 100%)">Warm Flame</option>
                <option value="linear-gradient(135deg, #5ee7df 0%, #b490ca 100%)">Ocean Soft</option>
                <option value="linear-gradient(135deg, #fa709a 0%, #fee140 100%)">Sunset Glow</option>
            </select>
        </div>

        <h3 style="margin-top: 30px;"><i class="fa-brands fa-telegram"></i> Telegram Ariza Formasi</h3>
        <div class="form-grid">
            <div class="form-group">
                <label>Bot Tokeni (BotFather'dan olingan):</label>
                <input type="text" id="tgToken" placeholder="123456:ABC-DEF1234ghIkl-zyx57W2v1u123ew11">
            </div>
            <div class="form-group">
                <label>Chat ID (Arizalar boradigan guruh yoki shaxsiy ID):</label>
                <input type="text" id="tgChatId" placeholder="masalan: 831047629">
            </div>
        </div>

        <h3 style="margin-top: 30px;"><i class="fa-solid fa-images"></i> Portfolio Galereyasi</h3>
        <div class="form-group">
            <div style="display: flex; gap: 10px; align-items: center;">
                <input type="file" id="portfolioUpload" style="display: none;" multiple onchange="handlePortfolioUpload(this)">
                <button class="btn btn-secondary" onclick="document.getElementById('portfolioUpload').click()">
                    <i class="fa-solid fa-upload"></i> Rasmlar yuklash
                </button>
            </div>
            <div id="portfolioContainer" style="display: flex; gap: 10px; margin-top: 15px; flex-wrap: wrap;"></div>
        </div>

        <h3>Xizmatlar</h3>
        <div id="servicesContainer"></div>
        <button class="btn btn-secondary" onclick="addService()" style="width: 100%; margin: 10px 0;"><i class="fa-solid fa-cart-plus"></i> Xizmat qo'shish</button>

        <h3 style="margin-top: 30px;"><i class="fa-brands fa-google"></i> SEO Sozlamalari (Google uchun)</h3>
        <div class="form-group">
            <label>Sayt tavsifi (Description - 160 harfgacha):</label>
            <input type="text" id="seoDesc" placeholder="Masalan: Samarqandda sifatli ta'lim va viza xizmatlari...">
        </div>
        <div class="form-group">
            <label>Kalit so'zlar (Keywords - vergul bilan):</label>
            <input type="text" id="seoKeywords" placeholder="viza, ta'lim, kurslar, samarqand...">
        </div>

        <h3><i class="fa-solid fa-star"></i> Mijozlar Sharhlari</h3>
        <div id="testimonialsContainer"></div>
        <button class="btn btn-secondary" onclick="addTestimonial()" style="width: 100%; margin: 10px 0;">
            <i class="fa-solid fa-plus"></i> Sharh qo'shish
        </button>

        <h3><i class="fa-solid fa-circle-question"></i> Ko'p Beriladigan Savollar (FAQ)</h3>
        <div id="faqContainer"></div>
        <button class="btn btn-secondary" onclick="addFaq()" style="width: 100%; margin: 10px 0;">
            <i class="fa-solid fa-plus"></i> Savol-Javob qo'shish
        </button>

        <h3>Aloqa Linklari</h3>
        <div id="linksContainer"></div>
        <button class="btn btn-secondary" onclick="addLink()" style="width: 100%; margin: 10px 0;"><i class="fa-solid fa-plus"></i> Link qo'shish</button>

        <div style="display: flex; gap: 15px; margin-top: 30px;">
            <button class="btn btn-primary" style="flex: 2;" onclick="saveProject()"><i class="fa-solid fa-floppy-disk"></i> Loyihani saqlash</button>
            <button class="btn btn-danger" onclick="deleteProject()"><i class="fa-solid fa-trash"></i> O'chirish</button>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    let projects = {};
    let currentSlug = null;
    let currentLinks = [];
    let currentServices = [];
    let currentPortfolio = [];
    let currentTestimonials = [];
    let currentFaqs = [];

    // Ma'lumotlarni API'dan olish
    async function loadProjects() {
        try {
            const res = await fetch('/projects', { headers: { 'Accept': 'application/json' } });
            projects = await res.json();
            if (document.getElementById('dashboardView').style.display !== 'none') {
                renderProjectGrid();
            }
        } catch (e) {
            console.error("Xatolik", e);
        }
    }
    
    // Initial Load
    loadProjects();

    const iconMap = { telegram: 'Telegram', instagram: 'Instagram', phone: 'Telefon', website: 'Sayt', location: 'Manzil' };

    function showDashboard() {
        document.getElementById('dashboardView').style.display = 'block';
        document.getElementById('editorView').style.display = 'none';
        renderProjectGrid();
    }

    function renderProjectGrid() {
        const grid = document.getElementById('projectGrid');
        grid.innerHTML = '';
        Object.keys(projects).forEach(slug => {
            const p = projects[slug];
            grid.innerHTML += `
                <div class="project-card">
                    <h3>${p.companyName || 'Nomsiz Loyiha'}</h3>
                    <div class="slug">/v/${slug}</div>
                    
                    <div style="display: flex; gap: 15px; margin-bottom: 20px; background: #f8fafc; padding: 10px; border-radius: 12px;">
                        <div style="font-size: 14px; color: #475569;">
                            <i class="fa-solid fa-eye" style="color: var(--primary);"></i> Ko'rishlar: <b>${p.views || 0}</b>
                        </div>
                        <div style="font-size: 14px; color: #475569;">
                            <i class="fa-solid fa-hand-pointer" style="color: var(--secondary);"></i> Bosishlar: <b>${p.clicks || 0}</b>
                        </div>
                    </div>

                    <div style="display: flex; gap: 10px;">
                        <button class="btn btn-secondary" onclick="editProject('${slug}')"><i class="fa-solid fa-pen"></i> Tahrirlash</button>
                        <a href="/v/${slug}" target="_blank" class="btn btn-primary"><i class="fa-solid fa-eye"></i></a>
                    </div>
                </div>
            `;
        });
        if(Object.keys(projects).length === 0) grid.innerHTML = '<div style="grid-column: 1/-1; text-align: center; color: #64748b;">Hozircha loyihalar yoq...</div>';
    }

    function createNewProject() {
        currentSlug = null;
        currentLinks = [];
        currentServices = [];
        document.getElementById('projectSlug').disabled = false;
        document.getElementById('projectSlug').value = '';
        document.getElementById('companyName').value = '';
        document.getElementById('subtitle').value = '';
        document.getElementById('logoUrl').value = '';
        document.getElementById('themeSelect').value = 'linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%)';
        document.getElementById('linksContainer').innerHTML = '';
        document.getElementById('servicesContainer').innerHTML = '';
        document.getElementById('portfolioContainer').innerHTML = '';
        currentPortfolio = [];
        document.getElementById('tgToken').value = '';
        document.getElementById('tgChatId').value = '';
        document.getElementById('seoDesc').value = '';
        document.getElementById('seoKeywords').value = '';
        document.getElementById('testimonialsContainer').innerHTML = '';
        currentTestimonials = [];
        document.getElementById('faqContainer').innerHTML = '';
        currentFaqs = [];
        document.getElementById('editorTitle').innerText = 'Yangi Vizitka';
        
        document.getElementById('dashboardView').style.display = 'none';
        document.getElementById('editorView').style.display = 'block';
    }

    function editProject(slug) {
        currentSlug = slug;
        let p = projects[slug];
        document.getElementById('projectSlug').value = slug;
        document.getElementById('projectSlug').disabled = true;
        document.getElementById('companyName').value = p.companyName;
        document.getElementById('subtitle').value = p.subtitle;
        document.getElementById('logoUrl').value = p.logoUrl || '';
        document.getElementById('themeSelect').value = p.theme;
        document.getElementById('seoDesc').value = p.seoDesc || '';
        document.getElementById('seoKeywords').value = p.seoKeywords || '';
        
        currentLinks = p.links || [];
        currentServices = p.services || [];
        currentPortfolio = p.portfolio || [];
        currentTestimonials = p.testimonials || [];
        currentFaqs = p.faqs || [];
        
        document.getElementById('tgToken').value = p.tgToken || '';
        document.getElementById('tgChatId').value = p.tgChatId || '';
        renderLinks();
        renderServices();
        renderPortfolio();
        renderTestimonials();
        renderFaqs();
        
        document.getElementById('editorTitle').innerText = 'Tahrirlash: ' + p.companyName;
        document.getElementById('dashboardView').style.display = 'none';
        document.getElementById('editorView').style.display = 'block';
    }

    function syncDataFromDOM() {
        try {
            currentServices = [];
            document.querySelectorAll('.service-item').forEach(item => {
                const title = item.querySelector('.s-title')?.value || '';
                const desc = item.querySelector('.s-desc')?.value || '';
                const price = item.querySelector('.s-price')?.value || '';
                currentServices.push({ title, desc, price });
            });

            currentLinks = [];
            document.querySelectorAll('.contact-item').forEach(item => {
                const type = item.querySelector('.l-type')?.value || 'telegram';
                const label = item.querySelector('.l-label')?.value || '';
                const url = item.querySelector('.l-url')?.value || '';
                currentLinks.push({ type, label, url });
            });

            currentTestimonials = [];
            document.querySelectorAll('.testimonial-item').forEach(item => {
                const name = item.querySelector('.t-name')?.value || '';
                const text = item.querySelector('.t-text')?.value || '';
                const rating = parseInt(item.querySelector('.t-rating')?.value) || 5;
                currentTestimonials.push({ name, text, rating });
            });

            currentFaqs = [];
            document.querySelectorAll('.faq-item').forEach(item => {
                const q = item.querySelector('.f-q')?.value || '';
                const a = item.querySelector('.f-a')?.value || '';
                currentFaqs.push({ q, a });
            });
        } catch (e) {
            console.error("Ma'lumotlarni yig'ishda xato:", e);
        }
    }

    function addTestimonial() { syncDataFromDOM(); currentTestimonials.push({ name: 'Mijoz Ismi', text: 'Juda zo\'r xizmat!', rating: 5 }); renderTestimonials(); }
    function renderTestimonials() {
        const cont = document.getElementById('testimonialsContainer'); cont.innerHTML = '';
        currentTestimonials.forEach((t, i) => {
            cont.innerHTML += `
                <div class="link-item testimonial-item">
                    <input type="text" value="${t.name}" placeholder="Mijoz ismi" class="t-name">
                    <input type="text" value="${t.text}" placeholder="Fikri..." class="t-text">
                    <input type="number" value="${t.rating}" min="1" max="5" class="t-rating">
                    <button class="btn-danger btn" onclick="removeTestimonial(${i})"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;
        });
    }
    function removeTestimonial(i) { syncDataFromDOM(); currentTestimonials.splice(i, 1); renderTestimonials(); }

    function addFaq() { syncDataFromDOM(); currentFaqs.push({ q: 'Savol?', a: 'Javob...' }); renderFaqs(); }
    function renderFaqs() {
        const cont = document.getElementById('faqContainer'); cont.innerHTML = '';
        currentFaqs.forEach((f, i) => {
            cont.innerHTML += `
                <div class="link-item faq-item">
                    <input type="text" value="${f.q}" placeholder="Savol" class="f-q">
                    <input type="text" value="${f.a}" placeholder="Javob" class="f-a">
                    <button class="btn-danger btn" onclick="removeFaq(${i})"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;
        });
    }
    function removeFaq(i) { syncDataFromDOM(); currentFaqs.splice(i, 1); renderFaqs(); }

    function addService() { syncDataFromDOM(); currentServices.push({ title: 'Xizmat nomi', desc: 'Qisqacha tavsif...', price: '' }); renderServices(); }
    function renderServices() {
        const container = document.getElementById('servicesContainer'); container.innerHTML = '';
        currentServices.forEach((s, i) => {
            container.innerHTML += `
                <div class="link-item service-item">
                    <input type="text" value="${s.title}" placeholder="Xizmat nomi" class="s-title">
                    <input type="text" value="${s.desc}" placeholder="Tavsif" class="s-desc">
                    <input type="text" value="${s.price}" placeholder="Narxi (ixtiyoriy)" class="s-price">
                    <button class="btn-danger btn" onclick="removeService(${i})"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;
        });
    }
    function removeService(i) { syncDataFromDOM(); currentServices.splice(i, 1); renderServices(); }

    function addLink() { syncDataFromDOM(); currentLinks.push({ type: 'telegram', label: 'Telegram', url: '' }); renderLinks(); }
    function renderLinks() {
        const container = document.getElementById('linksContainer'); container.innerHTML = '';
        currentLinks.forEach((l, i) => {
            container.innerHTML += `
                <div class="link-item contact-item">
                    <select class="l-type">
                        <option value="telegram" ${l.type==='telegram'?'selected':''}>Telegram</option>
                        <option value="instagram" ${l.type==='instagram'?'selected':''}>Instagram</option>
                        <option value="phone" ${l.type==='phone'?'selected':''}>Telefon</option>
                        <option value="website" ${l.type==='website'?'selected':''}>Veb-sayt</option>
                    </select>
                    <input type="text" value="${l.label}" class="l-label">
                    <input type="text" value="${l.url}" placeholder="URL..." class="l-url">
                    <button class="btn-danger btn" onclick="removeLink(${i})"><i class="fa-solid fa-trash"></i></button>
                </div>
            `;
        });
    }
    function removeLink(i) { syncDataFromDOM(); currentLinks.splice(i, 1); renderLinks(); }

    async function handleFileUpload(input) {
        if (!input.files || input.files[0] == null) return;
        
        const file = input.files[0];
        const btn = input.nextElementSibling;
        const icon = btn.querySelector('i');
        icon.className = 'fa-solid fa-spinner fa-spin'; btn.disabled = true;

        const formData = new FormData();
        formData.append('file', file);
        try {
            const res = await fetch('/upload', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData });
            const data = await res.json();
            document.getElementById('logoUrl').value = data.url;
            alert('Rasm muvaffaqiyatli yuklandi!');
        } catch (e) {
            alert('Yuklashda xato: ' + e.message);
        } finally {
            icon.className = 'fa-solid fa-upload'; btn.disabled = false;
        }
    }

    async function handlePortfolioUpload(input) {
        if (!input.files || input.files.length === 0) return;
        for(let i=0; i < input.files.length; i++) {
            const file = input.files[i];
            const formData = new FormData();
            formData.append('file', file);
            const res = await fetch('/upload', { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken }, body: formData });
            const data = await res.json();
            currentPortfolio.push(data.url);
        }
        renderPortfolio();
    }

    function renderPortfolio() {
        const cont = document.getElementById('portfolioContainer'); cont.innerHTML = '';
        currentPortfolio.forEach((url, i) => {
            cont.innerHTML += `
                <div style="position: relative; width: 80px; height: 80px;">
                    <img src="${url}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 10px;">
                    <button onclick="currentPortfolio.splice(${i}, 1); renderPortfolio();" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border: none; border-radius: 50%; cursor: pointer;">X</button>
                </div>
            `;
        });
    }

    async function saveProject() {
        try {
            const slug = document.getElementById('projectSlug').value.trim();
            if(!slug) return alert('Slugni kiriting!');
            
            syncDataFromDOM();

            const projectData = {
                companyName: document.getElementById('companyName').value || '',
                subtitle: document.getElementById('subtitle').value || '',
                logoUrl: document.getElementById('logoUrl').value || '',
                theme: document.getElementById('themeSelect').value || '',
                seoDesc: document.getElementById('seoDesc').value || '',
                seoKeywords: document.getElementById('seoKeywords').value || '',
                tgToken: document.getElementById('tgToken').value.trim() || '',
                tgChatId: document.getElementById('tgChatId').value.trim() || '',
                portfolio: currentPortfolio || [],
                links: currentLinks || [],
                services: currentServices || [],
                testimonials: currentTestimonials || [],
                faqs: currentFaqs || []
            };
            
            const btn = document.querySelector('button[onclick="saveProject()"]');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saqlanmoqda...';

            const res = await fetch('/projects/' + slug, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify(projectData)
            });
            const data = await res.json();
            
            if(data.success) {
                alert('Muvaffaqiyatli saqlandi!');
                loadProjects();
                showDashboard();
            } else {
                alert('Xatolik: ' + data.message);
            }
            btn.innerHTML = '<i class="fa-solid fa-floppy-disk"></i> Loyihani saqlash';
        } catch (outerError) {
            console.error(outerError);
            alert("Kutilmagan xatolik: " + outerError.message);
        }
    }

    async function deleteProject() {
        if(!currentSlug) return;
        if(!confirm('Haqiqatdan ham o\'chirmoqchimisiz?')) return;
        
        try {
            const res = await fetch('/projects/' + currentSlug, { method: 'DELETE', headers: { 'X-CSRF-TOKEN': csrfToken } });
            const data = await res.json();
            if(data.success) {
                alert('O\'chirildi!');
                loadProjects();
                showDashboard();
            }
        } catch(e) {
            console.error(e);
        }
    }
</script>
</body>
</html>