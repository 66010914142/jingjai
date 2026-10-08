<?php
session_start();
$loggedUserName = $_SESSION['user']['name'] ?? ($_COOKIE['jingjai_user_name'] ?? '');
$isLoggedIn = !empty($_SESSION['user']) || (($_COOKIE['jingjai_logged_in'] ?? '') === 'true');
$loginButtonText = $isLoggedIn ? ('สวัสดี ' . explode(' ', trim($loggedUserName))[0]) : 'เข้าสู่ระบบ';
$loginButtonAction = $isLoggedIn ? "window.location.href='logout.php'" : "window.location.href='login.php'";
$loginButtonClasses = $isLoggedIn
  ? 'bg-gradient-to-r from-emerald-500 to-emerald-600 border border-emerald-300 text-white shadow-lg shadow-emerald-500/20 ring-2 ring-emerald-100 hover:shadow-xl hover:shadow-emerald-500/25'
  : 'bg-white border border-slate-200 text-slate-700 shadow-sm hover:border-brand-300 hover:bg-brand-50 ring-0';
$loginButtonIcon = $isLoggedIn ? 'fa-solid fa-user-check text-white' : 'fa-solid fa-right-to-bracket text-brand-600';
?>
<!DOCTYPE html>
<html lang="th" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>JingJai | ระบบค้นหาและวิเคราะห์รีวิวหอพักนิสิต/นักศึกษา</title>
  <meta name="description"
    content="ค้นหาและวิเคราะห์ข้อมูลรอบมหาวิทยาลัย มมส., มข., มทส., อุบลฯ พร้อม AI สรุปรีวิวข้อดี-ข้อควรทราบ, Google Maps นำทางจริง และประเมินค่าน้ำค่าไฟจริง">

  <!-- Google Fonts: Prompt & Kanit & Outfit -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Outfit:wght@400;600;700&family=Prompt:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">

  <!-- FontAwesome 6 Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <!-- Tailwind CSS CDN with config -->
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
          },
          boxShadow: {
            'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
            'glow-blue': '0 0 20px rgba(37, 99, 235, 0.25)',
            'glow-purple': '0 0 20px rgba(124, 58, 237, 0.25)',
          }
        }
      }
    }
  </script>

  <style type="text/tailwindcss">
    @layer utilities {
      .glass-card {
        @apply bg-white/90 backdrop-blur-md border border-slate-200/80 shadow-glass rounded-2xl;
      }
      .glass-card-dark {
        @apply bg-slate-900/90 backdrop-blur-md border border-slate-800 shadow-glass rounded-2xl text-white;
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
            <span class="text-[10px] block font-semibold text-slate-500 -mt-1">ระบบวิเคราะห์รีวิว & บริการรอบ ม.</span>
          </div>
        </a>

        <!-- Main Navigation Links -->
        <nav class="hidden md:flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
          <!-- แม่บ้าน Button in Nav -->
          <a href="maid-service.php"
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all text-pink-700 hover:bg-pink-100 hover:text-pink-800 flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-broom text-pink-500"></i> จองแม่บ้าน
          </a>
          <!-- ขนย้ายของ Button in Nav -->
          <a href="moving-service.php"
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all text-amber-700 hover:bg-amber-100 hover:text-amber-800 flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-truck-moving text-amber-500"></i> จองรถขนของ
          </a>
        </nav>

        <!-- Right Action: Login & My Bookings -->
        <div class="flex items-center gap-2">
          <button id="login-trigger-btn" onclick="<?php echo htmlspecialchars($loginButtonAction, ENT_QUOTES, 'UTF-8'); ?>"
            class="<?php echo htmlspecialchars($loginButtonClasses, ENT_QUOTES, 'UTF-8'); ?> px-4 py-2 rounded-xl text-xs font-semibold transition-all flex items-center gap-2 cursor-pointer"
            title="<?php echo $isLoggedIn ? 'ออกจากระบบ' : 'เข้าสู่ระบบ'; ?>">
            <i class="<?php echo htmlspecialchars($loginButtonIcon, ENT_QUOTES, 'UTF-8'); ?>"></i>
            <span id="login-button-label"><?php echo htmlspecialchars($loginButtonText, ENT_QUOTES, 'UTF-8'); ?></span>
          </button>

          <button onclick="openMyBookingsModal()"
            class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center gap-2 cursor-pointer relative"
            title="ประวัติและรายการจองของฉัน">
            <i class="fa-solid fa-receipt text-amber-400"></i>
            <span>รายการจอง</span>
            <span
              class="my-bookings-count hidden bg-rose-500 text-white font-extrabold text-[10px] px-1.5 py-0.2 rounded-full absolute -top-1.5 -right-1.5 shadow-xs">0</span>
          </button>
        </div>
      </div>
    </div>
  </header>


  <!-- ==================== HERO SEARCH & FILTER SECTION ==================== -->
  <section class="bg-gradient-to-b from-brand-50 via-white to-slate-50 border-b border-slate-200/60 pt-8 pb-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

      <!-- Headline -->
      <div class="text-center max-w-3xl mx-auto mb-8">
        <span
          class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-100 text-brand-700 text-xs font-semibold mb-3">
          <i class="fa-solid fa-wand-magic-sparkles text-accent-purple"></i> ระบบวิเคราะห์รีวิวด้วย AI + Google Maps
          นำทางจริง
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
          ค้นหาพื้นที่พักที่ใช่ <span
            class="bg-gradient-to-r from-brand-600 via-indigo-600 to-accent-purple bg-clip-text text-transparent">ตรงปก
            สรุปด้วย AI</span>
        </h1>
        <p class="text-xs sm:text-sm text-slate-600 mt-2">
          วิเคราะห์คะแนน 6 มิติ (ความเงียบ, น้ำประปา, Wi-Fi), รูปถ่ายจริงจากผู้พัก vs เจ้าของ และแผนที่ Google Maps
          นำทาง
        </p>
      </div>

      <!-- Main Search & Filter Box -->
      <div class="glass-card p-4 sm:p-6 max-w-4xl mx-auto space-y-4 border border-slate-200/90 shadow-xl">

        <!-- Search Bar Input -->
        <div class="relative">
          <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-base"></i>
          <input type="text" id="search-input" onkeyup="applyFilters()"
            placeholder="พิมพ์ชื่อ ซอย หรือชื่อโซน มมส. (เช่น ขามเรียง, ท่าขอนยาง, ซอยวุ่นวาย, ซอยลีลา, มอเก่า)..."
            class="w-full pl-11 pr-4 py-3 bg-white border border-slate-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 shadow-inner">
        </div>

        <!-- Price Range Slider & Calculator Shortcut -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center pt-2 border-t border-slate-200/80">

          <div class="md:col-span-8 flex flex-col justify-center px-2">
            <div class="flex justify-between items-center text-xs font-semibold text-slate-700 mb-1">
              <span>งบค่าเช่าสูงสุด:</span>
              <span id="price-val" class="text-brand-600 font-bold text-sm">5,000 บาท/เดือน</span>
            </div>
            <input type="range" id="price-range" min="2000" max="7000" step="200" value="5000"
              oninput="updatePriceLabel(this.value); applyFilters();" class="w-full accent-brand-600 cursor-pointer">
          </div>

          <!-- Filter Reset / Toggle Button -->
          <div class="md:col-span-4 flex items-center gap-2">
            <button onclick="toggleMoreFilters()"
              class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium px-3 py-2.5 rounded-xl text-xs transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
              <i class="fa-solid fa-sliders"></i> ตัวกรอง
            </button>
            <button onclick="resetFilters()"
              class="bg-rose-50 hover:bg-rose-100 text-rose-600 px-3 py-2.5 rounded-xl text-xs font-medium transition-colors cursor-pointer"
              title="ล้างตัวกรอง">
              <i class="fa-solid fa-rotate-right"></i>
            </button>
          </div>

        </div>

        <!-- Quick Expense Estimator Bar (Positioned inside budget search area) -->
        <div class="pt-2 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-2">
          <span class="text-xs text-slate-500 flex items-center gap-1.5">
            <i class="fa-solid fa-circle-info text-brand-500"></i> ต้องการเช็คค่าใช้จ่ายรวมจริง (ค่าเช่า + ค่าน้ำ +
            ค่าไฟ)?
          </span>
          <a href="calculator.php"
            class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 hover:text-emerald-800 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 py-1.5 px-3 rounded-xl transition-all shadow-2xs">
            <i class="fa-solid fa-calculator text-emerald-600"></i> เครื่องมือคำนวณค่าใช้จ่ายสุทธิต่อเดือน
          </a>
        </div>

        <!-- Checkbox Options Filter (Collapsible) -->
        <div id="more-filters-panel"
          class="hidden mt-4 pt-4 border-t border-slate-200 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-3">
          <label class="flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer select-none">
            <input type="checkbox" id="chk-air" onchange="applyFilters()"
              class="rounded text-brand-600 focus:ring-brand-500 w-4 h-4" checked>
            <span>❄️ เครื่องปรับอากาศ</span>
          </label>
          <label class="flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer select-none">
            <input type="checkbox" id="chk-furniture" onchange="applyFilters()"
              class="rounded text-brand-600 focus:ring-brand-500 w-4 h-4">
            <span>🛋️ เฟอร์นิเจอร์ครบ</span>
          </label>
          <label class="flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer select-none">
            <input type="checkbox" id="chk-wifi" onchange="applyFilters()"
              class="rounded text-brand-600 focus:ring-brand-500 w-4 h-4" checked>
            <span>🌐 High-speed Wi-Fi</span>
          </label>
          <label class="flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer select-none">
            <input type="checkbox" id="chk-pet" onchange="applyFilters()"
              class="rounded text-brand-600 focus:ring-brand-500 w-4 h-4">
            <span>🐾 รับสัตว์เลี้ยง</span>
          </label>
          <label class="flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer select-none">
            <input type="checkbox" id="chk-parking" onchange="applyFilters()"
              class="rounded text-brand-600 focus:ring-brand-500 w-4 h-4">
            <span>🚗 ที่จอดรถยนต์</span>
          </label>
          <label class="flex items-center gap-2 text-xs font-medium text-slate-700 cursor-pointer select-none">
            <input type="checkbox" id="chk-quiet" onchange="applyFilters()"
              class="rounded text-brand-600 focus:ring-brand-500 w-4 h-4">
            <span>🔇 เน้นความเงียบ (>4.5)</span>
          </label>
        </div>

      </div>

      <!-- Quick Services Banner: แม่บ้าน & ขนย้ายของ -->
      <div class="mt-6 max-w-4xl mx-auto grid grid-cols-1 sm:grid-cols-2 gap-4">
        <!-- Maid Service Card -->
        <div
          class="bg-gradient-to-r from-pink-500/10 via-rose-50/70 to-white p-4 sm:p-5 rounded-2xl border border-pink-200 shadow-sm flex items-center justify-between gap-4 hover:border-pink-300 hover:shadow-md transition-all group">
          <div class="flex items-center gap-3.5">
            <div
              class="w-12 h-12 rounded-xl bg-gradient-to-tr from-pink-500 to-rose-400 text-white flex items-center justify-center text-xl shadow-md group-hover:scale-105 transition-transform">
              <i class="fa-solid fa-broom"></i>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <h3 class="font-bold text-slate-900 text-sm sm:text-base">บริการแม่บ้านทำความสะอาด</h3>
                <span class="bg-pink-100 text-pink-700 text-[10px] font-bold px-2 py-0.5 rounded-full">เริ่มต้น
                  350฿</span>
              </div>
              <p class="text-xs text-slate-500 mt-0.5">คลีนห้องก่อนเข้าพัก / ย้ายออก / ล้างแอร์หอพัก</p>
            </div>
          </div>
          <button onclick="openMaidServiceModal()"
            class="bg-pink-600 hover:bg-pink-700 text-white text-xs font-bold px-3.5 py-2 rounded-xl shadow-xs transition-all whitespace-nowrap cursor-pointer flex items-center gap-1.5">
            <i class="fa-solid fa-broom"></i>
            <span>จองแม่บ้าน</span>
          </button>
        </div>

        <!-- Moving Service Card -->
        <div
          class="bg-gradient-to-r from-amber-500/10 via-orange-50/70 to-white p-4 sm:p-5 rounded-2xl border border-amber-200 shadow-sm flex items-center justify-between gap-4 hover:border-amber-300 hover:shadow-md transition-all group">
          <div class="flex items-center gap-3.5">
            <div
              class="w-12 h-12 rounded-xl bg-gradient-to-tr from-amber-500 to-orange-400 text-white flex items-center justify-center text-xl shadow-md group-hover:scale-105 transition-transform">
              <i class="fa-solid fa-truck-moving"></i>
            </div>
            <div>
              <div class="flex items-center gap-2">
                <h3 class="font-bold text-slate-900 text-sm sm:text-base">บริการรถรับจ้างขนย้ายของ</h3>
                <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded-full">เริ่มต้น
                  450฿</span>
              </div>
              <p class="text-xs text-slate-500 mt-0.5">ย้ายหอพัก ขนตู้เย็น/เตียง รถกระบะพร้อมคนช่วยยก</p>
            </div>
          </div>
          <button onclick="openMovingServiceModal()"
            class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold px-3.5 py-2 rounded-xl shadow-xs transition-all whitespace-nowrap cursor-pointer flex items-center gap-1.5">
            <i class="fa-solid fa-truck-moving"></i>
            <span>เรียกรถขนของ</span>
          </button>
        </div>
      </div>

    </div>
  </section>


  <!-- ==================== MAIN CONTENT AREA ==================== -->
  <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="space-y-6">

      <!-- Section Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h2 class="text-xl font-bold text-slate-900 flex items-center gap-2">
            <span>ผลการค้นหา</span>
            <span id="result-count" class="bg-brand-100 text-brand-700 text-xs px-2.5 py-0.5 rounded-full font-bold">0
              แห่ง</span>
          </h2>
          <p class="text-xs text-slate-500">เลือกดูรายละเอียดหรือเปรียบเทียบบริการและข้อดี-ข้อเสีย</p>
        </div>

        <div class="flex items-center gap-2.5">
          <!-- Quick Compare Table Button -->
          <a href="compare.php"
            class="bg-purple-50 hover:bg-purple-100 text-purple-700 border border-purple-200 px-3.5 py-2 rounded-xl text-xs font-semibold transition-all inline-flex items-center gap-1.5 shadow-2xs">
            <i class="fa-solid fa-code-compare text-purple-600"></i>
            <span>ตารางเปรียบเทียบ</span>
            <span
              class="compare-badge-count bg-purple-600 text-white text-[10px] font-extrabold px-1.5 py-0.2 rounded-full">0/3</span>
          </a>

          <!-- Sort dropdown -->
          <div class="flex items-center gap-1.5 text-xs">
            <span class="text-slate-500 font-medium hidden sm:inline">จัดเรียง:</span>
            <select id="sort-select" onchange="applyFilters()"
              class="bg-white border border-slate-300 rounded-xl px-3 py-2 text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500 cursor-pointer">
              <option value="rating_desc">คะแนนรีวิวสูงสุด ⭐</option>
              <option value="price_asc">ราคาต่ำสุด ไป สูงสุด 💵</option>
              <option value="distance_asc">ใกล้ ม. ที่สุด 🚶</option>
              <option value="quiet_desc">ความเงียบสงบสูงสุด 🔇</option>
              <option value="internet_desc">อินเทอร์เน็ตเร็วสุด 🌐</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Dorm cards grid -->
      <div id="dorms-container" class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5"></div>

    </div>

  </main>


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
              <h2 class="text-lg sm:text-xl font-bold">จองบริการแม่บ้านทำความสะอาดห้องพัก</h2>
              <span class="bg-white/20 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">เริ่มต้น 350฿</span>
            </div>
            <p class="text-xs text-pink-100 mt-0.5">คลีนห้องพักรายครั้ง / บิ๊กคลีนนิ่งก่อนเข้าพัก-ย้ายออก /
              ล้างแอร์</p>
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
            <!-- Pkg 1 -->
            <div onclick="selectMaidPackage('general')" data-pkg="general"
              class="maid-pkg-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🧹 Standard Clean (รายครั้ง)</span>
                <span class="text-pink-600 font-extrabold text-xs">350 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">กวาด ถู ดูดฝุ่น เช็ดกระจก ล้างห้องน้ำ เปลี่ยนผ้าปู</p>
            </div>
            <!-- Pkg 2 -->
            <div onclick="selectMaidPackage('deep')" data-pkg="deep"
              class="maid-pkg-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">✨ Deep Clean ย้ายเข้า/ออก</span>
                <span class="text-pink-600 font-extrabold text-xs">500 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">ขัดคราบฝังแน่นทุกซอกมุม ขัดคราบกระจก ล้างระเบียง</p>
            </div>
            <!-- Pkg 3 -->
            <div onclick="selectMaidPackage('ac')" data-pkg="ac"
              class="maid-pkg-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">❄️ ล้างแอร์ห้องพัก</span>
                <span class="text-pink-600 font-extrabold text-xs">400 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">ฉีดล้างฟิลเตอร์ ล้างแผงคอยล์เย็น เช็คระดับน้ำยาแอร์</p>
            </div>
            <!-- Pkg 4 -->
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
            ระบุสถานที่และหมายเลขห้อง:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
            <div class="sm:col-span-8">
              <input type="text" id="maid-custom-dorm" required
                placeholder="พิมพ์ระบุชื่อหอพัก / ซอย / ที่อยู่ละเอียด"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div class="sm:col-span-4">
              <input type="text" id="maid-room-no" placeholder="เลขห้องพัก (เช่น 402)"
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
              <input type="text" id="maid-notes"
                placeholder="หมายเหตุเพิ่มเติม (เช่น สัตว์เลี้ยงในห้อง, มีคราบฝังแน่นที่พื้น)"
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
              <h2 class="text-lg sm:text-xl font-bold">จองรถรับจ้างขนย้ายของ & ย้ายห้อง</h2>
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
            <!-- V 1 -->
            <div onclick="selectMovingVehicle('pickup_box')" data-vehicle="pickup_box"
              class="moving-v-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🛻 กระบะตู้ทึบกันฝน</span>
                <span class="text-amber-700 font-extrabold text-xs">450 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">ยอดนิยมย้ายหอ ของไม่เปียกฝน ใส่เตียง 5 ฟุต ตู้เย็นได้</p>
            </div>
            <!-- V 2 -->
            <div onclick="selectMovingVehicle('pickup_open')" data-vehicle="pickup_open"
              class="moving-v-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🚚 กระบะคอกสูง + ผ้าใบ</span>
                <span class="text-amber-700 font-extrabold text-xs">450 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">ขนของชิ้นทรงสูงได้ดี เชือกมัดแน่นหนา มีผ้าใบคลุม</p>
            </div>
            <!-- V 3 -->
            <div onclick="selectMovingVehicle('sidecar')" data-vehicle="sidecar"
              class="moving-v-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🛵 มอเตอร์ไซค์พ่วงข้าง</span>
                <span class="text-amber-700 font-extrabold text-xs">200 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">เหมาะกับของน้อย 4-5 กล่อง ย้ายระยะใกล้ในโซน ม.</p>
            </div>
            <!-- V 4 -->
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
            <div class="relative">
              <i class="fa-solid fa-flag-checkered absolute left-3.5 top-1/2 -translate-y-1/2 text-rose-500"></i>
              <input type="text" id="moving-custom-dest" required
                placeholder="ระบุจุดส่งปลายทาง (เช่น หอพักใหม่/เลขห้อง/คอนโด)"
                class="w-full pl-9 pr-3 py-2.5 text-xs bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
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
            <span>🏢 ที่พักไม่มีลิฟต์ ต้องยกขึ้นบันไดชั้น 3 ขึ้นไป (+100฿)</span>
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


  <!-- ==================== LOGIN MODAL ==================== -->
  <div id="login-modal"
    class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
    <div class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-slate-200 my-auto">
      <div class="flex items-center justify-between mb-5">
        <div>
          <span class="inline-flex items-center gap-2 rounded-full bg-brand-100 text-brand-700 px-2.5 py-1 text-[10px] font-bold">
            <i class="fa-solid fa-shield-heart"></i> JingJai Member
          </span>
          <h3 class="text-xl font-extrabold text-slate-900 mt-3">เข้าสู่ระบบ</h3>
        </div>
        <button onclick="closeLoginModal()" class="text-slate-400 hover:text-slate-700 text-xl p-2 rounded-lg cursor-pointer">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form onsubmit="handleLoginSubmit(event)" class="space-y-4">
        <div>
          <label for="login-email" class="block text-xs font-semibold text-slate-600 mb-1">อีเมล / เบอร์โทร</label>
          <input id="login-email" type="text" placeholder="example@email.com หรือ 0812345678"
            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
        </div>

        <div>
          <label for="login-password" class="block text-xs font-semibold text-slate-600 mb-1">รหัสผ่าน</label>
          <input id="login-password" type="password" placeholder="กรอกรหัสผ่าน"
            class="w-full px-3 py-2.5 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
        </div>

        <div class="flex items-center justify-between text-[11px] text-slate-500">
          <label class="flex items-center gap-2 cursor-pointer">
            <input type="checkbox" class="rounded text-brand-600 focus:ring-brand-500">
            <span>จดจำฉันไว้</span>
          </label>
          <button type="button" class="text-brand-600 hover:text-brand-700 font-semibold cursor-pointer">ลืมรหัสผ่าน?</button>
        </div>

        <div id="login-message" class="hidden text-xs font-semibold rounded-lg px-3 py-2"></div>

        <button type="submit"
          class="w-full bg-gradient-to-r from-brand-600 to-indigo-600 hover:from-brand-700 hover:to-indigo-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-brand-500/20 transition-all cursor-pointer">
          <i class="fa-solid fa-right-to-bracket mr-2"></i> เข้าสู่ระบบ
        </button>

        <div class="text-center text-[11px] text-slate-500">
          ยังไม่มีบัญชี?
          <button type="button" class="text-brand-600 hover:text-brand-700 font-semibold cursor-pointer">สมัครสมาชิก</button>
        </div>
      </form>
    </div>
  </div>


  <!-- ==================== FLOATING BOTTOM COMPARE DOCK ==================== -->
  <div id="floating-compare-dock"
    class="fixed bottom-5 left-1/2 -translate-x-1/2 z-40 bg-slate-900/95 backdrop-blur-lg text-white shadow-2xl rounded-2xl px-4 sm:px-6 py-3 border border-purple-500/40 flex items-center gap-3 sm:gap-5 transition-all duration-300 transform translate-y-32 opacity-0 pointer-events-none max-w-[95vw]">
    <div class="flex items-center gap-2">
      <div
        class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center text-sm shadow-md">
        <i class="fa-solid fa-scale-balanced text-amber-400"></i>
      </div>
      <div>
        <span class="text-xs font-bold block text-purple-200">เปรียบเทียบ</span>
        <span class="text-[11px] text-slate-300">เลือกแล้ว <strong id="dock-compare-count-text"
            class="text-amber-400">0/3</strong> รายการ</span>
      </div>
    </div>

    <!-- Mini selected thumbs -->
    <div id="dock-compare-thumbs" class="hidden md:flex items-center gap-2 max-w-xs overflow-hidden"></div>

    <div class="flex items-center gap-2">
      <a href="compare.php"
        class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white text-xs font-bold px-4 py-2 rounded-xl shadow-md transition-all flex items-center gap-1.5 whitespace-nowrap">
        <i class="fa-solid fa-code-compare"></i> ดูตารางเปรียบเทียบ
      </a>
      <button onclick="clearCompareList()"
        class="text-slate-400 hover:text-rose-400 text-xs px-2.5 py-2 rounded-lg hover:bg-white/10 transition-colors cursor-pointer"
        title="ล้างรายการ">
        <i class="fa-solid fa-trash-can"></i>
      </button>
    </div>
  </div>


  <!-- FOOTER -->
  <footer class="bg-slate-900 text-slate-400 text-xs py-8 border-t border-slate-800 mt-12">
    <div class="max-w-7xl mx-auto px-4 text-center space-y-3">
      <div class="flex flex-wrap justify-center gap-4 text-slate-300 font-medium">
        <a href="compare.php" class="hover:text-white">ตารางเปรียบเทียบ</a> •
        <a href="calculator.php" class="hover:text-white">คำนวณค่าใช้จ่าย</a> •
        <a href="schema-doc.html" class="hover:text-white">PostgreSQL SQL Schema</a>
      </div>
      <p class="font-semibold text-slate-300">JingJai - ระบบค้นหาและวิเคราะห์รีวิวพื้นที่พักนิสิต มมส. (มหาวิทยาลัยมหาสารคาม) ด้วย AI</p>
      <p class="text-slate-500">ครอบคลุมทุกโซนรอบ มมส.: ขามเรียง (มอใหม่), ท่าขอนยาง, ซอยวุ่นวาย, ซอยลีลา, และโซนมอเก่า (ในเมือง)</p>
      <p class="text-[11px] text-slate-600">ออกแบบด้วย Tailwind CSS & Google Maps Integration Ready</p>
    </div>
  </footer>

  <!-- App logic JavaScript -->
  <script src="app.js?v=<?php echo filemtime(__DIR__ . '/app.js'); ?>"></script>
</body>

</html>
