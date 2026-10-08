// ====================================================================
// JingJai - Frontend State & Application Logic (Multi-Page & Modal Version)
// ====================================================================

// 1. Initial State Data (แสดงเฉพาะหอเฟรชชี่เท่านั้น)
let dormsData = [
  {
    id: 1,
    uni: 'MSU',
    uniName: 'มมส. (ขามเรียง มอใหม่)',
    zone: 'ขามเรียง',
    name: 'หอเฟรชชี่ The Freshy Living Complex',
    address: '88/1 ซอยขามเรียง มอใหม่ ต.ขามเรียง อ.กันทรวิชัย จ.มหาสารคาม',
    distanceKm: 0.6,
    walkingMin: 8,
    priceMonthly: 4200,
    waterRate: 25,
    electricRate: 7,
    hasAir: true,
    hasFurniture: true,
    hasInternet: true,
    petFriendly: false,
    hasParking: true,
    googleMapEmbedUrl: 'https://maps.google.com/maps?q=Mahasarakham+University+Khamriang&t=&z=15&ie=UTF8&iwloc=&output=embed',
    googleMapUrl: 'https://www.google.com/maps/search/?api=1&query=หอเฟรชชี่+The+Freshy+Living+Complex+มหาสารคาม',
    mapLat: 16.2475,
    mapLng: 103.2535,
    overallRating: 4.7,
    ratings: {
      quietness: 4.8,
      waterSupply: 4.5,
      internet: 4.8,
      security: 4.7,
      landlord: 4.8,
      cleanliness: 4.7
    },
    aiSummary: {
      pros: [
        'ทำเลดี ใกล้ มมส. เดินมาเรียนได้สะดวกและไม่ไกลเกินไป',
        'ห้องพักสะอาด มีเฟอร์นิเจอร์ครบพร้อมใช้งาน',
        'อินเทอร์เน็ตแรงและเสถียร เหมาะสำหรับเรียนออนไลน์และทำงาน'
      ],
      considerations: [
        'ราคาเริ่มต้นค่อนข้างสูงแต่คุ้มค่ากับสิ่งอำนวยความสะดวก',
        'ช่วงเปิดเทอมมีคนจองเร็ว จึงแนะนำจองล่วงหน้า'
      ],
      wifiSummary: 'อินเทอร์เน็ตความเร็วสูงและเสถียร เหมาะสำหรับเรียนออนไลน์ ดูหนัง และทำงานจากห้องพัก',
      quietSummary: 'เงียบสงบ เหมาะกับนักศึกษาที่ต้องการความสงบและสมาธิในการเรียน',
      waterSummary: 'น้ำประปาแรงดี ไม่มีปัญหาเรื่องน้ำขาด และใช้งานได้เป็นประจำ'
    },
    photos: {
      LANDLORD: [
        { url: 'images/freshy-building.jpg', caption: 'ภายนอกอาคารหอพักและบรรยากาศด้านหน้า' },
        { url: 'images/freshy-cuisine.jpg', caption: 'โซนรับประทานอาหารและบรรยากาศภายในหอ' },
        { url: 'images/freshy-fitness.jpg', caption: 'สภาพห้องออกกำลังกายภายในหอพัก' }
      ],
      STUDENT: [
        { url: 'images/freshy-bed.jpg', caption: 'ห้องนอนแบบเรียบง่าย สบายและมีเฟอร์นิเจอร์ครบ' },
        { url: 'images/freshy-room.jpg', caption: 'ภายในห้องพักพร้อมพื้นที่ทำงานและการจัดวางสบาย' },
        { url: 'images/freshy-toilet.jpg', caption: 'ห้องน้ำสะอาดเรียบร้อยและใช้งานง่าย' }
      ]
    },
    qa: [
      { q: 'หอพักนี้อยู่ใกล้ มมส. มากไหมครับ?', asker: 'Student_MSU', a: 'เดินประมาณ 8-10 นาทีถึงมหาวิทยาลัยได้เลยครับ สะดวกมาก', responder: 'ผู้พักจริง' }
    ]
  }
];

// Active Filters & Shared LocalStorage State
let currentSelectedUni = 'ALL';
let compareList = JSON.parse(localStorage.getItem('jingJaiCompareList') || '[]');
let activePhotoSource = 'STUDENT';
let activeDormForModal = null;

// Save Compare List to localStorage
function saveCompareState() {
  localStorage.setItem('jingJaiCompareList', JSON.stringify(compareList));
  updateCompareBadges();
}

function updateCompareBadges() {
  const badgeEls = document.querySelectorAll('.compare-badge-count');
  badgeEls.forEach(el => {
    el.innerText = `${compareList.length}/3`;
  });

  // Floating Compare Dock Update
  const dock = document.getElementById('floating-compare-dock');
  const countText = document.getElementById('dock-compare-count-text');
  const thumbsContainer = document.getElementById('dock-compare-thumbs');
  
  if (dock) {
    if (compareList.length > 0) {
      dock.classList.remove('translate-y-32', 'opacity-0', 'pointer-events-none');
      dock.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
      if (countText) countText.innerText = `${compareList.length}/3`;
      if (thumbsContainer) {
        const selectedDorms = dormsData.filter(d => compareList.includes(d.id));
        thumbsContainer.innerHTML = selectedDorms.map(d => `
          <div class="flex items-center gap-1.5 bg-slate-800/90 border border-slate-700/80 rounded-xl px-2.5 py-1 text-[11px] text-white shadow-xs">
            <span class="w-2 h-2 rounded-full bg-emerald-400"></span>
            <span class="font-medium truncate max-w-[90px] sm:max-w-[130px]">${d.name}</span>
            <button onclick="toggleCompare(${d.id}); event.stopPropagation();" class="text-slate-400 hover:text-rose-400 ml-1 cursor-pointer p-0.5" title="ลบออก">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
        `).join('');
      }
    } else {
      dock.classList.add('translate-y-32', 'opacity-0', 'pointer-events-none');
      dock.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
    }
  }
}

// Global Helper: Get Query Parameter
function getQueryParam(param) {
  const urlParams = new URLSearchParams(window.location.search);
  return urlParams.get(param);
}

// ====================================================================
// INITIALIZATION
// ====================================================================
document.addEventListener('DOMContentLoaded', () => {
  updateCompareBadges();
  updateBookingBadges();
  updateLoginButtonState();
  syncBookingButtonVisibility();

  const isHomePage = window.location.pathname.endsWith('/index.php') || window.location.pathname.endsWith('/index.html') || window.location.pathname.endsWith('/') || window.location.pathname === '';

  if (!document.getElementById('login-trigger-btn') && !window.location.pathname.endsWith('/login.php')) {
    const targetWrap = document.querySelector('header .flex.items-center.justify-between > div:last-child, header .flex.items-center.gap-2');
    if (targetWrap) {
      const loginBtn = document.createElement('a');
      loginBtn.href = 'login.php';
      loginBtn.id = 'login-trigger-btn';
      loginBtn.className = 'bg-white border border-slate-200 hover:border-brand-300 hover:bg-brand-50 text-slate-700 px-4 py-2 rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center gap-2 cursor-pointer';
      loginBtn.innerHTML = '<i class="fa-solid fa-right-to-bracket text-brand-600"></i><span id="login-button-label">เข้าสู่ระบบ</span>';
      targetWrap.insertBefore(loginBtn, targetWrap.firstChild);
    }
  }

  if (!isHomePage) {
    document.querySelectorAll('button[onclick*="openMyBookingsModal"]').forEach(btn => {
      btn.style.display = 'none';
    });
    document.querySelectorAll('a[onclick*="openMyBookingsModal"]').forEach(btn => {
      btn.style.display = 'none';
    });
  }

  // If on index.html
  if (document.getElementById('dorms-container')) {
    applyFilters();
  }

  // If on dorm-detail.html
  if (document.getElementById('detail-page-container')) {
    initDormDetailPage();
  }

  // If on compare.html
  if (document.getElementById('compare-page-table-container')) {
    initComparePage();
  }

  // If on calculator.html
  if (document.getElementById('calc-dorm-select')) {
    initCalculatorPage();
  }
});


// ====================================================================
// FILTERING & SORTING LOGIC (For Index Page)
// ====================================================================
function filterByUni(code) {
  currentSelectedUni = code;

  // Update UI Pills
  document.querySelectorAll('.uni-pill').forEach(btn => {
    if (btn.dataset.uni === code) {
      btn.className = "uni-pill active px-4 py-2 rounded-xl text-sm font-medium transition-all bg-brand-600 text-white shadow-md shadow-brand-500/20 cursor-pointer";
    } else {
      btn.className = "uni-pill px-4 py-2 rounded-xl text-sm font-medium transition-all bg-white text-slate-700 border border-slate-200 hover:border-brand-300 cursor-pointer";
    }
  });

  applyFilters();
}

function updatePriceLabel(val) {
  const el = document.getElementById('price-val');
  if (el) el.innerText = `${parseInt(val).toLocaleString()} บาท/เดือน`;
}

function toggleMoreFilters() {
  const panel = document.getElementById('more-filters-panel');
  if (panel) panel.classList.toggle('hidden');
}

