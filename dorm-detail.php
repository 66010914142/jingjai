<!DOCTYPE html>
<html lang="th" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>รายละเอียดหอพัก | JingJai</title>
  <meta name="description"
    content="หน้ารายละเอียดหอพัก วิเคราะห์คะแนน 6 มิติ สรุปรีวิวโดย AI รูปถ่ายจริงจากผู้พัก และแผนที่ Google Maps">

  <!-- Google Fonts: Prompt & Kanit & Outfit -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Outfit:wght@400;600;700&family=Prompt:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- FontAwesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      darkMode: 'class',
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#f0f7ff',
              100: '#e0effe',
              500: '#2563eb',
              600: '#1d4ed8',
              700: '#1e40af',
            },
            accent: {
              purple: '#7c3aed',
              emerald: '#10b981',
              amber: '#f59e0b',
              rose: '#f43f5e'
            }
          },
          fontFamily: {
            sans: ['Prompt', 'Kanit', 'sans-serif'],
            display: ['Outfit', 'Prompt', 'sans-serif']
          }
        }
      }
    }
  </script>

  <style type="text/tailwindcss">
    @layer utilities {
      .glass-card {
        @apply bg-white/90 backdrop-blur-md border border-slate-200/80 shadow-sm rounded-2xl;
      }
    }
  </style>
</head>

