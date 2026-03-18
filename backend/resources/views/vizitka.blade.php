<!DOCTYPE html>
<html lang="uz">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Obsidian OS Mini - Vizitka</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        :root {
            --bg-gradient: linear-gradient(135deg, #e0c3fc 0%, #8ec5fc 100%);
            --card-bg: rgba(255, 255, 255, 0.45);
            --border: rgba(255, 255, 255, 0.6);
            --text-main: #1e293b;
            --text-sub: #475569;
            --primary: #6366f1;
            --secondary: #a855f7;
        }
        
        * { box-sizing: border-box; }
        
        body { 
            margin: 0; 
            font-family: 'Outfit', sans-serif; 
            background: var(--bg-gradient); 
            min-height: 100vh; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            padding: 20px; 
            overflow-x: hidden;
            color: var(--text-main);
        }
        
        .blob { position: fixed; border-radius: 50%; filter: blur(80px); z-index: 1; opacity: 0.5; animation: float 15s infinite alternate ease-in-out; }
        .blob-1 { width: 400px; height: 400px; background: #c084fc; top: -100px; left: -100px; }
        .blob-2 { width: 450px; height: 450px; background: #818cf8; bottom: -150px; right: -150px; }
        
        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg) scale(1); }
            100% { transform: translate(40px, 40px) rotate(15deg) scale(1.1); }
        }

        .glass-card { 
            position: relative; 
            z-index: 10; 
            background: var(--card-bg); 
            backdrop-filter: blur(30px); 
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid var(--border); 
            border-radius: 40px; 
            padding: 50px 25px; 
            width: 100%; 
            max-width: 380px; 
            text-align: center; 
            box-shadow: 0 40px 100px -20px rgba(0, 0, 0, 0.15);
            animation: cardAppear 1s cubic-bezier(0.2, 1, 0.2, 1);
        }

        @keyframes cardAppear {
            0% { opacity: 0; transform: translateY(50px) scale(0.9); }
            100% { opacity: 1; transform: translateY(0) scale(1); }
        }

        .logo-container { width: 110px; height: 110px; margin: 0 auto 25px; position: relative; }
        .profile-pic { 
            width: 100%; height: 100%; 
            background: white; 
            border-radius: 35px; 
            display: flex; justify-content: center; align-items: center; 
            font-size: 45px; color: #334155; 
            border: 2px solid rgba(255,255,255,0.9);
            box-shadow: 0 15px 35px rgba(0,0,0,0.08);
            object-fit: cover;
            overflow: hidden;
        }

        h1 { margin: 0 0 10px; font-size: 30px; font-weight: 800; color: #0f172a; letter-spacing: -1px; line-height: 1.1; }
        p.subtitle { margin: 0 0 35px; font-size: 16px; color: var(--text-sub); font-weight: 500; opacity: 0.9; }
        
        .actions-row { 
            display: flex; 
            justify-content: center; 
            gap: 10px; 
            margin-bottom: 35px; 
            width: 100%;
        }
        .action-btn { 
            flex: 1;
            max-width: 145px;
            padding: 14px 10px; 
            border-radius: 20px; 
            border: none; 
            background: #0f172a; 
            color: white; 
            cursor: pointer;
            font-size: 13px; 
            font-weight: 700; 
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex; 
            align-items: center; 
            justify-content: center; 
            gap: 6px;
            box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.2);
            white-space: nowrap;
        }
        .action-btn:hover { transform: translateY(-3px); box-shadow: 0 15px 25px -5px rgba(15, 23, 42, 0.3); }
        .action-btn.secondary { 
            background: white; 
            color: #0f172a; 
            box-shadow: 0 8px 15px rgba(0,0,0,0.05); 
            border: 1px solid rgba(0,0,0,0.05);
        }

        .services-section { text-align: left; margin-bottom: 35px; }
        .service-title { font-size: 18px; font-weight: 800; margin-bottom: 15px; color: #0f172a; display: flex; align-items: center; gap: 8px; }
        
        .service-card { 
            background: rgba(255, 255, 255, 0.5); 
            padding: 16px; border-radius: 20px; margin-bottom: 12px; 
            border: 2px solid transparent;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0,0,0,0.02);
            text-align: left;
        }
        .service-card:hover { transform: translateY(-3px); background: rgba(255, 255, 255, 0.8); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .service-card.selected { 
            border-color: #00ffcc; 
            background: rgba(0, 255, 204, 0.08); 
            box-shadow: 0 10px 25px rgba(0, 255, 204, 0.2); 
            transform: scale(1.02);
        }

        .s-name { font-weight: 800; font-size: 16px; color: #1e293b; }
        .s-desc { font-size: 13px; color: #64748b; line-height: 1.4; margin-top: 5px; }
        .s-price { font-weight: 800; color: #6366f1; font-size: 14px; margin-top: 8px; display: inline-block; background: rgba(99, 102, 241, 0.1); padding: 4px 10px; border-radius: 12px; }
        
        .select-indicator { display: none; margin-top: 12px; color: #00baa3; font-weight: 800; font-size: 13px; text-shadow: 0 0 10px rgba(0,255,204,0.3); }
        .service-card.selected .select-indicator { display: block; animation: fadeIn 0.3s forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

        /* Pulse Indicator */
        .status-badge {
            position: absolute; top: 15px; left: 15px;
            background: rgba(255,255,255,0.75); padding: 6px 12px; border-radius: 20px;
            font-size: 11px; font-weight: 800; color: #0f172a;
            display: flex; align-items: center; gap: 8px;
            backdrop-filter: blur(10px);
            z-index: 20;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .pulse-dot {
            width: 10px; height: 10px; background: #22c55e; border-radius: 50%;
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
            animation: pulse-green 1.5s infinite;
        }
        @keyframes pulse-green {
            0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { box-shadow: 0 0 0 12px rgba(34, 197, 94, 0); }
            100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        .buttons-grid { display: flex; flex-direction: column; gap: 15px; margin-bottom: 40px; }
        .btn { 
            display: flex; align-items: center; justify-content: center; gap: 14px; 
            width: 100%; padding: 18px; 
            border-radius: 22px; text-decoration: none; 
            background: rgba(255, 255, 255, 0.8); 
            border: 1px solid rgba(255, 255, 255, 1); 
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            font-weight: 600; font-size: 17px; 
            color: #1e293b;
        }
        .btn:hover { transform: translateY(-5px) scale(1.03); background: #fff; box-shadow: 0 15px 30px rgba(0,0,0,0.05); }

        .qr-section { padding-top: 35px; border-top: 2px solid rgba(255,255,255,0.3); }
        .qr-code { background: white; padding: 15px; border-radius: 30px; display: inline-block; box-shadow: 0 10px 25px rgba(0,0,0,0.05); }
        .qr-code img { display: block; border-radius: 15px; width: 140px; height: 140px; }
        .qr-text { font-size: 14px; color: var(--text-sub); margin-bottom: 15px; font-weight: 600; }

        .lang-switcher { display: flex; justify-content: flex-end; gap: 10px; margin-bottom: 20px; }
        .lang-btn { background: rgba(255,255,255,0.2); border: none; padding: 5px 15px; border-radius: 12px; cursor: pointer; color: var(--text-main); font-weight: bold; transition: 0.3s; }
        .lang-btn.active { background: var(--primary); color: white; box-shadow: 0 5px 15px rgba(99, 102, 241, 0.3); }

        .lead-form { background: rgba(0,0,0,0.6); padding: 25px; border-radius: 20px; margin-top: 30px; border: 1px solid #00ffcc; box-shadow: 0 0 25px rgba(0, 255, 204, 0.15); text-align: left; position: relative; overflow: hidden; }
        .lead-form::before { content: ''; position: absolute; top:-50%; left:-50%; width: 200%; height: 200%; background: radial-gradient(circle, rgba(0,255,204,0.1) 0%, transparent 70%); pointer-events: none; }
        .lead-form h3 { color: #00ffcc; text-shadow: 0 0 15px rgba(0, 255, 204, 0.4); margin-top: 0; display: flex; align-items: center; gap: 10px; }
        .lead-input { width: 100%; padding: 14px; margin-bottom: 15px; background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: 12px; font-family: 'Outfit'; font-size: 15px; transition: 0.3s; }
        .lead-input:focus { outline: none; border-color: #00ffcc; background: rgba(0,255,204,0.05); box-shadow: 0 0 10px rgba(0,255,204,0.1); }
        .lead-input::placeholder { color: rgba(255,255,255,0.4); }
        select.lead-input option { background: #1e293b; color: white; }
        .neon-submit { width: 100%; padding: 15px; background: transparent; color: #00ffcc; border: 2px solid #00ffcc; border-radius: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s; font-family: 'Outfit'; }
        .neon-submit:hover { background: #00ffcc; color: black; box-shadow: 0 0 25px rgba(0, 255, 204, 0.8); transform: translateY(-2px); }

        .portfolio-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 20px; }
        .portfolio-grid img { width: 100%; height: 140px; object-fit: cover; border-radius: 18px; border: 2px solid rgba(255,255,255,0.3); transition: 0.3s; }
        .portfolio-grid img:hover { transform: scale(1.05); border-color: white; }

        .fab-container { position: fixed; bottom: 30px; right: 30px; z-index: 1000; }
        .fab-main { width: 65px; height: 65px; background: #00ffcc; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 26px; color: #000; box-shadow: 0 0 25px rgba(0,255,204,0.6); cursor: pointer; animation: pulse 2s infinite; transition: 0.3s; }
        .fab-main:hover { transform: scale(1.1); }
        @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(0, 255, 204, 0.8); } 70% { box-shadow: 0 0 0 25px rgba(0, 255, 204, 0); } 100% { box-shadow: 0 0 0 0 rgba(0, 255, 204, 0); } }

        .faq-details { background: rgba(255,255,255,0.4); border: 1px solid rgba(255,255,255,0.6); border-radius: 18px; margin-bottom: 12px; padding: 18px; color: var(--text-main); transition: 0.3s; }
        .faq-details[open] { background: white; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .faq-details summary { font-weight: 700; cursor: pointer; outline: none; list-style-position: inside; }
        .faq-details p { margin-top: 15px; font-size: 14px; opacity: 0.8; line-height: 1.6; padding-left: 20px; border-left: 2px solid var(--primary); }

        .testimonial-card { background: rgba(255,255,255,0.6); border: 1px solid rgba(255,255,255,0.8); padding: 25px; border-radius: 25px; margin-bottom: 15px; color: var(--text-main); box-shadow: 0 10px 30px rgba(0,0,0,0.05); position: relative; }
        .testimonial-card::before { content: '"'; position: absolute; top: 10px; right: 20px; font-size: 60px; color: var(--primary); opacity: 0.1; font-family: serif; }
        .stars { color: #fbbf24; margin-bottom: 12px; font-size: 18px; letter-spacing: 2px; }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="glass-card">
        <div class="status-badge"><div class="pulse-dot"></div> Ochiq</div>
        <div class="lang-switcher">
            <button class="lang-btn active" onclick="changeLang('uz')">UZ</button>
            <button class="lang-btn" onclick="changeLang('ru')">RU</button>
            <button class="lang-btn" onclick="changeLang('en')">EN</button>
        </div>
        
        <div class="logo-container">
            <div id="profileImage" class="profile-pic">
                <i class="fa-solid fa-graduation-cap"></i>
            </div>
        </div>
        
        <h1 id="displayName">Yuklanmoqda...</h1>
        <p class="subtitle" id="displaySubtitle">...</p>

        <div class="actions-row">
            <button class="action-btn" onclick="saveVCard()"><i class="fa-solid fa-user-plus"></i> Saqlash</button>
            <button class="action-btn secondary" onclick="copyURL()"><i class="fa-solid fa-arrow-up-right-from-square"></i> Ulashish</button>
        </div>

        <!-- Xizmatlar dinamik render bo'ladi -->
        <div id="servicesContainer" class="services-section"></div>

        <div id="buttonsContainer" class="buttons-grid"></div>

        <div id="portfolioView" class="portfolio-grid"></div>

        <div id="testimonialsView" style="margin-top: 40px; text-align: left;"></div>
        <div id="faqView" style="margin-top: 40px; text-align: left;"></div>

        <div id="leadFormContainer" class="lead-form" style="display: none;">
            <h3 id="formTitle"><i class="fa-solid fa-bolt"></i> Qabulga Yozilish</h3>
            <select id="leadService" class="lead-input" style="display: none; color-scheme: dark;">
                <option value="">-- Xizmatni tanlang --</option>
            </select>
            <input type="text" id="leadName" class="lead-input" placeholder="Ismingiz">
            <input type="tel" id="leadPhone" class="lead-input" placeholder="Telefon raqamingiz">
            <input type="datetime-local" id="leadDate" class="lead-input" style="color-scheme: dark;">
            <button class="neon-submit" onclick="submitLead()" id="formBtn">Qabulga yozilish</button>
        </div>

        <div class="qr-section">
            <div class="qr-text">Kontaktni saqlash uchun skanerlang</div>
            <div class="qr-code"><img id="qr-image" src="" alt="QR"></div>
        </div>
    </div>

    <!-- Laravel API Scripts -->
    <script>
        const slug = "{{ $slug }}";
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

        const iconMap = {
            'telegram': 'fa-brands fa-telegram',
            'instagram': 'fa-brands fa-instagram',
            'phone': 'fa-solid fa-phone',
            'location': 'fa-solid fa-location-dot',
            'website': 'fa-solid fa-globe',
            'youtube': 'fa-brands fa-youtube',
            'facebook': 'fa-brands fa-facebook',
            'tiktok': 'fa-brands fa-tiktok',
            'linkedin': 'fa-brands fa-linkedin'
        };

        let globalData = null;

        const translations = {
            uz: { save: "Saqlash", share: "Ulashish", services: "Xizmatlarimiz", tapToSelect: "(Tanlash uchun bosing)", formTitle: "Qabulga Yozilish", formBtn: "Jo'natish", qr: "Kontaktni saqlash uchun skanerlang", alertOk: "Arizangiz qabul qilindi!", alertErr: "Xatolik yuz berdi." },
            ru: { save: "Сохранить", share: "Поделиться", services: "Наши услуги", tapToSelect: "(Нажмите для выбора)", formTitle: "Запись на прием", formBtn: "Отправить", qr: "Отсканируйте для сохранения", alertOk: "Ваша заявка принята!", alertErr: "Произошла ошибка." },
            en: { save: "Save", share: "Share", services: "Our Services", tapToSelect: "(Tap to select)", formTitle: "Book an Appointment", formBtn: "Submit", qr: "Scan to save contact", alertOk: "Your request is submitted!", alertErr: "An error occurred." }
        };

        let currentLang = 'uz';

        function changeLang(lang) {
            currentLang = lang;
            document.querySelectorAll('.lang-btn').forEach(b => b.classList.remove('active'));
            event.target.classList.add('active');
            
            document.querySelector('.action-btn').innerHTML = `<i class="fa-solid fa-user-plus"></i> ${translations[lang].save}`;
            document.querySelector('.action-btn.secondary').innerHTML = `<i class="fa-solid fa-arrow-up-right-from-square"></i> ${translations[lang].share}`;
            document.querySelector('.qr-text').innerText = translations[lang].qr;
            document.getElementById('formTitle').innerHTML = `<i class="fa-solid fa-bolt"></i> ${translations[lang].formTitle}`;
            document.getElementById('formBtn').innerText = translations[lang].formBtn;
            
            const sTitle = document.getElementById('srvTitleSpan');
            if(sTitle) {
                sTitle.innerHTML = `${translations[lang].services} <span style="font-size: 12px; font-weight: 500; color: var(--primary); margin-left: auto; text-transform: none;">${translations[lang].tapToSelect}</span>`;
            }
        }
        
        async function loadProject() {
            if(!slug) { showError(); return; }
            try {
                const response = await fetch('/api/vizitka/' + slug);
                if(!response.ok) throw new Error("Not found");
                const data = await response.json();
                
                globalData = data;
                
                fetch(`/api/vizitka/${slug}/view`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } });

                if(data.seoDesc) {
                    let metaDesc = document.createElement('meta');
                    metaDesc.name = "description"; metaDesc.content = data.seoDesc;
                    document.head.appendChild(metaDesc);
                }
                if(data.seoKeywords) {
                    let metaKey = document.createElement('meta');
                    metaKey.name = "keywords"; metaKey.content = data.seoKeywords;
                    document.head.appendChild(metaKey);
                }
                document.title = data.companyName + " | " + (data.subtitle || "Profil");

                if(data.theme) document.body.style.background = data.theme;
                document.getElementById('displayName').innerText = data.companyName || '';
                document.getElementById('displaySubtitle').innerText = data.subtitle || '';

                const profileDiv = document.getElementById('profileImage');
                if(data.logoUrl && data.logoUrl !== 'null' && String(data.logoUrl).trim() !== "") {
                    profileDiv.innerHTML = `<img src="${data.logoUrl}" style="width:100%; height:100%; object-fit:cover;">`;
                } else {
                    profileDiv.innerHTML = `<i class="fa-solid fa-graduation-cap"></i>`;
                }

                const sContainer = document.getElementById('servicesContainer');
                const servSelect = document.getElementById('leadService');

                if(data.services && data.services.length > 0) {
                    sContainer.innerHTML = `<div class="service-title" id="srvTitleSpan"><i class="fa-solid fa-briefcase"></i> ${translations[currentLang].services} <span style="font-size: 12px; font-weight: 500; color: var(--primary); margin-left: auto; text-transform: none;">${translations[currentLang].tapToSelect}</span></div>`;
                    
                    servSelect.style.display = 'block';

                    data.services.forEach((s, idx) => {
                        const safeTitle = (s.title || '').replace(/'/g, "\\'");
                        sContainer.innerHTML += `
                            <div class="service-card" id="srv_card_${idx}" onclick="selectService('${safeTitle}', ${idx})">
                                <div class="s-name">${s.title || ''}</div>
                                <div class="s-desc">${s.desc || ''}</div>
                                ${s.price && String(s.price) !== 'null' ? `<div class="s-price">${s.price}</div>` : ''}
                                <div class="select-indicator"><i class="fa-solid fa-circle-check"></i> Tanlandi (Pastda to'ldiring)</div>
                            </div>
                        `;
                        const priceAdd = s.price && String(s.price) !== 'null' ? ` (${s.price})` : '';
                        servSelect.innerHTML += `<option value="${s.title}">${s.title}${priceAdd}</option>`;
                    });
                }

                if(data.portfolio && data.portfolio.length > 0) {
                    const pCont = document.getElementById('portfolioView');
                    data.portfolio.forEach(url => {
                        pCont.innerHTML += `<img src="${url}" alt="Portfolio">`;
                    });
                }

                if(data.testimonials && data.testimonials.length > 0) {
                    const tCont = document.getElementById('testimonialsView');
                    tCont.innerHTML = `<h3 style="color: #0f172a; margin-bottom: 20px;"><i class="fa-solid fa-star" style="color:#fbbf24;"></i> Mijozlar fikri</h3>`;
                    data.testimonials.forEach(t => {
                        let starsHtml = '★'.repeat(t.rating) + '☆'.repeat(5 - t.rating);
                        tCont.innerHTML += `
                            <div class="testimonial-card">
                                <div class="stars">${starsHtml}</div>
                                <div style="font-style: italic; margin-bottom: 15px; font-size: 15px;">"${t.text}"</div>
                                <div style="font-weight: 800; text-align: right; font-size: 16px; color: var(--primary);">- ${t.name}</div>
                            </div>
                        `;
                    });
                }

                if(data.faqs && data.faqs.length > 0) {
                    const fCont = document.getElementById('faqView');
                    fCont.innerHTML = `<h3 style="color: #0f172a; margin-bottom: 20px;"><i class="fa-solid fa-circle-question" style="color:var(--primary);"></i> Savol-Javob</h3>`;
                    data.faqs.forEach(f => {
                        fCont.innerHTML += `
                            <details class="faq-details">
                                <summary>${f.q}</summary>
                                <p>${f.a}</p>
                            </details>
                        `;
                    });
                }

                const bContainer = document.getElementById('buttonsContainer');
                if(data.links) {
                    data.links.forEach((link, idx) => {
                        const iconClass = iconMap[link.type] || 'fa-solid fa-link';
                        const a = document.createElement('a');
                        a.href = link.url;
                        a.className = `btn`;
                        a.target = "_blank";
                        a.onclick = () => fetch(`/api/vizitka/${slug}/click`, { method: 'POST', headers: { 'X-CSRF-TOKEN': csrfToken } }); 
                        a.style.animation = `cardAppear 0.5s ease forwards ${0.3 + (idx * 0.1)}s`;
                        a.style.opacity = '0';
                        a.innerHTML = `<i class="${iconClass}" style="color: var(--primary); font-size: 20px;"></i> ${link.label}`;
                        bContainer.appendChild(a);
                    });
                }

                if(data.tgToken && data.tgChatId) {
                    document.getElementById('leadFormContainer').style.display = 'block';
                    const fab = document.getElementById('fabBtn');
                    if(fab) fab.style.display = 'block';
                }

                const vCard = `BEGIN:VCARD\nVERSION:3.0\nFN:${data.companyName}\nORG:${data.companyName}\nTITLE:${data.subtitle}\n${data.links ? data.links.map(l => `URL:${l.url}`).join('\n') : ''}\nEND:VCARD`;
                const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=${encodeURIComponent(vCard)}`;
                document.getElementById('qr-image').src = qrUrl;

            } catch (e) {
                showError();
            }
        }
        
        loadProject();

        // Xizmatni tanlash mantiqi
        function selectService(title, idx) {
            document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
            const card = document.getElementById(`srv_card_${idx}`);
            if(card) {
                card.classList.add('selected');
                // Haptic feedback (telefonlar uchun)
                if (navigator.vibrate) navigator.vibrate(50);
            }
            
            const select = document.getElementById('leadService');
            if(select) {
                for(let i=0; i < select.options.length; i++) {
                    if(select.options[i].value === title) {
                        select.selectedIndex = i;
                        break;
                    }
                }
            }
            scrollToForm();
        }

        async function submitLead() {
            if(!globalData || !globalData.tgToken) return;
            
            const name = document.getElementById('leadName').value;
            const phone = document.getElementById('leadPhone').value;
            const date = document.getElementById('leadDate').value;
            const service = document.getElementById('leadService').value;
            
            if(!name || !phone) return alert('Iltimos, ism va raqamni kiriting!');

            let text = `🔔 YANGI ARIZA / QABUL!\n\n👤 Mijoz: ${name}\n📞 Tel: ${phone}\n📅 Belgilangan vaqt: ${date || 'Ko\'rsatilmagan'}`;
            if(service) text += `\n💼 Tanlangan Xizmat: ${service}`;
            text += `\n\n🏢 Sayt: ${globalData.companyName}`;

            const url = `https://api.telegram.org/bot${globalData.tgToken}/sendMessage?chat_id=${globalData.tgChatId}&text=${encodeURIComponent(text)}`;

            const btn = document.getElementById('formBtn');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Jo\'natilmoqda...';

            try {
                const response = await fetch(url);
                if(response.ok) {
                    // Confetti animatsiyasi!
                    confetti({
                        particleCount: 150,
                        spread: 80,
                        origin: { y: 0.6 },
                        colors: ['#00ffcc', '#6366f1', '#a855f7']
                    });

                    alert(translations[currentLang].alertOk);
                    document.getElementById('leadName').value = '';
                    document.getElementById('leadPhone').value = '';
                    document.getElementById('leadDate').value = '';
                    document.getElementById('leadService').selectedIndex = 0;
                    document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
                } else {
                    alert(translations[currentLang].alertErr);
                }
            } catch(e) {
                alert("Xatolik: " + e.message);
            } finally {
                btn.innerText = translations[currentLang].formBtn;
            }
        }

        function scrollToForm() {
            const form = document.getElementById('leadFormContainer');
            if(form.style.display !== 'none') {
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
                setTimeout(() => document.getElementById('leadName').focus(), 600);
            }
        }

        function showError() {
            document.getElementById('displayName').innerText = "Loyiha topilmadi";
            document.getElementById('displaySubtitle').innerText = "Admin panelda loyiha yarating.";
            document.querySelector('.actions-row').style.display = 'none';
        }

        function saveVCard() {
            if(!globalData) return;
            const vCardData = `BEGIN:VCARD\nVERSION:3.0\nFN:${globalData.companyName}\nORG:${globalData.companyName}\nTITLE:${globalData.subtitle}\n${globalData.links ? globalData.links.map(l => `URL:${l.url}`).join('\n') : ''}\nEND:VCARD`;
            const blob = new Blob([vCardData], { type: "text/vcard" });
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = `${globalData.companyName}.vcf`;
            a.click();
        }

        function copyURL() {
            if (navigator.share) {
                navigator.share({
                    title: globalData.companyName,
                    text: globalData.subtitle,
                    url: window.location.href,
                }).catch((error) => console.log('Error sharing', error));
            } else {
                navigator.clipboard.writeText(window.location.href);
                alert("Ssilka nusxalandi!");
            }
        }
    </script>
    <div class="fab-container" id="fabBtn" style="display: none;">
        <div class="fab-main" onclick="scrollToForm()">
            <i class="fa-solid fa-calendar-check"></i>
        </div>
    </div>
</body>
</html>