function resetFilters() {
  const searchInput = document.getElementById('search-input');
  if (searchInput) searchInput.value = '';
  const priceRange = document.getElementById('price-range');
  if (priceRange) {
    priceRange.value = 5000;
    updatePriceLabel(5000);
  }
  if (document.getElementById('chk-air')) document.getElementById('chk-air').checked = true;
  if (document.getElementById('chk-furniture')) document.getElementById('chk-furniture').checked = false;
  if (document.getElementById('chk-wifi')) document.getElementById('chk-wifi').checked = true;
  if (document.getElementById('chk-pet')) document.getElementById('chk-pet').checked = false;
  if (document.getElementById('chk-parking')) document.getElementById('chk-parking').checked = false;
  if (document.getElementById('chk-quiet')) document.getElementById('chk-quiet').checked = false;
  filterByUni('ALL');
}

function applyFilters() {
  const container = document.getElementById('dorms-container');
  if (!container) return;

  const queryEl = document.getElementById('search-input');
  const query = queryEl ? queryEl.value.toLowerCase().trim() : '';
  const priceEl = document.getElementById('price-range');
  const maxPrice = priceEl ? parseInt(priceEl.value) : 10000;

  const chkAir = document.getElementById('chk-air')?.checked || false;
  const chkFurniture = document.getElementById('chk-furniture')?.checked || false;
  const chkWifi = document.getElementById('chk-wifi')?.checked || false;
  const chkPet = document.getElementById('chk-pet')?.checked || false;
  const chkParking = document.getElementById('chk-parking')?.checked || false;
  const chkQuiet = document.getElementById('chk-quiet')?.checked || false;
  const sortSelect = document.getElementById('sort-select');
  const sortBy = sortSelect ? sortSelect.value : 'rating_desc';

  const freshyOnly = dormsData.filter(d =>
    /เฟรชชี่|Freshy|The Freshy/i.test(d.name || '')
  );
  // The index is intentionally limited to The Freshy. Do not fall back to
  // the full dataset if a differently cached dataset lacks that dorm.
  const sourceList = freshyOnly;

  let filtered = sourceList.filter(d => {
    // Uni match
    if (currentSelectedUni !== 'ALL' && d.uni !== currentSelectedUni) return false;

    // Search query match
    if (query) {
      const textMatch = d.name.toLowerCase().includes(query) ||
        d.address.toLowerCase().includes(query) ||
        d.uniName.toLowerCase().includes(query);
      if (!textMatch) return false;
    }

    // Max Price
    if (d.priceMonthly > maxPrice) return false;

    // Checkbox facilities
    if (chkAir && !d.hasAir) return false;
    if (chkFurniture && !d.hasFurniture) return false;
    if (chkWifi && !d.hasInternet) return false;
    if (chkPet && !d.petFriendly) return false;
    if (chkParking && !d.hasParking) return false;
    if (chkQuiet && d.ratings.quietness < 4.5) return false;

    return true;
  });

  // Sorting
  filtered.sort((a, b) => {
    if (sortBy === 'rating_desc') return b.overallRating - a.overallRating;
    if (sortBy === 'price_asc') return a.priceMonthly - b.priceMonthly;
    if (sortBy === 'distance_asc') return a.distanceKm - b.distanceKm;
    if (sortBy === 'quiet_desc') return b.ratings.quietness - a.ratings.quietness;
    if (sortBy === 'internet_desc') return b.ratings.internet - a.ratings.internet;
    return 0;
  });

  renderDormGrid(filtered);
}


// ====================================================================
// RENDER DORM CARDS GRID VIEW (WITH INSTANT CLICK & DEDICATED LINKS)
// ====================================================================
function renderDormGrid(dorms) {
  const container = document.getElementById('dorms-container');
  const countEl = document.getElementById('result-count');
  if (countEl) countEl.innerText = `${dorms.length} แห่ง`;

  if (dorms.length === 0) {
    container.innerHTML = `
      <div class="col-span-full bg-white p-12 rounded-2xl text-center border border-slate-200 shadow-sm">
        <i class="fa-solid fa-building-circle-exclamation text-4xl text-slate-300 mb-3"></i>
        <h3 class="font-bold text-slate-700 text-lg">ไม่พบหอพักตามเงื่อนไขที่ค้นหา</h3>
        <p class="text-xs text-slate-500 mt-1">ลองขยายช่วงราคา หรือล้างตัวกรองเพื่อค้นหาหอพักโซนอื่น</p>
        <button onclick="resetFilters()" class="mt-4 bg-brand-600 text-white text-xs font-semibold px-4 py-2 rounded-xl cursor-pointer">ล้างตัวกรองค้นหา</button>
      </div>
    `;
    return;
  }

  container.innerHTML = dorms.map(d => {
    const isCompared = compareList.includes(d.id);
    const coverPhoto = d.photos.STUDENT[0]?.url || d.photos.LANDLORD[0]?.url;

    return `
      <div onclick="openDormDetailModal(${d.id})" class="glass-card overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col group border border-slate-200/90 cursor-pointer">
        
        <!-- Image & Badges Banner -->
        <div class="relative h-48 w-full overflow-hidden bg-slate-100">
          <img src="${coverPhoto}" alt="${d.name}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
          <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent"></div>
          
          <!-- Top Badges -->
          <div class="absolute top-3 left-3 right-3 flex items-center justify-between">
            <span class="bg-slate-900/80 backdrop-blur-md text-white text-[11px] font-bold px-2.5 py-1 rounded-lg">
              ${d.uniName}
            </span>
            <a href="${d.googleMapUrl}" target="_blank" rel="noopener noreferrer" onclick="event.stopPropagation()" class="bg-emerald-600/90 hover:bg-emerald-600 backdrop-blur-md text-white text-[11px] font-semibold px-2.5 py-1 rounded-lg shadow-sm flex items-center gap-1 transition-all">
              <i class="fa-solid fa-map-location-dot"></i> Google Maps
            </a>
          </div>

          <!-- Rating Overlay -->
          <div class="absolute bottom-3 left-3 right-3 flex justify-between items-end text-white">
            <div>
              <span class="text-xs opacity-90 block font-medium">🚶 <strong>${d.walkingMin} นาที</strong> ถึง ม. (${d.distanceKm} กม.)</span>
            </div>
            <div class="bg-amber-500 text-slate-950 font-extrabold text-xs px-2.5 py-1 rounded-lg shadow-md flex items-center gap-1">
              <span>⭐ ${d.overallRating}</span> <span class="text-[10px] opacity-80">/ 5</span>
            </div>
          </div>
        </div>

        <!-- Card Body -->
        <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
          <div>
            <h3 class="font-bold text-slate-900 text-base leading-snug group-hover:text-brand-600 transition-colors line-clamp-1">
              ${d.name}
            </h3>
            <p class="text-xs text-slate-500 mt-1 line-clamp-1">
              <i class="fa-solid fa-location-dot text-rose-500 mr-1"></i> ${d.address}
            </p>

            <!-- Price & Utilities -->
            <div class="mt-3 bg-slate-50 p-2.5 rounded-xl border border-slate-100 flex items-center justify-between">
              <div>
                <span class="text-[10px] text-slate-500 block">ค่าเช่าเริ่มต้น</span>
                <span class="text-base font-extrabold text-brand-600">${d.priceMonthly.toLocaleString()}</span> <span class="text-xs font-normal text-slate-600">บาท/เดือน</span>
              </div>
              <div class="text-right text-[11px] text-slate-600 space-y-0.5">
                <div><span>💧 น้ำ ${d.waterRate}฿</span> • <span>⚡ ไฟ ${d.electricRate}฿</span></div>
                <a href="calculator.php?id=${d.id}" onclick="event.stopPropagation()" class="text-[10px] text-brand-600 hover:text-brand-800 font-bold inline-flex items-center gap-1 hover:underline">
                  <i class="fa-solid fa-calculator text-[9px]"></i> คำนวณค่าน้ำไฟ
                </a>
              </div>
            </div>

            <!-- AI Pros & Cons Preview Badge -->
            <div class="mt-3 bg-indigo-50/70 p-3 rounded-xl border border-indigo-100 text-xs space-y-1">
              <div class="font-bold text-indigo-900 text-[11px] flex items-center gap-1">
                <i class="fa-solid fa-wand-magic-sparkles text-accent-purple"></i> AI รีวิวไฮไลท์:
              </div>
              <p class="text-slate-700 text-[11px] line-clamp-1">
                🟢 ${d.aiSummary.pros[0]}
              </p>
              <p class="text-amber-800 text-[11px] line-clamp-1">
                ⚠️ ${d.aiSummary.considerations[0]}
              </p>
            </div>
          </div>

          <!-- Card Actions -->
          <div class="pt-2 border-t border-slate-100 flex items-center justify-between gap-2">
            <label onclick="event.stopPropagation()" class="flex items-center gap-1.5 text-xs text-slate-600 cursor-pointer select-none font-medium">
              <input type="checkbox" onchange="toggleCompare(${d.id})" ${isCompared ? 'checked' : ''} class="rounded text-purple-600 focus:ring-purple-500 w-4 h-4">
              <span>เทียบ (Compare)</span>
            </label>

            <button onclick="openDormDetailModal(${d.id}); event.stopPropagation();" class="bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs px-3.5 py-2 rounded-xl shadow-sm transition-all flex items-center gap-1.5 cursor-pointer">
              <span>รายละเอียด & AI</span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
          </div>

        </div>

      </div>
    `;
  }).join('');
}