<body
  class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col antialiased selection:bg-brand-500 selection:text-white">

  <!-- ==================== HEADER NAVBAR ==================== -->
  <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-2xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <a href="index.php" class="flex items-center gap-3 cursor-pointer">
          <div
            class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 via-accent-purple to-pink-500 flex items-center justify-center text-white font-bold text-xl shadow-glow-blue">
            <i class="fa-solid fa-building-user"></i>
          </div>
          <div>
            <span
              class="text-xl font-bold bg-gradient-to-r from-brand-600 to-accent-purple bg-clip-text text-transparent">JingJai</span>
            <span class="text-[10px] block font-semibold text-slate-500 -mt-1">ค้นหาหอพักนิสิต & AI สรุปรีวิว</span>
          </div>
        </a>

        <!-- Main Navigation Links (Clean & Focused) -->
        <nav class="hidden md:flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
          <a href="index.php"
            class="px-3.5 py-1.5 rounded-lg text-sm font-medium transition-all text-slate-600 hover:text-brand-600">
            <i class="fa-solid fa-list-ul mr-1.5"></i> รายการหอพัก
          </a>
          <!-- Maid Service Button -->
          <button onclick="openMaidServiceModal(currentDetailDorm ? currentDetailDorm.name : '')"
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all text-pink-700 hover:bg-pink-100 hover:text-pink-800 flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-broom text-pink-500"></i> จองแม่บ้าน
          </button>
          <!-- Moving Service Button -->
          <button onclick="openMovingServiceModal(currentDetailDorm ? currentDetailDorm.name : '')"
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all text-amber-700 hover:bg-amber-100 hover:text-amber-800 flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-truck-moving text-amber-500"></i> จองรถขนของ
          </button>
        </nav>

        <!-- Right Action: My Bookings & Back -->
        <div class="flex items-center gap-2">
          <button onclick="openMyBookingsModal()"
            class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center gap-2 cursor-pointer relative"
            title="ประวัติและรายการจองของฉัน">
            <i class="fa-solid fa-receipt text-amber-400"></i>
            <span>รายการจอง</span>
            <span
              class="my-bookings-count hidden bg-rose-500 text-white font-extrabold text-[10px] px-1.5 py-0.2 rounded-full absolute -top-1.5 -right-1.5 shadow-xs">0</span>
          </button>
          <a href="index.php"
            class="bg-brand-600 hover:bg-brand-700 text-white font-semibold px-3.5 py-2 rounded-xl text-xs transition-colors flex items-center gap-1.5 shadow-sm">
            <i class="fa-solid fa-arrow-left"></i> กลับหน้าหลัก
          </a>
        </div>
      </div>
    </div>
  </header>


  <!-- ==================== DORM DETAIL CONTAINER ==================== -->
  <main id="detail-page-container" class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Back button & Compare checkbox -->
    <div
      class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs">
      <a href="index.php" class="text-xs font-semibold text-brand-600 hover:underline flex items-center gap-1.5">
        <i class="fa-solid fa-chevron-left"></i> กลับไปค้นหาหอพัก
      </a>

      <label
        class="flex items-center gap-2 text-xs font-semibold text-slate-700 bg-purple-50 p-2 px-3 rounded-xl border border-purple-200 cursor-pointer select-none">
        <input type="checkbox" id="detail-compare-chk" class="rounded text-purple-600 focus:ring-purple-500 w-4 h-4">
        <span>เพิ่มหอนี้เข้าสู่รายการเปรียบเทียบ (Compare)</span>
      </label>
    </div>

    <!-- Header Banner -->
    <div class="bg-slate-900 text-white p-6 sm:p-8 rounded-3xl shadow-xl relative overflow-hidden space-y-3">
      <div class="flex flex-wrap items-center gap-2">
        <span id="detail-uni-name"
          class="bg-brand-600 text-white text-xs font-bold px-3 py-1 rounded-lg">มหาวิทยาลัย</span>
        <span class="bg-emerald-600 text-white text-xs font-bold px-3 py-1 rounded-lg">📍 Google Maps Enabled</span>
      </div>
      <h1 id="detail-dorm-name" class="text-2xl sm:text-3xl font-extrabold text-white">ชื่อหอพัก</h1>
      <p id="detail-address" class="text-xs sm:text-sm text-slate-300 flex items-center gap-1.5">
        <i class="fa-solid fa-location-dot text-rose-400"></i> ที่อยู่หอพัก...
      </p>
    </div>

    <!-- Key Metrics Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
      <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs text-center">
        <span class="text-xs font-semibold text-slate-500 block">ค่าเช่ารายเดือน</span>
        <span id="detail-price" class="text-2xl font-extrabold text-brand-600">0</span> <span
          class="text-xs text-slate-500">บาท</span>
      </div>
      <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs text-center flex flex-col justify-between">
        <div>
          <span class="text-xs font-semibold text-slate-500 block">ค่าน้ำ / ค่าไฟ</span>
          <span class="text-base font-extrabold text-slate-800"><span id="detail-water-rate">0</span>฿ / <span
              id="detail-electric-rate">0</span>฿</span>
        </div>
        <a id="detail-calc-link" href="calculator.php" class="text-[11px] text-emerald-600 hover:text-emerald-800 font-bold inline-flex items-center justify-center gap-1 hover:underline mt-1">
          <i class="fa-solid fa-calculator text-[10px]"></i> คำนวณค่าน้ำไฟ
        </a>
      </div>
      <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs text-center">
        <span class="text-xs font-semibold text-slate-500 block">ระยะทางเดินถึง ม.</span>
        <span id="detail-walk" class="text-base font-extrabold text-emerald-600">🚶 0 นาที</span>
      </div>
      <div class="bg-amber-50 p-4 rounded-2xl border border-amber-200 shadow-2xs text-center">
        <span class="text-xs font-semibold text-slate-600 block">คะแนนรีวิวนิสิต</span>
        <span id="detail-rating" class="text-2xl font-extrabold text-amber-600">⭐ 0 / 5</span>
      </div>
    </div>


    <!-- ==================== DORM SPECIAL SERVICES BANNER (MAID & MOVING) ==================== -->
    <div
      class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-5 sm:p-6 rounded-3xl shadow-xl border border-slate-800 space-y-4">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-white/10 pb-3">
        <div>
          <h2 class="text-base sm:text-lg font-bold text-white flex items-center gap-2">
            <span class="w-7 h-7 rounded-lg bg-brand-500 flex items-center justify-center text-xs text-white shadow-xs">
              <i class="fa-solid fa-sparkles"></i>
            </span>
            บริการเสริมพิเศษสำหรับหอพักนี้ (On-Demand Services)
          </h2>
          <p class="text-xs text-slate-300">กดจองบริการได้ทันที ระบบจะใส่ชื่อหอพักนี้ให้อัตโนมัติ</p>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Maid Box -->
        <div
          class="bg-white/10 backdrop-blur-md p-4 sm:p-5 rounded-2xl border border-pink-500/30 hover:border-pink-400 transition-all flex flex-col justify-between space-y-3 group">
          <div class="flex items-start gap-3.5">
            <div
              class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-pink-600 to-rose-400 text-white flex items-center justify-center text-xl shadow-md group-hover:scale-105 transition-transform">
              <i class="fa-solid fa-broom"></i>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <h3 class="font-bold text-white text-sm sm:text-base">จองแม่บ้านทำความสะอาด</h3>
                <span
                  class="bg-pink-500/30 text-pink-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-pink-400/30">เริ่มต้น
                  350฿</span>
              </div>
              <p class="text-xs text-slate-300 mt-1">คลีนห้องก่อนเข้าพัก / ล้างแอร์หอพัก / คลีนคืนห้องย้ายออก</p>
            </div>
          </div>
          <button onclick="openMaidServiceModal(currentDetailDorm ? currentDetailDorm.name : '')"
            class="w-full bg-pink-600 hover:bg-pink-700 text-white text-xs font-bold py-2.5 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 cursor-pointer">
            <i class="fa-solid fa-broom"></i> จองแม่บ้านทำความสะอาดหอนี้
          </button>
        </div>

        <!-- Moving Box -->
        <div
          class="bg-white/10 backdrop-blur-md p-4 sm:p-5 rounded-2xl border border-amber-500/30 hover:border-amber-400 transition-all flex flex-col justify-between space-y-3 group">
          <div class="flex items-start gap-3.5">
            <div
              class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-600 to-orange-400 text-white flex items-center justify-center text-xl shadow-md group-hover:scale-105 transition-transform">
              <i class="fa-solid fa-truck-moving"></i>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <h3 class="font-bold text-white text-sm sm:text-base">จองรถรับจ้างขนย้ายของ</h3>
                <span
                  class="bg-amber-500/30 text-amber-300 text-[10px] font-bold px-2 py-0.5 rounded-full border border-amber-400/30">เริ่มต้น
                  200฿</span>
              </div>
              <p class="text-xs text-slate-300 mt-1">รถกระบะตู้ทึบ / พ่วงข้าง พร้อมคนช่วยยก ขนเข้าหอนี้</p>
            </div>
          </div>
          <button onclick="openMovingServiceModal(currentDetailDorm ? currentDetailDorm.name : '')"
            class="w-full bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold py-2.5 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2 cursor-pointer">
            <i class="fa-solid fa-truck-moving"></i> จองรถขนของย้ายมาหอนี้
          </button>
        </div>
      </div>
    </div>


    <!-- GOOGLE MAPS EMBED SECTION -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <h2 class="text-lg font-bold text-slate-900 flex items-center gap-2">
            <i class="fa-solid fa-map-location-dot text-emerald-600"></i> แผนที่ Google Maps ตำแหน่งจริงของหอพัก
          </h2>
          <p class="text-xs text-slate-500">ซูมเข้า-ออก หรือเลื่อนดูแผนที่เพื่อสำรวจซอยและบริเวณรอบๆ</p>
        </div>
        <a id="google-map-btn" href="#" target="_blank" rel="noopener noreferrer"
          class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-4 py-2.5 rounded-xl shadow-sm transition-all flex items-center justify-center gap-2">
          <i class="fa-solid fa-route"></i> เปิดใน Google Maps (ดูเส้นทางนำทาง)
        </a>
      </div>

      <!-- Embed Iframe -->
      <div class="w-full h-80 rounded-2xl overflow-hidden border border-slate-200 bg-slate-100 shadow-inner">
        <iframe id="google-map-iframe" class="w-full h-full" src="" frameborder="0" allowfullscreen=""
          loading="lazy"></iframe>
      </div>
    </div>


    <!-- AI REVIEW SUMMARY BOX -->
    <div
      class="bg-gradient-to-br from-indigo-950 via-slate-900 to-purple-950 text-white p-6 rounded-3xl shadow-xl space-y-4">
      <div class="flex items-center gap-3 border-b border-white/10 pb-3">
        <div class="w-10 h-10 rounded-xl bg-purple-600 flex items-center justify-center text-lg shadow-glow-purple">
          <i class="fa-solid fa-robot"></i>
        </div>
        <div>
          <h3 class="font-bold text-base sm:text-lg flex items-center gap-2">
            <span>AI สรุปรีวิวนิสิตอัตโนมัติ (NLP Summary)</span>
          </h3>
          <p class="text-xs text-slate-300">รวบรวมและวิเคราะห์จุดเด่น-ข้อควรทราบจากรีวิวผู้เคยพักจริง</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <!-- Pros -->
        <div class="bg-white/5 backdrop-blur-md p-4 rounded-2xl border border-emerald-500/30">
          <h4 class="font-bold text-emerald-400 mb-3 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-circle-check"></i> ข้อดีสรุปโดย AI
          </h4>
          <ul id="detail-ai-pros" class="space-y-2">
            <!-- Rendered by JS -->
          </ul>
        </div>

        <!-- Considerations -->
        <div class="bg-white/5 backdrop-blur-md p-4 rounded-2xl border border-amber-500/30">
          <h4 class="font-bold text-amber-400 mb-3 flex items-center gap-2 text-sm">
            <i class="fa-solid fa-triangle-exclamation"></i> ข้อควรทราบสรุปโดย AI
          </h4>
          <ul id="detail-ai-cons" class="space-y-2">
            <!-- Rendered by JS -->
          </ul>
        </div>
      </div>
    </div>


    <!-- 6 DIMENSIONS RATINGS BREAKDOWN -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
      <h3 class="font-bold text-slate-900 text-base">⭐ คะแนนประเมิน 6 มิติจากนิสิตจริง</h3>
      <div id="ratings-bars-grid" class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-4">
        <!-- Rendered by JS -->
      </div>
    </div>


    <!-- SPECIALIZED BREAKDOWNS (Wi-Fi, Quietness, Water) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
        <div class="flex items-center justify-between border-b pb-2 border-slate-100">
          <span class="font-bold text-xs text-slate-800 flex items-center gap-1.5">
            <i class="fa-solid fa-wifi text-brand-600"></i> Wi-Fi & Internet
          </span>
          <span id="detail-score-net" class="font-extrabold text-xs text-brand-600">4.7 / 5</span>
        </div>
        <p id="detail-ai-net"
          class="text-xs bg-brand-50 text-brand-800 p-2.5 rounded-xl border border-brand-100 leading-relaxed italic">
          AI: สรุปเน็ต...
        </p>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
        <div class="flex items-center justify-between border-b pb-2 border-slate-100">
          <span class="font-bold text-xs text-slate-800 flex items-center gap-1.5">
            <i class="fa-solid fa-volume-xmark text-indigo-600"></i> ความเงียบสงบ
          </span>
          <span id="detail-score-quiet" class="font-extrabold text-xs text-indigo-600">4.8 / 5</span>
        </div>
        <p id="detail-ai-quiet"
          class="text-xs bg-indigo-50 text-indigo-800 p-2.5 rounded-xl border border-indigo-100 leading-relaxed italic">
          AI: สรุปความเงียบ...
        </p>
      </div>

      <div class="bg-white p-5 rounded-2xl border border-slate-200 shadow-sm space-y-2">
        <div class="flex items-center justify-between border-b pb-2 border-slate-100">
          <span class="font-bold text-xs text-slate-800 flex items-center gap-1.5">
            <i class="fa-solid fa-faucet-drip text-cyan-600"></i> น้ำประปา
          </span>
          <span id="detail-score-water" class="font-extrabold text-xs text-cyan-600">3.2 / 5</span>
        </div>
        <p id="detail-ai-water"
          class="text-xs bg-cyan-50 text-cyan-800 p-2.5 rounded-xl border border-cyan-100 leading-relaxed italic">
          AI: สรุปน้ำประปา...
        </p>
      </div>
    </div>


    <!-- PHOTO GALLERY -->
    <div class="bg-gradient-to-br from-white via-slate-50 to-indigo-50 p-6 rounded-3xl border border-slate-200 shadow-lg shadow-slate-200/50 space-y-5">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <div>
          <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-brand-600 mb-2">Gallery</p>
          <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
            <i class="fa-solid fa-camera text-brand-600"></i> รูปถ่ายหอพักแบบเต็มภาพ
          </h3>
        </div>

        <div class="flex items-center bg-slate-100 p-1 rounded-xl text-xs font-semibold shadow-inner">
          <button id="photo-tab-student" onclick="switchDetailPhotoTab('STUDENT')"
            class="px-4 py-2 rounded-xl transition-all bg-white text-brand-600 shadow-xs cursor-pointer">
            📷 รูปถ่ายจริงโดยนิสิต
          </button>
          <button id="photo-tab-landlord" onclick="switchDetailPhotoTab('LANDLORD')"
            class="px-4 py-2 rounded-xl transition-all text-slate-600 hover:text-brand-600 cursor-pointer">
            🏢 รูปทางการจากเจ้าของหอ
          </button>
        </div>
      </div>

      <div id="photos-gallery-grid" class="grid grid-cols-2 sm:grid-cols-3 gap-4">
        <!-- Photos -->
      </div>
    </div>


    <!-- STUDENT Q&A -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
      <div class="flex items-center justify-between">
        <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
          <i class="fa-solid fa-comments text-brand-600"></i> ถาม-ตอบกับผู้เคยพักจริง (Student Q&A)
        </h3>
        <button onclick="toggleAddQaForm()"
          class="text-xs bg-brand-50 hover:bg-brand-100 text-brand-700 font-semibold px-3.5 py-2 rounded-xl transition-colors">
          + ถามคำถามใหม่
        </button>
      </div>

      <div id="qa-form" class="hidden bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-3">
        <input type="text" id="qa-name-input" placeholder="ชื่อ/ฉายาของคุณ"
          class="w-full text-xs p-3 rounded-xl border border-slate-300">
        <textarea id="qa-text-input" rows="2" placeholder="พิมพ์คำถามเกี่ยวกับหอนี้..."
          class="w-full text-xs p-3 rounded-xl border border-slate-300"></textarea>
        <div class="flex justify-end gap-2">
          <button onclick="toggleAddQaForm()" class="text-xs px-4 py-2 rounded-xl text-slate-600">ยกเลิก</button>
          <button onclick="submitNewQuestion()"
            class="text-xs bg-brand-600 text-white font-semibold px-5 py-2 rounded-xl">ส่งคำถาม</button>
        </div>
      </div>

      <div id="qa-list-container" class="space-y-3">
        <!-- QA -->
      </div>
    </div>

  </main>

  <!-- FOOTER -->
  <footer class="bg-slate-900 text-slate-400 text-xs py-8 border-t border-slate-800 mt-12">
    <div class="max-w-7xl mx-auto px-4 text-center space-y-2">
      <p class="font-semibold text-slate-300">JingJai - ระบบค้นหาและวิเคราะห์รีวิวหอพักนิสิตมหาวิทยาลัยด้วย AI</p>
      <p class="text-slate-500">ออกแบบด้วย Tailwind CSS & Google Maps Integration Ready</p>
    </div>
  </footer>

  <!-- ==================== MAID SERVICE BOOKING MODAL ==================== -->
  <div id="maid-service-modal"
    class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div
      class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] flex flex-col shadow-2xl border border-pink-200 overflow-hidden my-auto animate-in fade-in zoom-in duration-200">

      <!-- Modal Header -->
      <div
        class="p-5 sm:p-6 bg-gradient-to-r from-pink-600 via-rose-500 to-pink-500 text-white flex items-center justify-between relative shadow-md">
        <div class="flex items-center gap-3">
          <div
            class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl border border-white/30 shadow-inner">
            <i class="fa-solid fa-broom"></i>
          </div>
          <div>
            <div class="flex items-center gap-2">
              <h2 class="text-lg sm:text-xl font-bold">จองบริการแม่บ้านทำความสะอาดหอพัก</h2>
              <span class="bg-white/20 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">เริ่มต้น 350฿</span>
            </div>
            <p class="text-xs text-pink-100 mt-0.5">คลีนห้องพักรายครั้ง / บิ๊กคลีนนิ่งก่อนเข้าพัก-ย้ายออก /
              ล้างแอร์หอพัก</p>
          </div>
        </div>
        <button onclick="closeMaidServiceModal()"
          class="text-white/80 hover:text-white text-2xl p-2 rounded-xl hover:bg-white/10 transition-colors cursor-pointer">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <!-- Modal Body (Form) -->
      <form onsubmit="submitMaidBooking(event)"
        class="p-5 sm:p-6 overflow-y-auto space-y-5 flex-1 bg-slate-50 text-xs sm:text-sm">

        <!-- Step 1: Package Selection -->
        <div class="space-y-2">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-pink-600 text-white flex items-center justify-center text-[10px]">1</span>
            เลือกแพ็กเกจบริการทำความสะอาด:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            <div onclick="selectMaidPackage('general')" data-pkg="general"
              class="maid-pkg-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🧹 Standard Clean (รายครั้ง)</span>
                <span class="text-pink-600 font-extrabold text-xs">350 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">กวาด ถู ดูดฝุ่น เช็ดกระจก ล้างห้องน้ำ เปลี่ยนผ้าปู</p>
            </div>
            <div onclick="selectMaidPackage('deep')" data-pkg="deep"
              class="maid-pkg-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">✨ Deep Clean ย้ายเข้า/ออก</span>
                <span class="text-pink-600 font-extrabold text-xs">500 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">ขัดคราบฝังแน่นทุกซอกมุม ขัดคราบกระจก ล้างระเบียง</p>
            </div>
            <div onclick="selectMaidPackage('ac')" data-pkg="ac"
              class="maid-pkg-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">❄️ ล้างแอร์หอพัก</span>
                <span class="text-pink-600 font-extrabold text-xs">400 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">ฉีดล้างฟิลเตอร์ ล้างแผงคอยล์เย็น เช็คระดับน้ำยาแอร์</p>
            </div>
            <div onclick="selectMaidPackage('combo')" data-pkg="combo"
              class="maid-pkg-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🛋️ Combo Clean + ซักที่นอน</span>
                <span class="text-pink-600 font-extrabold text-xs">650 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">คลีนใหญ่ทั้งห้อง + ดูดไรฝุ่นที่นอน และซักเซ็ตเครื่องนอน</p>
            </div>
          </div>
        </div>

        <!-- Step 2: Location & Room -->
        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-pink-600 text-white flex items-center justify-center text-[10px]">2</span>
            ระบุหอพัก และหมายเลขห้อง:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
            <div class="sm:col-span-8">
              <select id="maid-dorm-select"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
              </select>
            </div>
            <div class="sm:col-span-4">
              <input type="text" id="maid-room-no" placeholder="เลขห้องพัก (เช่น 402)"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div class="sm:col-span-12">
              <input type="text" id="maid-custom-dorm" placeholder="หรือพิมพ์ระบุชื่อหอพัก / ซอย / ที่อยู่ละเอียด"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
          </div>
        </div>

        <!-- Step 3: Date & Time Slot -->
        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-pink-600 text-white flex items-center justify-center text-[10px]">3</span>
            เลือกวันและช่วงเวลารับบริการ:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
              <input type="date" id="maid-date-input" required
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div class="sm:col-span-7 flex flex-wrap items-center gap-2">
              <label
                class="flex-1 flex items-center justify-center gap-1.5 p-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold cursor-pointer has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:text-pink-700">
                <input type="radio" name="maid-timeslot" value="09:00 - 12:00 น." checked class="text-pink-600">
                <span>09:00 - 12:00 น.</span>
              </label>
              <label
                class="flex-1 flex items-center justify-center gap-1.5 p-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold cursor-pointer has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:text-pink-700">
                <input type="radio" name="maid-timeslot" value="13:00 - 16:00 น." class="text-pink-600">
                <span>13:00 - 16:00 น.</span>
              </label>
              <label
                class="flex-1 flex items-center justify-center gap-1.5 p-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold cursor-pointer has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:text-pink-700">
                <input type="radio" name="maid-timeslot" value="16:30 - 19:30 น." class="text-pink-600">
                <span>16:30 - 19:30 น.</span>
              </label>
            </div>
          </div>
        </div>

        <!-- Optional Add-ons -->
        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 text-xs">บริการเสริมเพิ่มเติม (Add-ons):</label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            <label
              class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer hover:bg-slate-50">
              <input type="checkbox" id="maid-addon-balcony" onchange="toggleMaidAddon('balcony')"
                class="rounded text-pink-600 focus:ring-pink-500 w-4 h-4">
              <span>🧹 ขัดระเบียง + ล้างพัดลม (+100฿)</span>
            </label>
            <label
              class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer hover:bg-slate-50">
              <input type="checkbox" id="maid-addon-ozone" onchange="toggleMaidAddon('ozone')"
                class="rounded text-pink-600 focus:ring-pink-500 w-4 h-4">
              <span>💨 ฆ่าเชื้อโอโซนกำจัดกลิ่นห้อง (+150฿)</span>
            </label>
          </div>
        </div>

        <!-- Step 4: Customer Contact Info -->
        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-pink-600 text-white flex items-center justify-center text-[10px]">4</span>
            ข้อมูลผู้จอง & เบอร์ติดต่อ:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
            <div>
              <input type="text" id="maid-cust-name" required placeholder="ชื่อ-นามสกุล / ชื่อเล่น *"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div>
              <input type="tel" id="maid-cust-phone" required placeholder="เบอร์โทรศัพท์ติดต่อ *"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div>
              <input type="text" id="maid-cust-line" placeholder="Line ID (สะดวกส่งรูปห้อง)"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div class="sm:col-span-3">
              <input type="text" id="maid-notes" placeholder="หมายเหตุเพิ่มเติม (เช่น มีสัตว์เลี้ยง, คราบฝังแน่น)"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
          </div>
        </div>

        <!-- Promo Code & Price Calculation Box -->
        <div
          class="bg-gradient-to-r from-pink-500/10 via-rose-50 to-white p-4 rounded-2xl border border-pink-200 space-y-3">
          <div class="flex items-center gap-2">
            <input type="text" id="maid-promo-input" placeholder="โค้ดส่วนลดนิสิต (เช่น STUDENT50)"
              class="flex-1 text-xs p-2 bg-white border border-pink-300 rounded-xl uppercase font-semibold">
            <button type="button" onclick="applyMaidDiscount()"
              class="bg-pink-600 hover:bg-pink-700 text-white text-xs font-bold px-4 py-2 rounded-xl cursor-pointer">ใช้โค้ด</button>
          </div>
          <p id="maid-promo-msg" class="hidden text-xs"></p>

          <div class="border-t border-pink-200/80 pt-2 space-y-1 text-xs text-slate-600">
            <div class="flex justify-between">
              <span id="maid-calc-package-name">แพ็กเกจ</span>
              <span id="maid-calc-base-price" class="font-semibold">350 ฿</span>
            </div>
            <div class="flex justify-between text-slate-500">
              <span>บริการเสริม</span>
              <span id="maid-calc-addon-price">+0 ฿</span>
            </div>
            <div class="flex justify-between text-emerald-600 font-medium">
              <span>ส่วนลดนิสิต</span>
              <span id="maid-calc-discount-price">0 ฿</span>
            </div>
            <div
              class="flex justify-between items-center text-sm font-extrabold text-slate-900 border-t border-pink-200/80 pt-2">
              <span class="text-pink-700">ยอดรวมทั้งสิ้น (ชำระหลังเสร็จงาน)</span>
              <span id="maid-calc-total-price" class="text-xl text-pink-600">350 ฿</span>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
          <button type="submit"
            class="w-full bg-gradient-to-r from-pink-600 to-rose-600 hover:from-pink-700 hover:to-rose-700 text-white font-bold py-3.5 rounded-2xl shadow-md transition-all flex items-center justify-center gap-2 text-sm cursor-pointer">
            <i class="fa-solid fa-broom"></i> ยืนยันการจองแม่บ้านทำความสะอาด
          </button>
          <p class="text-center text-[11px] text-slate-400 mt-2">🔒 แม่บ้านผ่านการตรวจสอบประวัติอาชญากรรมทุกคน มั่นใจได้
            100%</p>
        </div>

      </form>
    </div>
  </div>


  <!-- ==================== MOVING SERVICE BOOKING MODAL ==================== -->
  <div id="moving-service-modal"
    class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div
      class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] flex flex-col shadow-2xl border border-amber-200 overflow-hidden my-auto animate-in fade-in zoom-in duration-200">

      <!-- Modal Header -->
      <div
        class="p-5 sm:p-6 bg-gradient-to-r from-amber-600 via-orange-500 to-amber-500 text-white flex items-center justify-between relative shadow-md">
        <div class="flex items-center gap-3">
          <div
            class="w-11 h-11 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl border border-white/30 shadow-inner">
            <i class="fa-solid fa-truck-moving"></i>
          </div>
          <div>
            <div class="flex items-center gap-2">
              <h2 class="text-lg sm:text-xl font-bold">จองรถรับจ้างขนย้ายของ & ย้ายหอพัก</h2>
              <span class="bg-white/20 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">เริ่มต้น 200฿</span>
            </div>
            <p class="text-xs text-amber-100 mt-0.5">มีคนช่วยยกของ ส่งตรงถึงห้องพัก ปลอดภัย ตรงเวลา</p>
          </div>
        </div>
        <button onclick="closeMovingServiceModal()"
          class="text-white/80 hover:text-white text-2xl p-2 rounded-xl hover:bg-white/10 transition-colors cursor-pointer">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <!-- Modal Body (Form) -->
      <form onsubmit="submitMovingBooking(event)"
        class="p-5 sm:p-6 overflow-y-auto space-y-5 flex-1 bg-slate-50 text-xs sm:text-sm">

        <!-- Step 1: Vehicle Selection -->
        <div class="space-y-2">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-amber-600 text-white flex items-center justify-center text-[10px]">1</span>
            เลือกประเภทรถรับจ้างขนย้าย:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            <div onclick="selectMovingVehicle('pickup_box')" data-vehicle="pickup_box"
              class="moving-v-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🛻 กระบะตู้ทึบกันฝน</span>
                <span class="text-amber-700 font-extrabold text-xs">450 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">ยอดนิยมย้ายหอ ของไม่เปียกฝน ใส่เตียง 5 ฟุต ตู้เย็นได้</p>
            </div>
            <div onclick="selectMovingVehicle('pickup_open')" data-vehicle="pickup_open"
              class="moving-v-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🚚 กระบะคอกสูง + ผ้าใบ</span>
                <span class="text-amber-700 font-extrabold text-xs">450 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">ขนของชิ้นทรงสูงได้ดี เชือกมัดแน่นหนา มีผ้าใบคลุม</p>
            </div>
            <div onclick="selectMovingVehicle('sidecar')" data-vehicle="sidecar"
              class="moving-v-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🛵 มอเตอร์ไซค์พ่วงข้าง</span>
                <span class="text-amber-700 font-extrabold text-xs">200 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">เหมาะกับของน้อย 4-5 กล่อง ย้ายระยะใกล้ในโซน ม.</p>
            </div>
            <div onclick="selectMovingVehicle('truck4w')" data-vehicle="truck4w"
              class="moving-v-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🚛 รถ 4 ล้อใหญ่จัมโบ้</span>
                <span class="text-amber-700 font-extrabold text-xs">800 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">พื้นที่กว้าง จุของได้ 2 เท่า เหมาะย้ายร่วมกับเพื่อน</p>
            </div>
          </div>
        </div>

        <!-- Step 2: Route Origin & Destination -->
        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-amber-600 text-white flex items-center justify-center text-[10px]">2</span>
            ระบุเส้นทางต้นทาง ➔ ปลายทาง:
          </label>
          <div class="space-y-2">
            <div class="relative">
              <i class="fa-solid fa-location-dot absolute left-3.5 top-1/2 -translate-y-1/2 text-emerald-600"></i>
              <input type="text" id="moving-origin-input" required
                placeholder="จุดรับของต้นทาง (เช่น หอพักเดิม, ซอยขามเรียง 4, บ้านพัก)..."
                class="w-full pl-9 pr-3 py-2.5 text-xs bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
              <div class="sm:col-span-6">
                <select id="moving-dest-dorm-select"
                  class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
                </select>
              </div>
              <div class="sm:col-span-6">
                <input type="text" id="moving-custom-dest"
                  placeholder="หรือพิมพ์ระบุจุดส่งปลายทางเอง (เช่น หอพักใหม่/เลขห้อง)"
                  class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
              </div>
            </div>
          </div>
        </div>

        <!-- Step 3: Helpers & Stairs -->
        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-amber-600 text-white flex items-center justify-center text-[10px]">3</span>
            บริการคนช่วยยกของ (Helper):
          </label>
          <div class="flex flex-wrap items-center gap-2">
            <button type="button" onclick="selectMovingHelper(0)" data-level="0"
              class="moving-helper-pill flex-1 py-2 px-3 bg-white border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer">
              ไม่ใช้คนช่วยยก (0฿)
            </button>
            <button type="button" onclick="selectMovingHelper(1)" data-level="1"
              class="moving-helper-pill flex-1 py-2 px-3 bg-amber-600 text-white border border-amber-600 rounded-xl text-xs font-semibold cursor-pointer">
              คนขับช่วยยก 1 คน (+150฿)
            </button>
            <button type="button" onclick="selectMovingHelper(2)" data-level="2"
              class="moving-helper-pill flex-1 py-2 px-3 bg-white border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer">
              คนช่วยยก 2 คน (+300฿)
            </button>
          </div>
          <label
            class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer hover:bg-slate-50 mt-2">
            <input type="checkbox" id="moving-addon-stairs" onchange="toggleMovingStairs()"
              class="rounded text-amber-600 focus:ring-amber-500 w-4 h-4">
            <span>🏢 หอพักไม่มีลิฟต์ ต้องยกขึ้นบันไดชั้น 3 ขึ้นไป (+100฿)</span>
          </label>
        </div>

        <!-- Step 4: Items to Move Checkboxes -->
        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 text-xs">สิ่งของหลักที่ต้องการขนย้าย (เลือกได้หลายข้อ):</label>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
            <label
              class="flex items-center gap-1.5 p-2 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-items" value="ตู้เย็น" checked class="rounded text-amber-600">
              <span>🧊 ตู้เย็น</span>
            </label>
            <label
              class="flex items-center gap-1.5 p-2 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-items" value="ที่นอน/ท็อปเปอร์" checked
                class="rounded text-amber-600">
              <span>🛏️ ที่นอน 5-6 ฟุต</span>
            </label>
            <label
              class="flex items-center gap-1.5 p-2 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-items" value="โต๊ะ/เก้าอี้เกมมิ่ง" class="rounded text-amber-600">
              <span>🪑 โต๊ะ / เก้าอี้</span>
            </label>
            <label
              class="flex items-center gap-1.5 p-2 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-items" value="ลังเสื้อผ้า/กล่องของ" checked
                class="rounded text-amber-600">
              <span>📦 ลัง / กล่องของ</span>
            </label>
            <label
              class="flex items-center gap-1.5 p-2 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-items" value="พัดลม/เครื่องใช้ไฟฟ้า" class="rounded text-amber-600">
              <span>🔌 เครื่องใช้ไฟฟ้า</span>
            </label>
            <label
              class="flex items-center gap-1.5 p-2 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-items" value="ราวตากผ้า/ชั้นวาง" class="rounded text-amber-600">
              <span>👗 ราวตากผ้า</span>
            </label>
          </div>
        </div>

        <!-- Step 5: Date & Contact Info -->
        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-amber-600 text-white flex items-center justify-center text-[10px]">4</span>
            วันเวลา และข้อมูลผู้จอง:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
            <div class="sm:col-span-6">
              <input type="date" id="moving-date-input" required
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
            <div class="sm:col-span-6">
              <input type="time" id="moving-time-input" value="10:00" required
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
            <div class="sm:col-span-6">
              <input type="text" id="moving-cust-name" required placeholder="ชื่อผู้จองรถ *"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
            <div class="sm:col-span-6">
              <input type="tel" id="moving-cust-phone" required placeholder="เบอร์โทรศัพท์ติดต่อ *"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
            <div class="sm:col-span-12">
              <input type="text" id="moving-items-detail" placeholder="รายละเอียดของอื่นๆ เพิ่มเติม (ถ้ามี)"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
          </div>
        </div>

        <!-- Live Price Calculation Box -->
        <div
          class="bg-gradient-to-r from-amber-500/10 via-orange-50 to-white p-4 rounded-2xl border border-amber-200 space-y-2">
          <div class="space-y-1 text-xs text-slate-600">
            <div class="flex justify-between">
              <span id="moving-calc-vehicle-name">ประเภทรถ</span>
              <span id="moving-calc-base-price" class="font-semibold">450 ฿</span>
            </div>
            <div class="flex justify-between text-slate-500">
              <span>ค่าบริการคนช่วยยก</span>
              <span id="moving-calc-helper-price">+150 ฿</span>
            </div>
            <div class="flex justify-between text-slate-500">
              <span>ค่ายกขึ้นบันได (ไม่มีลิฟต์)</span>
              <span id="moving-calc-stairs-price">0 ฿</span>
            </div>
            <div
              class="flex justify-between items-center text-sm font-extrabold text-slate-900 border-t border-amber-200/80 pt-2">
              <span class="text-amber-800">ราคาประเมินเบื้องต้น (จ่ายคนขับเมื่อส่งถึง)</span>
              <span id="moving-calc-total-price" class="text-xl text-amber-700">600 ฿</span>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
          <button type="submit"
            class="w-full bg-gradient-to-r from-amber-600 to-orange-600 hover:from-amber-700 hover:to-orange-700 text-white font-bold py-3.5 rounded-2xl shadow-md transition-all flex items-center justify-center gap-2 text-sm cursor-pointer">
            <i class="fa-solid fa-truck-moving"></i> ยืนยันการจองรถรับจ้างขนย้ายของ
          </button>
          <p class="text-center text-[11px] text-slate-400 mt-2">🚗 คนขับมีใบขับขี่ถูกต้อง ดูแลทรัพย์สินอย่างระมัดระวัง
          </p>
        </div>

      </form>
    </div>
  </div>


  <!-- ==================== BOOKING SUCCESS CONFIRMATION MODAL ==================== -->
  <div id="service-success-modal"
    class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
    <div
      class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-emerald-200 text-center space-y-4 my-auto animate-in fade-in zoom-in duration-200">
      <div
        class="w-16 h-16 rounded-3xl bg-emerald-100 text-emerald-600 mx-auto flex items-center justify-center text-3xl shadow-glow-emerald">
        <i class="fa-solid fa-circle-check"></i>
      </div>

      <div>
        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">บันทึกการจองสำเร็จ</span>
        <h3 id="success-service-title" class="text-lg font-extrabold text-slate-900 mt-2">บริการแม่บ้านทำความสะอาด</h3>
        <p class="text-xs text-slate-500">รหัสการจอง: <strong id="success-booking-id"
            class="text-slate-800">MD-000000</strong></p>
      </div>

      <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs text-left space-y-2">
        <p><strong>รายการ:</strong> <span id="success-package-name" class="text-slate-700">-</span></p>
        <p id="success-location-info"><strong>สถานที่:</strong> -</p>
        <p><strong id="success-datetime">เวลานัดหมาย:</strong> -</p>
        <p><strong>ผู้จอง:</strong> <span id="success-cust-info" class="text-slate-700">-</span></p>
        <div class="border-t border-slate-200 pt-2 flex justify-between items-center font-bold">
          <span>ยอดชำระ:</span>
          <span id="success-total-price" class="text-base text-brand-600">0 ฿</span>
        </div>
      </div>

      <div class="flex items-center gap-2 pt-2">
        <button onclick="closeSuccessModal(); openMyBookingsModal();"
          class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-xl text-xs transition-colors cursor-pointer">
          <i class="fa-solid fa-receipt mr-1"></i> ดูรายการจองของฉัน
        </button>
        <button onclick="closeSuccessModal()"
          class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2.5 rounded-xl text-xs transition-colors cursor-pointer">
          ตกลง
        </button>
      </div>
    </div>
  </div>


  <!-- ==================== MY BOOKINGS MODAL ==================== -->
  <div id="my-bookings-modal"
    class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div
      class="bg-white rounded-3xl max-w-xl w-full max-h-[85vh] flex flex-col shadow-2xl border border-slate-200 overflow-hidden my-auto">
      <div class="p-5 bg-slate-900 text-white flex items-center justify-between">
        <div class="flex items-center gap-2.5">
          <div class="w-9 h-9 rounded-xl bg-brand-600 flex items-center justify-center text-base">
            <i class="fa-solid fa-receipt"></i>
          </div>
          <div>
            <h3 class="font-bold text-base">รายการจองบริการของฉัน (My Bookings)</h3>
            <p class="text-[11px] text-slate-400">ตรวจสอบสถานะการจองแม่บ้านและรถขนย้ายของ</p>
          </div>
        </div>
        <button onclick="closeMyBookingsModal()" class="text-slate-400 hover:text-white text-xl p-1.5 rounded-lg">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div id="my-bookings-list-container" class="p-5 overflow-y-auto space-y-3 flex-1 bg-slate-50">
        <!-- Injected by JS -->
      </div>

      <div class="p-4 bg-white border-t border-slate-200 flex justify-between items-center">
        <div class="flex items-center gap-2 text-xs">
          <button onclick="openMaidServiceModal()" class="text-pink-600 font-bold hover:underline cursor-pointer">+
            จองแม่บ้าน</button>
          <span>•</span>
          <button onclick="openMovingServiceModal()" class="text-amber-700 font-bold hover:underline cursor-pointer">+
            จองรถขนของ</button>
        </div>
        <button onclick="closeMyBookingsModal()"
          class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-semibold">
          ปิด
        </button>
      </div>
    </div>
  </div>

  <!-- ==================== FLOATING BOTTOM COMPARE DOCK ==================== -->
  <div id="floating-compare-dock" class="fixed bottom-5 left-1/2 -translate-x-1/2 z-40 bg-slate-900/95 backdrop-blur-lg text-white shadow-2xl rounded-2xl px-4 sm:px-6 py-3 border border-purple-500/40 flex items-center gap-3 sm:gap-5 transition-all duration-300 transform translate-y-32 opacity-0 pointer-events-none max-w-[95vw]">
    <div class="flex items-center gap-2">
      <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-sm shadow-md">
        <i class="fa-solid fa-scale-balanced text-amber-400"></i>
      </div>
      <div>
        <span class="text-xs font-bold block text-purple-200">เปรียบเทียบหอพัก</span>
        <span class="text-[11px] text-slate-300">เลือกแล้ว <strong id="dock-compare-count-text" class="text-amber-400">0/3</strong> แห่ง</span>
      </div>
    </div>

    <!-- Mini selected dorm tags -->
    <div id="dock-compare-thumbs" class="hidden md:flex items-center gap-2 max-w-xs overflow-hidden"></div>

    <div class="flex items-center gap-2">
      <a href="compare.php" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-md transition-all flex items-center gap-1.5 whitespace-nowrap">
        <i class="fa-solid fa-code-compare"></i> ดูตารางเปรียบเทียบ
      </a>
      <button onclick="clearCompareList()" class="text-slate-400 hover:text-rose-400 text-xs px-2.5 py-2 rounded-lg hover:bg-white/10 transition-colors cursor-pointer" title="ล้างรายการ">
        <i class="fa-solid fa-trash-can"></i>
      </button>
    </div>
  </div>

  <!-- ==================== PHOTO LIGHTBOX ==================== -->
  <div id="photo-lightbox" class="hidden fixed inset-0 z-[70] bg-slate-950/85 backdrop-blur-sm p-4 sm:p-6 flex items-center justify-center">
    <div class="relative w-full max-w-5xl">
      <button onclick="closePhotoLightbox()" class="absolute -top-3 -right-3 z-10 w-10 h-10 rounded-full bg-white text-slate-700 shadow-lg flex items-center justify-center hover:bg-slate-100 transition-colors cursor-pointer">
        <i class="fa-solid fa-xmark"></i>
      </button>
      <div class="overflow-hidden rounded-[28px] border border-white/10 bg-slate-900/70 shadow-2xl">
        <div class="bg-slate-950/80 px-4 py-3 flex items-center justify-between gap-3 text-white">
          <span class="text-[11px] uppercase tracking-[0.2em] text-slate-300">Image Preview</span>
          <button onclick="closePhotoLightbox()" class="text-xs font-semibold text-slate-200 hover:text-white transition-colors cursor-pointer">
            ปิด
          </button>
        </div>
        <img id="lightbox-image" src="" alt="" class="block w-full max-h-[78vh] object-contain bg-slate-100">
        <div class="bg-white px-4 py-3 text-sm text-slate-700 border-t border-slate-200">
          <span id="lightbox-caption">รูปภาพหอพัก</span>
        </div>
      </div>
    </div>
  </div>

  <script src="app.js"></script>
</body>

</html>