// ====================================================================
// OPEN DORM DETAIL (SUPPORT BOTH MODAL POPUP & DEDICATED PAGE REDIRECT)
// ====================================================================
function openDormDetailModal(dormId) {
  const dorm = dormsData.find(d => d.id === dormId);
  if (!dorm) return;
  activeDormForModal = dorm;

  const modal = document.getElementById('dorm-detail-modal');
  if (modal) {
    // Populate Modal
    if (document.getElementById('modal-uni-tag')) document.getElementById('modal-uni-tag').innerText = dorm.uniName;
    if (document.getElementById('modal-dorm-name')) document.getElementById('modal-dorm-name').innerText = dorm.name;
    if (document.getElementById('modal-dorm-address')) document.getElementById('modal-dorm-address').innerHTML = `<i class="fa-solid fa-location-dot text-rose-400 mr-1"></i> ${dorm.address}`;
    if (document.getElementById('modal-price')) document.getElementById('modal-price').innerText = dorm.priceMonthly.toLocaleString();
    if (document.getElementById('modal-water')) document.getElementById('modal-water').innerText = dorm.waterRate;
    if (document.getElementById('modal-electric')) document.getElementById('modal-electric').innerText = dorm.electricRate;
    if (document.getElementById('modal-walk')) document.getElementById('modal-walk').innerText = `🚶 ${dorm.walkingMin} นาที (${dorm.distanceKm} กม.)`;
    if (document.getElementById('modal-overall-score')) document.getElementById('modal-overall-score').innerText = `⭐ ${dorm.overallRating} / 5`;

    // Google Maps Iframe & Direct Link
    if (document.getElementById('modal-google-map-iframe')) {
      document.getElementById('modal-google-map-iframe').src = dorm.googleMapEmbedUrl;
    }
    if (document.getElementById('modal-google-map-btn')) {
      document.getElementById('modal-google-map-btn').href = dorm.googleMapUrl;
    }
    if (document.getElementById('modal-full-page-btn')) {
      document.getElementById('modal-full-page-btn').href = 'dorm-detail.html';
    }

    // AI Pros & Cons
    if (document.getElementById('modal-ai-pros')) {
      document.getElementById('modal-ai-pros').innerHTML = dorm.aiSummary.pros.map(p => `<li class="flex items-start gap-1.5"><span>•</span> <span>${p}</span></li>`).join('');
    }
    if (document.getElementById('modal-ai-cons')) {
      document.getElementById('modal-ai-cons').innerHTML = dorm.aiSummary.considerations.map(c => `<li class="flex items-start gap-1.5"><span>•</span> <span>${c}</span></li>`).join('');
    }

    // Rating Bars
    renderRatingBarsGrid(dorm.ratings);

    // Specialized AI summaries
    if (document.getElementById('detail-score-net')) document.getElementById('detail-score-net').innerText = `${dorm.ratings.internet} / 5`;
    if (document.getElementById('detail-ai-net')) document.getElementById('detail-ai-net').innerText = `AI: ${dorm.aiSummary.wifiSummary}`;

    if (document.getElementById('detail-score-quiet')) document.getElementById('detail-score-quiet').innerText = `${dorm.ratings.quietness} / 5`;
    if (document.getElementById('detail-ai-quiet')) document.getElementById('detail-ai-quiet').innerText = `AI: ${dorm.aiSummary.quietSummary}`;

    if (document.getElementById('detail-score-water')) document.getElementById('detail-score-water').innerText = `${dorm.ratings.waterSupply} / 5`;
    if (document.getElementById('detail-ai-water')) document.getElementById('detail-ai-water').innerText = `AI: ${dorm.aiSummary.waterSummary}`;

    switchPhotoTab('STUDENT');
    renderQaList(dorm.qa);

    modal.classList.remove('hidden');
  } else {
    // This project uses the standalone Freshy detail page as its dorm detail.
    window.location.href = 'dorm-detail.html';
  }
}

function closeDormDetailModal() {
  const modal = document.getElementById('dorm-detail-modal');
  if (modal) modal.classList.add('hidden');
}


// ====================================================================
// DORM COMPARISON LOGIC (SHARED ACROSS PAGES)
// ====================================================================
function toggleCompare(dormId) {
  const idx = compareList.indexOf(dormId);
  if (idx > -1) {
    compareList.splice(idx, 1);
  } else {
    if (compareList.length >= 3) {
      alert('เปรียบเทียบได้สูงสุด 3 หอพักเท่านั้นครับ!');
      if (document.getElementById('dorms-container')) applyFilters();
      return;
    }
    compareList.push(dormId);
  }

  saveCompareState();
  if (document.getElementById('dorms-container')) applyFilters();
  if (document.getElementById('compare-page-table-container')) initComparePage();
}

function clearCompareList() {
  compareList = [];
  saveCompareState();
  if (document.getElementById('dorms-container')) applyFilters();
  if (document.getElementById('compare-page-table-container')) initComparePage();
}


// ====================================================================
// DORM DETAIL PAGE LOGIC (dorm-detail.html)
// ====================================================================
let currentDetailDorm = null;

function initDormDetailPage() {
  const dormId = parseInt(getQueryParam('id')) || 1;
  const dorm = dormsData.find(d => d.id === dormId) || dormsData[0];
  currentDetailDorm = dorm;

  // Title & Header Info
  document.title = `${dorm.name} | JingJai`;
  if (document.getElementById('detail-dorm-name')) document.getElementById('detail-dorm-name').innerText = dorm.name;
  if (document.getElementById('detail-uni-name')) document.getElementById('detail-uni-name').innerText = dorm.uniName;
  if (document.getElementById('detail-address')) document.getElementById('detail-address').innerText = dorm.address;

  // Metrics
  if (document.getElementById('detail-price')) document.getElementById('detail-price').innerText = dorm.priceMonthly.toLocaleString();
  if (document.getElementById('detail-water-rate')) document.getElementById('detail-water-rate').innerText = dorm.waterRate;
  if (document.getElementById('detail-electric-rate')) document.getElementById('detail-electric-rate').innerText = dorm.electricRate;
  if (document.getElementById('detail-walk')) document.getElementById('detail-walk').innerText = `🚶 ${dorm.walkingMin} นาที (${dorm.distanceKm} กม.)`;
  if (document.getElementById('detail-rating')) document.getElementById('detail-rating').innerText = `⭐ ${dorm.overallRating} / 5`;

  // Google Maps Iframe & Direct Link
  if (document.getElementById('google-map-iframe')) {
    document.getElementById('google-map-iframe').src = dorm.googleMapEmbedUrl;
  }
  if (document.getElementById('google-map-btn')) {
    document.getElementById('google-map-btn').href = dorm.googleMapUrl;
  }

  // AI Summaries
  if (document.getElementById('detail-ai-pros')) {
    document.getElementById('detail-ai-pros').innerHTML = dorm.aiSummary.pros.map(p => `
      <li class="flex items-start gap-2 text-slate-700 text-sm">
        <i class="fa-solid fa-circle-check text-emerald-500 mt-1"></i> <span>${p}</span>
      </li>
    `).join('');
  }

  if (document.getElementById('detail-ai-cons')) {
    document.getElementById('detail-ai-cons').innerHTML = dorm.aiSummary.considerations.map(c => `
      <li class="flex items-start gap-2 text-slate-700 text-sm">
        <i class="fa-solid fa-triangle-exclamation text-amber-500 mt-1"></i> <span>${c}</span>
      </li>
    `).join('');
  }

  // Specialized AI summaries
  if (document.getElementById('detail-score-net')) document.getElementById('detail-score-net').innerText = `${dorm.ratings.internet} / 5`;
  if (document.getElementById('detail-ai-net')) document.getElementById('detail-ai-net').innerText = `AI: ${dorm.aiSummary.wifiSummary}`;

  if (document.getElementById('detail-score-quiet')) document.getElementById('detail-score-quiet').innerText = `${dorm.ratings.quietness} / 5`;
  if (document.getElementById('detail-ai-quiet')) document.getElementById('detail-ai-quiet').innerText = `AI: ${dorm.aiSummary.quietSummary}`;

  if (document.getElementById('detail-score-water')) document.getElementById('detail-score-water').innerText = `${dorm.ratings.waterSupply} / 5`;
  if (document.getElementById('detail-ai-water')) document.getElementById('detail-ai-water').innerText = `AI: ${dorm.aiSummary.waterSummary}`;

  // Rating Progress Bars
  renderRatingBarsGrid(dorm.ratings);

  // Photos
  switchDetailPhotoTab('STUDENT');

  // Student Q&A
  renderQaList(dorm.qa);

  // Compare Checkbox State
  const chkCompare = document.getElementById('detail-compare-chk');
  if (chkCompare) {
    chkCompare.checked = compareList.includes(dorm.id);
    chkCompare.onchange = () => toggleCompare(dorm.id);
  }
}

function switchDetailPhotoTab(source) {
  if (!currentDetailDorm) return;

  const btnStudent = document.getElementById('photo-tab-student');
  const btnLandlord = document.getElementById('photo-tab-landlord');

  if (btnStudent && btnLandlord) {
    if (source === 'STUDENT') {
      btnStudent.className = "px-4 py-2 rounded-xl transition-all bg-white text-brand-600 shadow-sm font-semibold text-xs cursor-pointer";
      btnLandlord.className = "px-4 py-2 rounded-xl transition-all text-slate-600 hover:text-brand-600 font-semibold text-xs cursor-pointer";
    } else {
      btnLandlord.className = "px-4 py-2 rounded-xl transition-all bg-white text-brand-600 shadow-sm font-semibold text-xs cursor-pointer";
      btnStudent.className = "px-4 py-2 rounded-xl transition-all text-slate-600 hover:text-brand-600 font-semibold text-xs cursor-pointer";
    }
  }

  const container = document.getElementById('photos-gallery-grid');
  const photos = currentDetailDorm.photos[source] || [];

  if (container) {
    if (photos.length === 0) {
      container.innerHTML = `<p class="col-span-full text-center text-xs text-slate-400 py-6">ยังไม่มีรูปถ่ายในหมวดนี้</p>`;
      return;
    }

    container.innerHTML = photos.map(p => `
      <div onclick="openPhotoLightbox('${p.url.replace(/'/g, "\\'")}', '${p.caption.replace(/'/g, "\\'")}')" class="relative group rounded-2xl overflow-hidden bg-slate-100 h-44 border border-slate-200 shadow-sm cursor-pointer ring-1 ring-slate-200 hover:ring-brand-300 hover:shadow-lg hover:-translate-y-0.5 transition-all">
        <img src="${p.url}" alt="${p.caption}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-3 flex items-end">
          <span class="text-white text-xs font-medium leading-snug">${p.caption}</span>
        </div>
        <div class="absolute top-3 right-3 bg-white/85 text-slate-700 rounded-full w-8 h-8 flex items-center justify-center shadow-sm">
          <i class="fa-solid fa-expand text-[11px]"></i>
        </div>
      </div>
    `).join('');
  }
}

function switchPhotoTab(source) {
  activePhotoSource = source;
  const btnStudent = document.getElementById('photo-tab-student');
  const btnLandlord = document.getElementById('photo-tab-landlord');

  if (btnStudent && btnLandlord) {
    if (source === 'STUDENT') {
      btnStudent.className = "px-3 py-1.5 rounded-lg transition-all bg-white text-brand-600 shadow-sm font-semibold cursor-pointer";
      btnLandlord.className = "px-3 py-1.5 rounded-lg transition-all text-slate-600 hover:text-brand-600 font-semibold cursor-pointer";
    } else {
      btnLandlord.className = "px-3 py-1.5 rounded-lg transition-all bg-white text-brand-600 shadow-sm font-semibold cursor-pointer";
      btnStudent.className = "px-3 py-1.5 rounded-lg transition-all text-slate-600 hover:text-brand-600 font-semibold cursor-pointer";
    }
  }

  const container = document.getElementById('photos-gallery-grid');
  const targetDorm = activeDormForModal || currentDetailDorm || dormsData[0];
  const photos = targetDorm.photos[source] || [];

  if (container) {
    if (photos.length === 0) {
      container.innerHTML = `<p class="col-span-full text-center text-xs text-slate-400 py-4">ยังไม่มีรูปถ่ายในหมวดนี้</p>`;
      return;
    }

    container.innerHTML = photos.map(p => `
      <div onclick="openPhotoLightbox('${p.url.replace(/'/g, "\\'")}', '${p.caption.replace(/'/g, "\\'")}')" class="relative group rounded-xl overflow-hidden bg-slate-100 h-36 border border-slate-200 cursor-pointer shadow-sm hover:shadow-lg hover:-translate-y-0.5 transition-all">
        <img src="${p.url}" alt="${p.caption}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/75 via-slate-900/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity p-2 flex items-end">
          <span class="text-white text-[10px] font-medium leading-tight">${p.caption}</span>
        </div>
        <div class="absolute top-2 right-2 bg-white/85 text-slate-700 rounded-full w-7 h-7 flex items-center justify-center shadow-sm">
          <i class="fa-solid fa-expand text-[10px]"></i>
        </div>
      </div>
    `).join('');
  }
}

function openPhotoLightbox(imageUrl, caption) {
  const lightbox = document.getElementById('photo-lightbox');
  const lightboxImg = document.getElementById('lightbox-image');
  const lightboxCaption = document.getElementById('lightbox-caption');

  if (!lightbox || !lightboxImg || !lightboxCaption) return;

  lightboxImg.src = imageUrl;
  lightboxImg.alt = caption || 'รูปภาพหอพัก';
  lightboxCaption.innerText = caption || 'รูปภาพหอพัก';
  lightbox.classList.remove('hidden');
}

function closePhotoLightbox() {
  const lightbox = document.getElementById('photo-lightbox');
  if (lightbox) lightbox.classList.add('hidden');
}

document.addEventListener('keydown', (event) => {
  if (event.key === 'Escape') {
    closePhotoLightbox();
  }
});

function renderRatingBarsGrid(ratings) {
  const container = document.getElementById('ratings-bars-grid');
  if (!container) return;

  const items = [
    { label: '🔇 ความเงียบสงบ', score: ratings.quietness },
    { label: '🚿 น้ำประปา', score: ratings.waterSupply },
    { label: '🌐 อินเทอร์เน็ต', score: ratings.internet },
    { label: '🔒 ความปลอดภัย', score: ratings.security },
    { label: '😊 เจ้าของหอ', score: ratings.landlord },
    { label: '🧹 ความสะอาด', score: ratings.cleanliness }
  ];

  container.innerHTML = items.map(item => {
    const pct = (item.score / 5) * 100;
    const barColor = item.score >= 4.5 ? 'bg-emerald-500' : item.score >= 3.8 ? 'bg-brand-500' : 'bg-amber-500';

    return `
      <div class="space-y-1.5">
        <div class="flex justify-between text-xs font-semibold text-slate-700">
          <span>${item.label}</span>
          <span class="font-bold text-slate-900">${item.score} / 5</span>
        </div>
        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
          <div class="${barColor} h-2.5 rounded-full transition-all duration-500" style="width: ${pct}%"></div>
        </div>
      </div>
    `;
  }).join('');
}


// ====================================================================
// STUDENT Q&A SECTION LOGIC
// ====================================================================
function renderQaList(qaItems) {
  const container = document.getElementById('qa-list-container');
  if (!container) return;

  if (!qaItems || qaItems.length === 0) {
    container.innerHTML = `<p class="text-xs text-slate-400 italic">ยังไม่มีคำถาม สามารถกดถามคำถามแรกได้เลยครับ</p>`;
    return;
  }

  container.innerHTML = qaItems.map(item => `
    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-2 text-xs">
      <div class="flex items-start gap-2">
        <span class="bg-brand-100 text-brand-700 font-bold px-2 py-0.5 rounded text-[10px]">Q</span>
        <div>
          <span class="font-bold text-slate-900 text-sm">${item.q}</span>
          <span class="text-[10px] text-slate-500 block">โดย: ${item.asker}</span>
        </div>
      </div>
      ${item.a ? `
        <div class="flex items-start gap-2 pl-4 border-l-2 border-brand-500 bg-white p-3 rounded-lg shadow-2xs">
          <span class="bg-emerald-100 text-emerald-700 font-bold px-2 py-0.5 rounded text-[10px]">A</span>
          <div>
            <span class="text-slate-700 font-medium">${item.a}</span>
            <span class="text-[10px] text-slate-400 block">โดย: ${item.responder}</span>
          </div>
        </div>
      ` : `<p class="text-[11px] text-amber-600 italic pl-4">รอผู้พักปัจจุบันมาตอบคำถาม...</p>`}
    </div>
  `).join('');
}

function toggleAddQaForm() {
  const form = document.getElementById('qa-form');
  if (form) form.classList.toggle('hidden');
}

function submitNewQuestion() {
  const nameInput = document.getElementById('qa-name-input');
  const textInput = document.getElementById('qa-text-input');
  const name = nameInput ? nameInput.value.trim() || 'นิสิตทั่วไป' : 'นิสิตทั่วไป';
  const qText = textInput ? textInput.value.trim() : '';

  if (!qText) {
    alert('กรุณากรอกคำถามของคุณ');
    return;
  }

  const targetDorm = activeDormForModal || currentDetailDorm;
  if (targetDorm) {
    targetDorm.qa.unshift({
      q: qText,
      asker: name,
      a: null,
      responder: null
    });
    if (textInput) textInput.value = '';
    toggleAddQaForm();
    renderQaList(targetDorm.qa);
    alert('ส่งคำถามเรียบร้อยแล้ว');
  }
}


// ====================================================================
// COMPARE PAGE LOGIC (compare.html)
// ====================================================================
function initComparePage() {
  const container = document.getElementById('compare-page-table-container');
  if (!container) return;

  const selectedDorms = dormsData.filter(d => compareList.includes(d.id));

  if (selectedDorms.length === 0) {
    container.innerHTML = `
      <div class="text-center py-16 bg-white rounded-3xl border border-slate-200 p-8">
        <i class="fa-solid fa-code-compare text-5xl text-slate-300 mb-4"></i>
        <h3 class="font-bold text-slate-700 text-lg">ยังไม่มีหอพักในรายการเปรียบเทียบ</h3>
        <p class="text-xs text-slate-500 mt-2">โปรดไปที่หน้าหลักและคลิกติ๊กถูก [เทียบ (Compare)] บนการ์ดหอพักที่ต้องการเปรียบเทียบ</p>
        <a href="index.php" class="inline-block mt-6 bg-brand-600 text-white text-xs font-semibold px-5 py-2.5 rounded-xl shadow-md hover:bg-brand-700 transition-colors">
          <i class="fa-solid fa-arrow-left mr-1.5"></i> กลับไปเลือกหอพักหน้าหลัก
        </a>
      </div>
    `;
    return;
  }

  container.innerHTML = `
    <div class="overflow-x-auto">
      <table class="w-full text-left text-xs border-collapse bg-white rounded-2xl overflow-hidden border border-slate-200 shadow-sm">
        <thead>
          <tr class="border-b border-slate-200">
            <th class="p-4 bg-slate-50 w-44 font-bold text-slate-700">หัวข้อเปรียบเทียบ</th>
            ${selectedDorms.map(d => `
              <th class="p-4 bg-white font-bold text-slate-900 text-sm border-l border-slate-200 min-w-[240px]">
                <div class="flex justify-between items-start">
                  <div>
                    <a href="dorm-detail.html" class="text-brand-600 hover:underline font-bold text-base block">${d.name}</a>
                    <span class="text-[11px] text-slate-500 font-normal block">${d.uniName}</span>
                  </div>
                  <button onclick="toggleCompare(${d.id})" class="text-rose-500 hover:text-rose-700 text-xs px-2 py-1 bg-rose-50 rounded-lg cursor-pointer">
                    <i class="fa-solid fa-trash-can"></i>
                  </button>
                </div>
              </th>
            `).join('')}
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-200">
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">ค่าเช่ารายเดือน</td>
            ${selectedDorms.map(d => `<td class="p-4 border-l text-brand-600 font-extrabold text-base">${d.priceMonthly.toLocaleString()} บาท/เดือน</td>`).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">ค่าน้ำ / ค่าไฟ (ยูนิต)</td>
            ${selectedDorms.map(d => `<td class="p-4 border-l font-medium">💧 ${d.waterRate}฿ / ⚡ ${d.electricRate}฿</td>`).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">ระยะทาง & เวลาเดิน</td>
            ${selectedDorms.map(d => `<td class="p-4 border-l font-medium">🚶 ${d.walkingMin} นาที (${d.distanceKm} กม.)</td>`).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">Google Maps นำทาง</td>
            ${selectedDorms.map(d => `
              <td class="p-4 border-l">
                <a href="${d.googleMapUrl}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 text-xs bg-emerald-50 hover:bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded-lg border border-emerald-200 font-semibold transition-colors">
                  <i class="fa-solid fa-map-location-dot"></i> เปิดใน Google Maps
                </a>
              </td>
            `).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">คะแนนรวมนิสิต</td>
            ${selectedDorms.map(d => `<td class="p-4 border-l text-amber-600 font-extrabold text-sm">⭐ ${d.overallRating} / 5</td>`).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">🔇 ความเงียบสงบ</td>
            ${selectedDorms.map(d => `<td class="p-4 border-l font-bold">${d.ratings.quietness} / 5</td>`).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">🚿 น้ำประปา</td>
            ${selectedDorms.map(d => `<td class="p-4 border-l font-bold">${d.ratings.waterSupply} / 5</td>`).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">🌐 อินเทอร์เน็ต</td>
            ${selectedDorms.map(d => `<td class="p-4 border-l font-bold">${d.ratings.internet} / 5</td>`).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">ข้อดีสรุปโดย AI</td>
            ${selectedDorms.map(d => `
              <td class="p-4 border-l text-xs text-slate-600 space-y-1.5">
                ${d.aiSummary.pros.map(p => `<div class="flex items-start gap-1"><span class="text-emerald-500">🟢</span> <span>${p}</span></div>`).join('')}
              </td>
            `).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">ข้อควรทราบสรุปโดย AI</td>
            ${selectedDorms.map(d => `
              <td class="p-4 border-l text-xs text-amber-800 space-y-1.5">
                ${d.aiSummary.considerations.map(c => `<div class="flex items-start gap-1"><span class="text-amber-500">⚠️</span> <span>${c}</span></div>`).join('')}
              </td>
            `).join('')}
          </tr>
          <tr>
            <td class="p-4 font-semibold bg-slate-50 text-slate-700">การดำเนินการ</td>
            ${selectedDorms.map(d => `
              <td class="p-4 border-l">
                <button onclick="openDormDetailModal(${d.id})" class="w-full text-center bg-brand-600 hover:bg-brand-700 text-white font-semibold px-4 py-2 rounded-xl shadow-xs transition-colors cursor-pointer">
                  ดูหน้ารายละเอียด
                </button>
              </td>
            `).join('')}
          </tr>
        </tbody>
      </table>
    </div>
  `;
}


// ====================================================================
// MONTHLY EXPENSE CALCULATOR PAGE LOGIC (calculator.html)
// ====================================================================
function initCalculatorPage() {
  const select = document.getElementById('calc-dorm-select');
  if (!select) return;

  select.innerHTML = dormsData.map(d => `
    <option value="${d.id}">${d.name} (${d.priceMonthly.toLocaleString()} ฿/เดือน - ${d.uniName})</option>
  `).join('');

  const preselectId = parseInt(getQueryParam('id')) || parseInt(getQueryParam('dorm'));
  if (preselectId && dormsData.some(d => d.id === preselectId)) {
    select.value = preselectId;
  }

  select.onchange = calculateMonthlyExpense;
  calculateMonthlyExpense();
}

function calculateMonthlyExpense() {
  const select = document.getElementById('calc-dorm-select');
  if (!select) return;

  const dormId = parseInt(select.value);
  const dorm = dormsData.find(d => d.id === dormId);
  if (!dorm) return;

  const waterUnits = parseFloat(document.getElementById('calc-water-units')?.value) || 0;
  const electricUnits = parseFloat(document.getElementById('calc-electric-units')?.value) || 0;
  const travelCost = parseFloat(document.getElementById('calc-travel-cost')?.value) || 0;

  if (document.getElementById('calc-water-rate-display')) document.getElementById('calc-water-rate-display').innerText = dorm.waterRate;
  if (document.getElementById('calc-electric-rate-display')) document.getElementById('calc-electric-rate-display').innerText = dorm.electricRate;

  const rentSum = dorm.priceMonthly;
  const waterSum = waterUnits * dorm.waterRate;
  const electricSum = electricUnits * dorm.electricRate;
  const totalSum = rentSum + waterSum + electricSum + travelCost;

  if (document.getElementById('calc-rent-sum')) document.getElementById('calc-rent-sum').innerText = `${rentSum.toLocaleString()} บาท`;
  if (document.getElementById('calc-water-sum')) document.getElementById('calc-water-sum').innerText = `${waterSum.toLocaleString(undefined, { minimumFractionDigits: 0 })} บาท`;
  if (document.getElementById('calc-electric-sum')) document.getElementById('calc-electric-sum').innerText = `${electricSum.toLocaleString(undefined, { minimumFractionDigits: 0 })} บาท`;
  if (document.getElementById('calc-travel-sum')) document.getElementById('calc-travel-sum').innerText = `${travelCost.toLocaleString(undefined, { minimumFractionDigits: 0 })} บาท`;
  if (document.getElementById('calc-total-sum')) document.getElementById('calc-total-sum').innerText = `${totalSum.toLocaleString(undefined, { minimumFractionDigits: 0 })} บาท/เดือน`;
}


// ====================================================================
// MAID SERVICE & MOVING SERVICE (BOOKING SYSTEM & STATE)
// ====================================================================

// In-memory + LocalStorage Bookings
let userBookings = JSON.parse(localStorage.getItem('jingjai_user_bookings') || '[]');

function saveBookingsState() {
  localStorage.setItem('jingjai_user_bookings', JSON.stringify(userBookings));
  updateBookingBadges();
}

function updateBookingBadges() {
  const count = userBookings.length;
  document.querySelectorAll('.my-bookings-count').forEach(el => {
    el.innerText = count;
    if (count > 0) {
      el.classList.remove('hidden');
    } else {
      el.classList.add('hidden');
    }
  });
}

// Maid Service State
let maidBookingState = {
  packageKey: 'general',
  basePrice: 350,
  addons: {
    balcony: false,
    ozone: false
  },
  discount: 0,
  discountCode: ''
};

const MAID_PACKAGES = {
  general: { name: 'ทำความสะอาดทั่วไปรายครั้ง (Standard Clean)', price: 350, desc: 'กวาด ถู ดูดฝุ่น เช็ดกระจก ล้างห้องน้ำ เปลี่ยนผ้าปู' },
  deep: { name: 'Deep Clean ก่อนเข้าพัก / ย้ายออกคืนห้อง', price: 500, desc: 'ขัดคราบฝังแน่นทุกซอกมุม ขัดคราบกระจก ล้างระเบียง พร้อมเข้าอยู่' },
  ac: { name: 'บริการล้างเครื่องปรับอากาศหอพัก', price: 400, desc: 'ฉีดล้างฟิลเตอร์ ล้างแผงคอยล์เย็น เช็คระดับน้ำยาแอร์ ฟรีเช็คระบบ' },
  combo: { name: 'Combo Big Clean + ซักผ้าปู/ผ้าม่าน', price: 650, desc: 'คลีนใหญ่ทั้งห้อง + ดูดไรฝุ่นที่นอน และซักเซ็ตเครื่องนอนหอมสะอาด' }
};

// Moving Service State
let movingBookingState = {
  vehicleType: 'pickup_box',
  basePrice: 450,
  helperLevel: 1, // 0, 1, 2
  helperFee: 150,
  stairsAddon: false,
  stairsFee: 100
};

const MOVING_VEHICLES = {
  pickup_box: { name: 'รถกระบะตู้ทึบกันฝน (ยอดนิยมย้ายหอ)', price: 450, desc: 'ของไม่เปียกฝน ปลอดภัย บรรจุตู้เย็น เตียง 5 ฟุต โต๊ะได้ครบ' },
  pickup_open: { name: 'รถกระบะคอกสูง + ผ้าใบคลุม', price: 450, desc: 'ขนของชิ้นสูงได้ดี เชือกมัดแน่นหนา ผ้าใบกันแดดกันฝน' },
  sidecar: { name: 'รถมอเตอร์ไซค์พ่วงข้าง (ของน้อย/ระยะใกล้)', price: 200, desc: 'เหมาะกับย้ายกระเป๋า ลังเสื้อผ้า ไม่เกิน 5-6 ชิ้น ในระยะ 3 กม.' },
  truck4w: { name: 'รถ 4 ล้อใหญ่จัมโบ้ (ของเยอะมาก/ย้ายเป็นกลุ่ม)', price: 800, desc: 'พื้นที่กว้าง จุของได้เทียบเท่ากระบะ 2 คัน ย้ายห้องพร้อมรูมเมท' }
};


// --------------------------------------------------------------------
// OPEN / CLOSE MAID SERVICE MODAL
// --------------------------------------------------------------------
function openMaidServiceModal(preselectedDormName = '') {
  const modal = document.getElementById('maid-service-modal');
  if (!modal) return;

  // Reset State
  maidBookingState.packageKey = 'general';
  maidBookingState.basePrice = MAID_PACKAGES.general.price;
  maidBookingState.addons.balcony = false;
  maidBookingState.addons.ozone = false;
  maidBookingState.discount = 0;
  maidBookingState.discountCode = '';

  // Reset checkboxes and promo input
  const chkBalcony = document.getElementById('maid-addon-balcony');
  if (chkBalcony) chkBalcony.checked = false;
  const chkOzone = document.getElementById('maid-addon-ozone');
  if (chkOzone) chkOzone.checked = false;
  const promoInput = document.getElementById('maid-promo-input');
  if (promoInput) promoInput.value = '';
  const promoMsg = document.getElementById('maid-promo-msg');
  if (promoMsg) {
    promoMsg.classList.add('hidden');
    promoMsg.innerText = '';
  }

  // Populate Dorm Dropdown
  const dormSelect = document.getElementById('maid-dorm-select');
  if (dormSelect) {
    dormSelect.innerHTML = `
      <option value="">-- เลือกหอพักจากระบบ --</option>
      ${dormsData.map(d => `<option value="${d.name}">${d.name} (${d.uniName})</option>`).join('')}
      <option value="OTHER">-- อื่นๆ (พิมพ์ระบุเองด้านล่าง) --</option>
    `;

    if (preselectedDormName) {
      const match = dormsData.find(d => d.name === preselectedDormName || d.name.includes(preselectedDormName));
      if (match) {
        dormSelect.value = match.name;
      } else {
        dormSelect.value = 'OTHER';
        const customInput = document.getElementById('maid-custom-dorm');
        if (customInput) customInput.value = preselectedDormName;
      }
    }
  }

  // Set default date to tomorrow
  const dateInput = document.getElementById('maid-date-input');
  if (dateInput) {
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);
    dateInput.value = tomorrow.toISOString().split('T')[0];
    dateInput.min = new Date().toISOString().split('T')[0];
  }

  // Update UI & calculation
  updateMaidPackageCardsUI();
  calculateMaidTotal();

  modal.classList.remove('hidden');
}

function closeMaidServiceModal() {
  const modal = document.getElementById('maid-service-modal');
  if (modal) modal.classList.add('hidden');
}

function selectMaidPackage(pkgKey) {
  if (!MAID_PACKAGES[pkgKey]) return;
  maidBookingState.packageKey = pkgKey;
  maidBookingState.basePrice = MAID_PACKAGES[pkgKey].price;
  updateMaidPackageCardsUI();
  calculateMaidTotal();
}

function updateMaidPackageCardsUI() {
  document.querySelectorAll('.maid-pkg-card').forEach(card => {
    const key = card.getAttribute('data-pkg');
    if (key === maidBookingState.packageKey) {
      card.classList.add('border-pink-500', 'bg-pink-50/80', 'ring-2', 'ring-pink-400');
      card.classList.remove('border-slate-200', 'bg-white');
    } else {
      card.classList.remove('border-pink-500', 'bg-pink-50/80', 'ring-2', 'ring-pink-400');
      card.classList.add('border-slate-200', 'bg-white');
    }
  });
}

function toggleMaidAddon(addonName) {
  if (addonName === 'balcony') {
    const chk = document.getElementById('maid-addon-balcony');
    maidBookingState.addons.balcony = chk ? chk.checked : false;
  } else if (addonName === 'ozone') {
    const chk = document.getElementById('maid-addon-ozone');
    maidBookingState.addons.ozone = chk ? chk.checked : false;
  }
  calculateMaidTotal();
}

function applyMaidDiscount() {
  const promoInput = document.getElementById('maid-promo-input');
  const promoMsg = document.getElementById('maid-promo-msg');
  const code = promoInput ? promoInput.value.trim().toUpperCase() : '';

  if (!code) return;

  if (code === 'STUDENT50' || code === 'JINGJAI50' || code === 'FRESHY') {
    maidBookingState.discount = 50;
    maidBookingState.discountCode = code;
    if (promoMsg) {
      promoMsg.className = 'text-xs text-emerald-600 font-semibold block mt-1';
      promoMsg.innerHTML = '<i class="fa-solid fa-circle-check mr-1"></i> โค้ดส่วนลดถูกต้อง: ลด 50 บาท';
      promoMsg.classList.remove('hidden');
    }
  } else {
    maidBookingState.discount = 0;
    maidBookingState.discountCode = '';
    if (promoMsg) {
      promoMsg.className = 'text-xs text-rose-600 font-semibold block mt-1';
      promoMsg.innerHTML = '<i class="fa-solid fa-circle-xmark mr-1"></i> โค้ดไม่ถูกต้องหรือหมดอายุ (ลองใช้ STUDENT50)';
      promoMsg.classList.remove('hidden');
    }
  }
  calculateMaidTotal();
}

function calculateMaidTotal() {
  let total = maidBookingState.basePrice;
  if (maidBookingState.addons.balcony) total += 100;
  if (maidBookingState.addons.ozone) total += 150;
  total = Math.max(0, total - maidBookingState.discount);

  if (document.getElementById('maid-calc-package-name')) {
    document.getElementById('maid-calc-package-name').innerText = MAID_PACKAGES[maidBookingState.packageKey].name;
  }
  if (document.getElementById('maid-calc-base-price')) {
    document.getElementById('maid-calc-base-price').innerText = `${maidBookingState.basePrice.toLocaleString()} ฿`;
  }
  if (document.getElementById('maid-calc-addon-price')) {
    let addonSum = 0;
    if (maidBookingState.addons.balcony) addonSum += 100;
    if (maidBookingState.addons.ozone) addonSum += 150;
    document.getElementById('maid-calc-addon-price').innerText = `+${addonSum.toLocaleString()} ฿`;
  }
  if (document.getElementById('maid-calc-discount-price')) {
    document.getElementById('maid-calc-discount-price').innerText = maidBookingState.discount > 0 ? `-${maidBookingState.discount} ฿` : `0 ฿`;
  }
  if (document.getElementById('maid-calc-total-price')) {
    document.getElementById('maid-calc-total-price').innerText = `${total.toLocaleString()} ฿`;
  }
}

function submitMaidBooking(e) {
  if (e) e.preventDefault();

  const dormSelect = document.getElementById('maid-dorm-select');
  const customDorm = document.getElementById('maid-custom-dorm');
  let dormName = dormSelect ? dormSelect.value : '';
  if (dormName === 'OTHER' || !dormName) {
    dormName = customDorm ? customDorm.value.trim() : '';
  }

  const roomNo = document.getElementById('maid-room-no')?.value.trim() || '';
  const dateVal = document.getElementById('maid-date-input')?.value || '';
  const timeSlot = document.querySelector('input[name="maid-timeslot"]:checked')?.value || '09:00 - 12:00 น.';
  const custName = document.getElementById('maid-cust-name')?.value.trim() || '';
  const custPhone = document.getElementById('maid-cust-phone')?.value.trim() || '';
  const custLine = document.getElementById('maid-cust-line')?.value.trim() || '';
  const notes = document.getElementById('maid-notes')?.value.trim() || '';

  if (!dormName) {
    alert('กรุณาเลือกหรือระบุชื่อหอพัก/สถานที่');
    return;
  }
  if (!custName || !custPhone) {
    alert('กรุณากรอกชื่อผู้จองและเบอร์โทรศัพท์ติดต่อ');
    return;
  }

  let total = maidBookingState.basePrice;
  if (maidBookingState.addons.balcony) total += 100;
  if (maidBookingState.addons.ozone) total += 150;
  total = Math.max(0, total - maidBookingState.discount);

  const bookingId = 'MD-' + Math.floor(100000 + Math.random() * 900000);
  const bookingObj = {
    id: bookingId,
    serviceType: 'MAID',
    serviceTitle: 'บริการแม่บ้านทำความสะอาด',
    packageName: MAID_PACKAGES[maidBookingState.packageKey].name,
    dormName: dormName + (roomNo ? ` (ห้อง ${roomNo})` : ''),
    date: dateVal,
    time: timeSlot,
    customerName: custName,
    phone: custPhone,
    lineId: custLine,
    notes: notes,
    addons: [
      maidBookingState.addons.balcony ? 'ขัดระเบียง/ล้างพัดลม (+100฿)' : null,
      maidBookingState.addons.ozone ? 'ฆ่าเชื้อโอโซนห้อง (+150฿)' : null
    ].filter(Boolean),
    totalPrice: total,
    status: 'รอแม่บ้านกดยืนยัน (ไม่เกิน 15 นาที)',
    statusColor: 'amber',
    createdAt: new Date().toISOString()
  };

  userBookings.unshift(bookingObj);
  saveBookingsState();

  closeMaidServiceModal();
  showBookingSuccessModal(bookingObj);
}


// --------------------------------------------------------------------
// OPEN / CLOSE MOVING SERVICE MODAL
// --------------------------------------------------------------------
function openMovingServiceModal(preselectedDestDorm = '') {
  const modal = document.getElementById('moving-service-modal');
  if (!modal) return;

  // Reset State
  movingBookingState.vehicleType = 'pickup_box';
  movingBookingState.basePrice = MOVING_VEHICLES.pickup_box.price;
  movingBookingState.helperLevel = 1;
  movingBookingState.helperFee = 150;
  movingBookingState.stairsAddon = false;

  const chkStairs = document.getElementById('moving-addon-stairs');
  if (chkStairs) chkStairs.checked = false;

  // Populate Destination Dorm Select
  const destSelect = document.getElementById('moving-dest-dorm-select');
  if (destSelect) {
    destSelect.innerHTML = `
      <option value="">-- เลือกหอพักปลายทางในระบบ --</option>
      ${dormsData.map(d => `<option value="${d.name}">${d.name} (${d.uniName})</option>`).join('')}
      <option value="OTHER">-- ปลายทางอื่นๆ (ระบุเอง) --</option>
    `;

    if (preselectedDestDorm) {
      const match = dormsData.find(d => d.name === preselectedDestDorm || d.name.includes(preselectedDestDorm));
      if (match) {
        destSelect.value = match.name;
      } else {
        destSelect.value = 'OTHER';
        const customDest = document.getElementById('moving-custom-dest');
        if (customDest) customDest.value = preselectedDestDorm;
      }
    }
  }

  // Set default date
  const dateInput = document.getElementById('moving-date-input');
  if (dateInput) {
    const today = new Date();
    dateInput.value = today.toISOString().split('T')[0];
    dateInput.min = today.toISOString().split('T')[0];
  }

  updateMovingVehicleCardsUI();
  updateMovingHelperUI();
  calculateMovingTotal();

  modal.classList.remove('hidden');
}

function closeMovingServiceModal() {
  const modal = document.getElementById('moving-service-modal');
  if (modal) modal.classList.add('hidden');
}

function selectMovingVehicle(vKey) {
  if (!MOVING_VEHICLES[vKey]) return;
  movingBookingState.vehicleType = vKey;
  movingBookingState.basePrice = MOVING_VEHICLES[vKey].price;
  updateMovingVehicleCardsUI();
  calculateMovingTotal();
}

function updateMovingVehicleCardsUI() {
  document.querySelectorAll('.moving-v-card').forEach(card => {
    const key = card.getAttribute('data-vehicle');
    if (key === movingBookingState.vehicleType) {
      card.classList.add('border-amber-500', 'bg-amber-50/80', 'ring-2', 'ring-amber-400');
      card.classList.remove('border-slate-200', 'bg-white');
    } else {
      card.classList.remove('border-amber-500', 'bg-amber-50/80', 'ring-2', 'ring-amber-400');
      card.classList.add('border-slate-200', 'bg-white');
    }
  });
}

function selectMovingHelper(level) {
  movingBookingState.helperLevel = level;
  if (level === 0) movingBookingState.helperFee = 0;
  else if (level === 1) movingBookingState.helperFee = 150;
  else if (level === 2) movingBookingState.helperFee = 300;

  updateMovingHelperUI();
  calculateMovingTotal();
}

function updateMovingHelperUI() {
  document.querySelectorAll('.moving-helper-pill').forEach(pill => {
    const lvl = parseInt(pill.getAttribute('data-level'));
    if (lvl === movingBookingState.helperLevel) {
      pill.classList.add('bg-amber-600', 'text-white', 'border-amber-600', 'shadow-xs');
      pill.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
    } else {
      pill.classList.remove('bg-amber-600', 'text-white', 'border-amber-600', 'shadow-xs');
      pill.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
    }
  });
}

function toggleMovingStairs() {
  const chk = document.getElementById('moving-addon-stairs');
  movingBookingState.stairsAddon = chk ? chk.checked : false;
  calculateMovingTotal();
}

function calculateMovingTotal() {
  let total = movingBookingState.basePrice + movingBookingState.helperFee;
  if (movingBookingState.stairsAddon) total += movingBookingState.stairsFee;

  if (document.getElementById('moving-calc-vehicle-name')) {
    document.getElementById('moving-calc-vehicle-name').innerText = MOVING_VEHICLES[movingBookingState.vehicleType].name;
  }
  if (document.getElementById('moving-calc-base-price')) {
    document.getElementById('moving-calc-base-price').innerText = `${movingBookingState.basePrice.toLocaleString()} ฿`;
  }
  if (document.getElementById('moving-calc-helper-price')) {
    document.getElementById('moving-calc-helper-price').innerText = `+${movingBookingState.helperFee.toLocaleString()} ฿`;
  }
  if (document.getElementById('moving-calc-stairs-price')) {
    document.getElementById('moving-calc-stairs-price').innerText = movingBookingState.stairsAddon ? `+${movingBookingState.stairsFee} ฿` : `0 ฿`;
  }
  if (document.getElementById('moving-calc-total-price')) {
    document.getElementById('moving-calc-total-price').innerText = `${total.toLocaleString()} ฿`;
  }
}

function submitMovingBooking(e) {
  if (e) e.preventDefault();

  const origin = document.getElementById('moving-origin-input')?.value.trim() || '';
  const destSelect = document.getElementById('moving-dest-dorm-select');
  const customDest = document.getElementById('moving-custom-dest');
  let dest = destSelect ? destSelect.value : '';
  if (dest === 'OTHER' || !dest) {
    dest = customDest ? customDest.value.trim() : '';
  }

  const dateVal = document.getElementById('moving-date-input')?.value || '';
  const timeVal = document.getElementById('moving-time-input')?.value || '10:00 น.';
  const custName = document.getElementById('moving-cust-name')?.value.trim() || '';
  const custPhone = document.getElementById('moving-cust-phone')?.value.trim() || '';
  const notes = document.getElementById('moving-items-detail')?.value.trim() || '';

  if (!origin) {
    alert('กรุณากรอกสถานที่ต้นทาง/จุดรับของ');
    return;
  }
  if (!dest) {
    alert('กรุณาเลือกหรือกรอกสถานที่ปลายทาง/จุดส่งของ');
    return;
  }
  if (!custName || !custPhone) {
    alert('กรุณากรอกชื่อผู้จองและเบอร์โทรศัพท์ติดต่อ');
    return;
  }

  // Selected item tags
  const selectedItems = [];
  document.querySelectorAll('input[name="moving-items"]:checked').forEach(c => selectedItems.push(c.value));

  let total = movingBookingState.basePrice + movingBookingState.helperFee;
  if (movingBookingState.stairsAddon) total += movingBookingState.stairsFee;

  const helperText = movingBookingState.helperLevel === 0 ? 'ไม่ใช้คนช่วยยก' : `คนช่วยยก ${movingBookingState.helperLevel} คน`;

  const bookingId = 'MV-' + Math.floor(100000 + Math.random() * 900000);
  const bookingObj = {
    id: bookingId,
    serviceType: 'MOVING',
    serviceTitle: 'บริการรถรับจ้างขนย้ายของ',
    packageName: MOVING_VEHICLES[movingBookingState.vehicleType].name,
    origin: origin,
    destination: dest,
    date: dateVal,
    time: timeVal,
    customerName: custName,
    phone: custPhone,
    helperText: helperText,
    items: selectedItems,
    notes: notes,
    totalPrice: total,
    status: 'รอคนขับรับงาน (ไม่เกิน 10 นาที)',
    statusColor: 'amber',
    createdAt: new Date().toISOString()
  };

  userBookings.unshift(bookingObj);
  saveBookingsState();

  closeMovingServiceModal();
  showBookingSuccessModal(bookingObj);
}


// --------------------------------------------------------------------
// BOOKING CONFIRMATION MODAL & MY BOOKINGS TRACKER
// --------------------------------------------------------------------
function showBookingSuccessModal(booking) {
  const modal = document.getElementById('service-success-modal');
  if (!modal) {
    alert(`🎉 การจองสำเร็จ!\nรหัสการจอง: ${booking.id}\nบริการ: ${booking.serviceTitle}\nยอดชำระ: ${booking.totalPrice.toLocaleString()} บาท`);
    return;
  }

  if (document.getElementById('success-booking-id')) document.getElementById('success-booking-id').innerText = booking.id;
  if (document.getElementById('success-service-title')) document.getElementById('success-service-title').innerText = booking.serviceTitle;
  if (document.getElementById('success-package-name')) document.getElementById('success-package-name').innerText = booking.packageName;
  if (document.getElementById('success-cust-info')) document.getElementById('success-cust-info').innerText = `${booking.customerName} (${booking.phone})`;
  if (document.getElementById('success-datetime')) document.getElementById('success-datetime').innerText = `📅 ${booking.date} เวลา ${booking.time}`;
  if (document.getElementById('success-total-price')) document.getElementById('success-total-price').innerText = `${booking.totalPrice.toLocaleString()} บาท`;

  const locEl = document.getElementById('success-location-info');
  if (locEl) {
    if (booking.serviceType === 'MAID') {
      locEl.innerHTML = `📍 สถานที่รับบริการ: <strong>${booking.dormName}</strong>`;
    } else {
      locEl.innerHTML = `📍 เส้นทาง: <strong>${booking.origin}</strong> ➔ <strong>${booking.destination}</strong> (${booking.helperText})`;
    }
  }

  modal.classList.remove('hidden');
}

function closeSuccessModal() {
  const modal = document.getElementById('service-success-modal');
  if (modal) modal.classList.add('hidden');
}

function openMyBookingsModal() {
  if (!isUserLoggedIn()) {
    window.location.href = 'login.php';
    return;
  }

  const isHomePage = window.location.pathname.endsWith('/index.php') || window.location.pathname.endsWith('/index.html') || window.location.pathname.endsWith('/') || window.location.pathname === '';
  if (!isHomePage) {
    window.location.href = 'index.php';
    return;
  }

  const modal = document.getElementById('my-bookings-modal');
  if (!modal) return;

  const container = document.getElementById('my-bookings-list-container');
  if (container) {
    if (userBookings.length === 0) {
      container.innerHTML = `
        <div class="text-center py-10 text-slate-400">
          <i class="fa-solid fa-receipt text-4xl mb-2 text-slate-300"></i>
          <p class="text-sm font-semibold text-slate-600">ยังไม่มีประวัติการจองบริการ</p>
          <p class="text-xs text-slate-400 mt-1">ท่านสามารถจองแม่บ้านหรือรถขนของได้จากแถบเมนูด้านบน</p>
        </div>
      `;
    } else {
      container.innerHTML = userBookings.map((b, idx) => `
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs space-y-3">
          <div class="flex items-center justify-between border-b pb-2.5 border-slate-100">
            <div class="flex items-center gap-2">
              <span class="w-8 h-8 rounded-lg ${b.serviceType === 'MAID' ? 'bg-pink-100 text-pink-700' : 'bg-amber-100 text-amber-800'} flex items-center justify-center text-sm font-bold">
                <i class="fa-solid ${b.serviceType === 'MAID' ? 'fa-broom' : 'fa-truck-moving'}"></i>
              </span>
              <div>
                <span class="font-bold text-slate-900 text-sm block">${b.serviceTitle}</span>
                <span class="text-[11px] text-slate-500">รหัส: <strong>${b.id}</strong></span>
              </div>
            </div>
            <div class="text-right">
              <span class="inline-flex items-center gap-1 bg-amber-100 text-amber-800 text-[10px] font-bold px-2.5 py-1 rounded-full">
                <i class="fa-solid fa-clock-rotate-left animate-spin"></i> ${b.status}
              </span>
            </div>
          </div>

          <div class="text-xs space-y-1 text-slate-600 bg-slate-50 p-3 rounded-xl">
            <p><strong>แพ็กเกจ/รถ:</strong> ${b.packageName}</p>
            ${b.serviceType === 'MAID'
          ? `<p><strong>สถานที่:</strong> ${b.dormName}</p>`
          : `<p><strong>เส้นทาง:</strong> ${b.origin} ➔ ${b.destination}</p>`
        }
            <p><strong>เวลานัดหมาย:</strong> ${b.date} (${b.time})</p>
            <p><strong>ผู้จอง:</strong> ${b.customerName} (โทร. ${b.phone})</p>
          </div>

          <div class="flex items-center justify-between pt-1 text-xs">
            <div>
              <span class="text-slate-500">ยอดรวม:</span>
              <span class="font-bold text-base ${b.serviceType === 'MAID' ? 'text-pink-600' : 'text-amber-600'} ml-1">${b.totalPrice.toLocaleString()} ฿</span>
            </div>
            <button onclick="cancelBooking('${b.id}')" class="text-rose-500 hover:text-rose-700 font-semibold text-xs px-3 py-1 bg-rose-50 rounded-lg cursor-pointer transition-colors">
              <i class="fa-solid fa-trash-can mr-1"></i> ยกเลิกการจอง
            </button>
          </div>
        </div>
      `).join('');
    }
  }

  modal.classList.remove('hidden');
}

function closeMyBookingsModal() {
  const modal = document.getElementById('my-bookings-modal');
  if (modal) modal.classList.add('hidden');
}

function cancelBooking(id) {
  if (confirm(`ยืนยันการยกเลิกรายการจองรหัส ${id} ใช่หรือไม่?`)) {
    userBookings = userBookings.filter(b => b.id !== id);
    saveBookingsState();
    openMyBookingsModal();
  }
}

// --------------------------------------------------------------------
// LOGIN MODAL
// --------------------------------------------------------------------
function openLoginModal() {
  const modal = document.getElementById('login-modal');
  if (modal) modal.classList.remove('hidden');
}

function closeLoginModal() {
  const modal = document.getElementById('login-modal');
  if (modal) modal.classList.add('hidden');
}

function getCookie(name) {
  const value = `; ${document.cookie}`;
  const parts = value.split(`; ${name}=`);
  if (parts.length === 2) {
    const cookieValue = parts.pop().split(';').shift();
    return decodeURIComponent(cookieValue || '');
  }
  return '';
}

function isUserLoggedIn() {
  const localLoggedIn = localStorage.getItem('jingjai_logged_in') === 'true';
  const cookieLoggedIn = getCookie('jingjai_logged_in') === 'true';
  return localLoggedIn || cookieLoggedIn;
}

function syncBookingButtonVisibility() {
  const showBookingButton = isUserLoggedIn();

  document.querySelectorAll('button[onclick*="openMyBookingsModal"]').forEach(btn => {
    btn.style.display = showBookingButton ? '' : 'none';
  });

  document.querySelectorAll('a[onclick*="openMyBookingsModal"]').forEach(btn => {
    btn.style.display = showBookingButton ? '' : 'none';
  });

  document.querySelectorAll('.my-bookings-count').forEach(el => {
    el.style.display = showBookingButton ? 'inline-flex' : 'none';
  });
}

function updateLoginButtonState() {
  const triggerBtn = document.getElementById('login-trigger-btn');
  const label = document.getElementById('login-button-label');
  if (!triggerBtn || !label) return;

  const localLoggedIn = localStorage.getItem('jingjai_logged_in') === 'true';
  const cookieLoggedIn = getCookie('jingjai_logged_in') === 'true';
  const isLoggedIn = localLoggedIn || cookieLoggedIn;
  const username = localStorage.getItem('jingjai_user_name') || getCookie('jingjai_user_name') || '';

  if (isLoggedIn && username) {
    const shortName = username.split(' ')[0];
    label.textContent = `สวัสดี ${shortName}`;
    triggerBtn.setAttribute('title', 'ออกจากระบบ');
    triggerBtn.setAttribute('onclick', "window.location.href='logout.php'");
    triggerBtn.classList.remove(
      'bg-white',
      'border-slate-200',
      'text-slate-700',
      'hover:border-brand-300',
      'hover:bg-brand-50',
      'shadow-sm',
      'ring-0'
    );
    triggerBtn.classList.add(
      'bg-gradient-to-r',
      'from-emerald-500',
      'to-emerald-600',
      'border',
      'border-emerald-300',
      'text-white',
      'shadow-lg',
      'shadow-emerald-500/20',
      'ring-2',
      'ring-emerald-100',
      'hover:shadow-xl',
      'hover:shadow-emerald-500/25'
    );
    const icon = triggerBtn.querySelector('i');
    if (icon) {
      icon.className = 'fa-solid fa-user-check text-white';
    }
    syncBookingButtonVisibility();
  } else {
    label.textContent = 'เข้าสู่ระบบ';
    triggerBtn.setAttribute('title', 'เข้าสู่ระบบ');
    triggerBtn.setAttribute('onclick', "window.location.href='login.php'");
    triggerBtn.classList.remove(
      'bg-gradient-to-r',
      'from-emerald-500',
      'to-emerald-600',
      'border-emerald-300',
      'text-white',
      'shadow-lg',
      'shadow-emerald-500/20',
      'ring-2',
      'ring-emerald-100',
      'hover:shadow-xl',
      'hover:shadow-emerald-500/25'
    );
    triggerBtn.classList.add(
      'bg-white',
      'border',
      'border-slate-200',
      'text-slate-700',
      'shadow-sm',
      'hover:border-brand-300',
      'hover:bg-brand-50',
      'ring-0'
    );
    const icon = triggerBtn.querySelector('i');
    if (icon) {
      icon.className = 'fa-solid fa-right-to-bracket text-brand-600';
    }
    syncBookingButtonVisibility();
  }
}

function handleLoginSubmit(event) {
  event.preventDefault();

  const email = document.getElementById('login-email')?.value.trim();
  const password = document.getElementById('login-password')?.value.trim();
  const message = document.getElementById('login-message');

  if (!email || !password) {
    if (message) {
      message.className = 'text-xs font-semibold rounded-lg px-3 py-2 text-rose-600 bg-rose-50 border border-rose-200 block';
      message.textContent = 'กรุณากรอกอีเมลและรหัสผ่านให้ครบถ้วน';
    }
    return;
  }

  const rawName = email.includes('@') ? email.split('@')[0] : email;
  const displayName = rawName
    .replace(/[._-]/g, ' ')
    .replace(/\s+/g, ' ')
    .trim();

  const formattedName = displayName
    ? displayName.charAt(0).toUpperCase() + displayName.slice(1)
    : 'ผู้ใช้';

  localStorage.setItem('jingjai_logged_in', 'true');
  localStorage.setItem('jingjai_user_name', formattedName);
  document.cookie = `jingjai_logged_in=true; path=/; max-age=${60 * 60 * 24 * 30}`;
  document.cookie = `jingjai_user_name=${encodeURIComponent(formattedName)}; path=/; max-age=${60 * 60 * 24 * 30}`;

  if (message) {
    message.className = 'text-xs font-semibold rounded-lg px-3 py-2 text-emerald-600 bg-emerald-50 border border-emerald-200 block';
    message.textContent = 'เข้าสู่ระบบสำเร็จ!';
  }

  updateLoginButtonState();
  setTimeout(() => closeLoginModal(), 600);
}
