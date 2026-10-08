<!DOCTYPE html>
<html lang="th" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>จองบริการแม่บ้านทำความสะอาดหอพัก | JingJai</title>
  <meta name="description"
    content="บริการแม่บ้านทำความสะอาดหอพักรอบมหาวิทยาลัย ทำความสะอาดรายครั้ง บิ๊กคลีนนิ่งย้ายเข้า-ย้ายออก และล้างแอร์หอพัก ผ่านการตรวจสอบประวัติทุกคน">

  <!-- Google Fonts: Prompt, Kanit, Outfit -->
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
            'glow-pink': '0 0 25px rgba(236, 72, 153, 0.25)',
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
    }
  </style>
</head>

<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col antialiased selection:bg-pink-500 selection:text-white">

  <!-- ==================== HEADER NAVBAR ==================== -->
  <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-2xs">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <a href="index.php" class="flex items-center gap-3 cursor-pointer">
          <div
            class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 via-accent-purple to-pink-500 flex items-center justify-center text-white font-bold text-xl shadow-md">
            <i class="fa-solid fa-building-user"></i>
          </div>
          <div>
            <span
              class="text-xl font-bold bg-gradient-to-r from-brand-600 to-accent-purple bg-clip-text text-transparent">JingJai</span>
            <span class="text-[10px] block font-semibold text-slate-500 -mt-1">ค้นหาหอพักนิสิต & บริการหอพัก</span>
          </div>
        </a>

        <!-- Main Navigation Links -->
        <nav class="hidden md:flex items-center gap-1 bg-slate-100 p-1 rounded-xl">
          <a href="index.php"
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all text-slate-600 hover:text-brand-600 hover:bg-white/60">
            <i class="fa-solid fa-list-ul mr-1.5"></i> รายการหอพัก
          </a>
          <a href="maid-service.php"
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all bg-white text-pink-600 shadow-xs">
            <i class="fa-solid fa-broom mr-1.5 text-pink-500"></i> จองแม่บ้าน
          </a>
          <a href="moving-service.php"
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all text-amber-700 hover:bg-amber-100 hover:text-amber-800 flex items-center gap-1.5">
            <i class="fa-solid fa-truck-moving text-amber-500"></i> จองรถขนของ
          </a>
        </nav>

        <!-- Right Action: My Bookings -->
        <div class="flex items-center gap-2">
          <button onclick="openMyBookingsModal()"
            class="bg-slate-900 hover:bg-slate-800 text-white px-4 py-2 rounded-xl text-xs font-semibold shadow-sm transition-all flex items-center gap-2 cursor-pointer relative">
            <i class="fa-solid fa-receipt text-amber-400"></i>
            <span>รายการจอง</span>
            <span id="header-booking-badge"
              class="hidden bg-rose-500 text-white font-extrabold text-[10px] px-1.5 py-0.2 rounded-full absolute -top-1.5 -right-1.5 shadow-xs">0</span>
          </button>
        </div>
      </div>
    </div>
  </header>

  <!-- ==================== HERO SECTION ==================== -->
  <section class="bg-gradient-to-b from-pink-50 via-white to-slate-50 border-b border-pink-100/70 pt-10 pb-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
      <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-pink-100 text-pink-700 text-xs font-semibold">
        <i class="fa-solid fa-shield-heart text-pink-500"></i> ปลอดภัย ไว้ใจได้ ตรวจสอบประวัติอาชญากรรม 100%
      </span>
      <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
        บริการแม่บ้านทำความสะอาดหอพัก <br>
        <span class="bg-gradient-to-r from-pink-600 via-rose-500 to-accent-purple bg-clip-text text-transparent">
          สะอาดกริ๊บ สะดวก รวดเร็ว ในราคานักศึกษา
        </span>
      </h1>
      <p class="text-xs sm:text-sm text-slate-600 max-w-2xl mx-auto">
        คลีนห้องรายครั้งก่อนตรวจห้อง, บิ๊กคลีนนิ่งย้ายเข้า-ย้ายออกรับเงินประกันคืนเต็มจำนวน หรือล้างแอร์หอพัก จองง่ายใน 2 นาที
      </p>

      <!-- Trust Badges -->
      <div class="pt-2 flex flex-wrap items-center justify-center gap-4 text-xs font-medium text-slate-600">
        <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-500"></i> น้ำยา & อุปกรณ์มาตรฐานพร้อม</div>
        <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-500"></i> จ่ายเงินเมื่อเสร็จงาน</div>
        <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-500"></i> รับประกันความพึงพอใจ</div>
      </div>
    </div>
  </section>

  <!-- ==================== MAIN BOOKING FORM SECTION ==================== -->
  <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-6">
    <div class="bg-white rounded-3xl border border-pink-100 shadow-xl overflow-hidden">

      <!-- Form Card Header -->
      <div class="bg-gradient-to-r from-pink-600 via-rose-500 to-pink-500 text-white p-6 flex items-center justify-between">
        <div class="flex items-center gap-3.5">
          <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl border border-white/30 shadow-inner">
            <i class="fa-solid fa-broom"></i>
          </div>
          <div>
            <h2 class="text-lg sm:text-xl font-bold">กรอกข้อมูลการจองบริการ</h2>
            <p class="text-xs text-pink-100 mt-0.5">เลือกแพ็กเกจ กำหนดวันเวลา และระบุหอพักที่ต้องการรับบริการ</p>
          </div>
        </div>
        <div class="text-right hidden sm:block">
          <span class="text-[11px] text-pink-200 block">เริ่มต้นเพียง</span>
          <span class="text-xl font-extrabold text-white">350 ฿</span>
        </div>
      </div>

      <!-- Main Form -->
      <form id="maid-booking-form" onsubmit="handleMaidBookingSubmit(event)" class="p-6 sm:p-8 space-y-6 bg-slate-50/50">

        <!-- Step 1: Package Selection -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <div class="flex items-center justify-between">
            <label class="font-bold text-slate-900 flex items-center gap-2 text-sm">
              <span class="w-6 h-6 rounded-full bg-pink-600 text-white flex items-center justify-center text-xs">1</span>
              เลือกแพ็กเกจทำความสะอาดที่ต้องการ:
            </label>
            <span class="text-[11px] text-slate-400 font-medium">* คลิกเลือก 1 รายการ</span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="package-grid">
            <!-- Pkg 1 -->
            <div onclick="selectPackage('general', 350, 'Standard Clean (รายครั้ง)')" data-pkg="general"
              class="pkg-card active-pkg p-4 rounded-2xl border-2 border-pink-500 bg-pink-50/50 hover:border-pink-500 transition-all cursor-pointer space-y-2">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-sm">🧹 Standard Clean (รายครั้ง)</span>
                <span class="text-pink-600 font-extrabold text-sm">350 ฿</span>
              </div>
              <p class="text-xs text-slate-500">กวาด ถู ดูดฝุ่น เช็ดกระจก ล้างห้องน้ำ เปลี่ยนผ้าปูที่นอน เหมาะสำหรับดูแลห้องทั่วไป</p>
              <div class="text-[11px] text-pink-700 font-medium flex items-center gap-1">
                <i class="fa-regular fa-clock"></i> ใช้เวลาประมาณ 1.5 - 2 ชั่วโมง
              </div>
            </div>

            <!-- Pkg 2 -->
            <div onclick="selectPackage('deep', 500, 'Deep Clean ย้ายเข้า/ออก')" data-pkg="deep"
              class="pkg-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer space-y-2">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-sm">✨ Deep Clean ย้ายเข้า/ออก</span>
                <span class="text-pink-600 font-extrabold text-sm">500 ฿</span>
              </div>
              <p class="text-xs text-slate-500">ขัดคราบฝังแน่นทุกซอกมุม เช็ดคราบมัน ล้างระเบียง และห้องน้ำอย่างละเอียด เพื่อคืนประกันหอพัก</p>
              <div class="text-[11px] text-pink-700 font-medium flex items-center gap-1">
                <i class="fa-regular fa-clock"></i> ใช้เวลาประมาณ 2.5 - 3.5 ชั่วโมง
              </div>
            </div>

            <!-- Pkg 3 -->
            <div onclick="selectPackage('ac', 400, 'ล้างแอร์หอพัก')" data-pkg="ac"
              class="pkg-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer space-y-2">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-sm">❄️ ล้างแอร์หอพัก</span>
                <span class="text-pink-600 font-extrabold text-sm">400 ฿</span>
              </div>
              <p class="text-xs text-slate-500">ฉีดล้างฟิลเตอร์ ล้างแผงคอยล์เย็น โบลเวอร์ เช็คระดับน้ำยาแอร์ ลมแรง เย็นฉ่ำ ประหยัดไฟ</p>
              <div class="text-[11px] text-pink-700 font-medium flex items-center gap-1">
                <i class="fa-regular fa-clock"></i> ใช้เวลาประมาณ 1 ชั่วโมง / เครื่อง
              </div>
            </div>

            <!-- Pkg 4 -->
            <div onclick="selectPackage('combo', 650, 'Combo Clean + ดูดไรฝุ่นที่นอน')" data-pkg="combo"
              class="pkg-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-pink-300 transition-all cursor-pointer space-y-2">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-sm">🛋️ Combo Clean + ที่นอน</span>
                <span class="text-pink-600 font-extrabold text-sm">650 ฿</span>
              </div>
              <p class="text-xs text-slate-500">คลีนเต็มห้อง + ดูดกำจัดไรฝุ่นที่นอนพร้อมอบ UV ฆ่าเชื้อ เหมาะกับคนเป็นภูมิแพ้</p>
              <div class="text-[11px] text-pink-700 font-medium flex items-center gap-1">
                <i class="fa-regular fa-clock"></i> ใช้เวลาประมาณ 3 ชั่วโมง
              </div>
            </div>
          </div>
        </div>

        <!-- Step 2: Location & Room Info -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <label class="font-bold text-slate-900 flex items-center gap-2 text-sm">
            <span class="w-6 h-6 rounded-full bg-pink-600 text-white flex items-center justify-center text-xs">2</span>
            ระบุหอพักและห้องพัก:
          </label>

          <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8">
              <label class="block text-xs font-semibold text-slate-600 mb-1">เลือกหอพักในระบบ</label>
              <select id="form-dorm-select" onchange="handleDormChange()"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
                <option value="">-- เลือกหอพักจากรายชื่อ --</option>
                <option value="หอพักเดอะปาล์ม ขามเรียง">หอพักเดอะปาล์ม (ขามเรียง/มอใหม่)</option>
                <option value="หอพักกรีนวิว ท่าขอนยาง">หอพักกรีนวิว (ท่าขอนยาง)</option>
                <option value="หอพักสุขสบาย ซอยวุ่นวาย">หอพักสุขสบาย (ซอยวุ่นวาย)</option>
                <option value="หอพักพรีเมี่ยมพาร์ค มอเก่า">หอพักพรีเมี่ยมพาร์ค (มอเก่า ในเมือง)</option>
                <option value="other">หอพักอื่นๆ (พิมพ์ระบุเองด้านล่าง)</option>
              </select>
            </div>
            <div class="sm:col-span-4">
              <label class="block text-xs font-semibold text-slate-600 mb-1">เลขที่ห้อง *</label>
              <input type="text" id="form-room-no" required placeholder="เช่น 402, B3"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div class="sm:col-span-12">
              <label class="block text-xs font-semibold text-slate-600 mb-1">ชื่อหอพัก / ซอย / จุดสังเกต (กรณีหอพักไม่อยู่ในรายการด้านบน)</label>
              <input type="text" id="form-dorm-custom" placeholder="เช่น หอสุขใจ ซอยขามเรียง 6 ตรงข้ามร้านซักรีด"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
          </div>
        </div>

        <!-- Step 3: Date & Time Slot -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <label class="font-bold text-slate-900 flex items-center gap-2 text-sm">
            <span class="w-6 h-6 rounded-full bg-pink-600 text-white flex items-center justify-center text-xs">3</span>
            เลือกวันและรอบเวลาให้บริการ:
          </label>

          <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
              <label class="block text-xs font-semibold text-slate-600 mb-1">วันที่ต้องการรับบริการ *</label>
              <input type="date" id="form-date" required
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div class="sm:col-span-7">
              <label class="block text-xs font-semibold text-slate-600 mb-1">รอบเวลา *</label>
              <div class="grid grid-cols-2 sm:grid-cols-4 gap-2">
                <label class="flex items-center justify-center p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold cursor-pointer has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:text-pink-700">
                  <input type="radio" name="form-slot" value="09:00 น." checked class="sr-only">
                  <span>09:00</span>
                </label>
                <label class="flex items-center justify-center p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold cursor-pointer has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:text-pink-700">
                  <input type="radio" name="form-slot" value="12:00 น." class="sr-only">
                  <span>12:00</span>
                </label>
                <label class="flex items-center justify-center p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold cursor-pointer has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:text-pink-700">
                  <input type="radio" name="form-slot" value="15:00 น." class="sr-only">
                  <span>15:00</span>
                </label>
                <label class="flex items-center justify-center p-2.5 bg-slate-50 border border-slate-300 rounded-xl text-xs font-semibold cursor-pointer has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:text-pink-700">
                  <input type="radio" name="form-slot" value="16:00 น." class="sr-only">
                  <span>16:00</span>
                </label>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 4: Add-ons -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <label class="font-bold text-slate-900 flex items-center gap-2 text-sm">
            <span class="w-6 h-6 rounded-full bg-pink-600 text-white flex items-center justify-center text-xs">4</span>
            บริการเสริมเพิ่มเติม (เลือกได้มากกว่า 1 ข้อ):
          </label>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <label class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-pink-50/40 transition-colors">
              <input type="checkbox" id="addon-balcony" onchange="calculateSummary()" class="rounded text-pink-600 focus:ring-pink-500 w-4 h-4 mt-0.5">
              <div>
                <span class="text-xs font-bold text-slate-800 block">ขัดล้างระเบียง + ทำความสะอาดพัดลม</span>
                <span class="text-[11px] text-slate-500">+100 บาท (ขัดคราบฝุ่น นกพิราบ ล้างตะแกรง)</span>
              </div>
            </label>

            <label class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-pink-50/40 transition-colors">
              <input type="checkbox" id="addon-ozone" onchange="calculateSummary()" class="rounded text-pink-600 focus:ring-pink-500 w-4 h-4 mt-0.5">
              <div>
                <span class="text-xs font-bold text-slate-800 block">อบโอโซนฆ่าเชื้อ ดับกลิ่นอับห้อง</span>
                <span class="text-[11px] text-slate-500">+150 บาท (กำจัดกลิ่นบุหรี่ สัตว์เลี้ยง เชื้อรา)</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Step 5: Contact Details -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <label class="font-bold text-slate-900 flex items-center gap-2 text-sm">
            <span class="w-6 h-6 rounded-full bg-pink-600 text-white flex items-center justify-center text-xs">5</span>
            ข้อมูลผู้ติดต่อ:
          </label>

          <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">ชื่อผู้จอง / ชื่อเล่น *</label>
              <input type="text" id="form-cust-name" required placeholder="เช่น สมชาย ใจดี"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">เบอร์โทรศัพท์ติดต่อ *</label>
              <input type="tel" id="form-cust-phone" required placeholder="เช่น 081-234-5678"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">Line ID (สำหรับส่งรูปหน้างาน)</label>
              <input type="text" id="form-cust-line" placeholder="เช่น somchai_msu"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div class="sm:col-span-3">
              <label class="block text-xs font-semibold text-slate-600 mb-1">หมายเหตุเพิ่มเติมถึงแม่บ้าน</label>
              <input type="text" id="form-notes" placeholder="เช่น มีแมวในห้อง 1 ตัว, ขอเน้นขัดคราบห้องน้ำ, นัดรับกุญแจที่นิติ"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
          </div>
        </div>

        <!-- Summary & Coupon Box -->
        <div class="bg-gradient-to-r from-pink-500/10 via-rose-50 to-white p-5 rounded-2xl border border-pink-200 space-y-3">
          <div class="flex items-center gap-2">
            <input type="text" id="coupon-code-input" placeholder="โค้ดส่วนลด (ทดลอง: STUDENT50)"
              class="flex-1 text-xs p-2.5 bg-white border border-pink-300 rounded-xl uppercase font-semibold outline-none">
            <button type="button" onclick="applyDiscount()"
              class="bg-pink-600 hover:bg-pink-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all cursor-pointer">
              ใช้ส่วนลด
            </button>
          </div>
          <p id="coupon-msg" class="hidden text-xs font-semibold"></p>

          <div class="border-t border-pink-200/80 pt-3 space-y-1.5 text-xs text-slate-600">
            <div class="flex justify-between">
              <span id="summary-pkg-name">แพ็กเกจ: Standard Clean (รายครั้ง)</span>
              <span id="summary-pkg-price" class="font-bold text-slate-800">350 ฿</span>
            </div>
            <div class="flex justify-between text-slate-500">
              <span>บริการเสริม</span>
              <span id="summary-addon-price">+0 ฿</span>
            </div>
            <div class="flex justify-between text-emerald-600 font-medium">
              <span>ส่วนลดนิสิต</span>
              <span id="summary-discount-price">-0 ฿</span>
            </div>
            <div class="flex justify-between items-center text-sm font-extrabold text-slate-900 border-t border-pink-200/80 pt-2.5">
              <span class="text-pink-700 text-sm sm:text-base">ยอดชำระสุทธิ (ชำระเมื่อตรวจรับงาน):</span>
              <span id="summary-total-price" class="text-2xl text-pink-600 font-extrabold">350 ฿</span>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit"
            class="w-full bg-gradient-to-r from-pink-600 via-rose-600 to-pink-500 hover:from-pink-700 hover:to-rose-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-pink-500/20 transition-all flex items-center justify-center gap-2 text-sm sm:text-base cursor-pointer">
            <i class="fa-solid fa-calendar-check"></i> ยืนยันข้อมูลและจองคิวแม่บ้าน
          </button>
          <div class="flex items-center justify-center gap-4 text-[11px] text-slate-400 mt-3">
            <span>🔒 ปลอดภัย ไม่ต้องจ่ายมัดจำล่วงหน้า</span>
            <span>•</span>
            <span>📱 เจ้าหน้าที่โทรยืนยันคิวภายใน 15 นาที</span>
          </div>
        </div>

      </form>
    </div>
  </main>

  <!-- ==================== BOOKING SUCCESS MODAL ==================== -->
  <div id="success-modal"
    class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
    <div
      class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-pink-200 text-center space-y-4 my-auto">
      <div
        class="w-16 h-16 rounded-3xl bg-emerald-100 text-emerald-600 mx-auto flex items-center justify-center text-3xl">
        <i class="fa-solid fa-circle-check"></i>
      </div>

      <div>
        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">บันทึกการจองแม่บ้านสำเร็จ!</span>
        <h3 class="text-lg font-extrabold text-slate-900 mt-2">ขอบคุณที่เลือกใช้บริการ</h3>
        <p class="text-xs text-slate-500">รหัสการจอง: <strong id="res-booking-id" class="text-pink-600">MD-000000</strong></p>
      </div>

      <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs text-left space-y-2">
        <p><strong>แพ็กเกจ:</strong> <span id="res-pkg">-</span></p>
        <p><strong>หอพัก/ห้อง:</strong> <span id="res-loc">-</span></p>
        <p><strong>วันและรอบเวลา:</strong> <span id="res-time">-</span></p>
        <p><strong>ผู้จอง:</strong> <span id="res-cust">-</span></p>
        <div class="border-t border-slate-200 pt-2 flex justify-between items-center font-bold">
          <span>ยอดชำระสุทธิ:</span>
          <span id="res-total" class="text-base text-pink-600">0 ฿</span>
        </div>
      </div>

      <div class="flex items-center gap-2 pt-2">
        <button onclick="closeSuccessModal(); openMyBookingsModal();"
          class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-xl text-xs transition-colors cursor-pointer">
          <i class="fa-solid fa-receipt mr-1 text-amber-400"></i> ดูรายการจองทั้งหมด
        </button>
        <a href="index.php"
          class="bg-pink-50 hover:bg-pink-100 text-pink-700 font-semibold px-4 py-2.5 rounded-xl text-xs transition-colors cursor-pointer">
          กลับหน้าหลัก
        </a>
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
          <div class="w-9 h-9 rounded-xl bg-pink-600 flex items-center justify-center text-base">
            <i class="fa-solid fa-receipt"></i>
          </div>
          <div>
            <h3 class="font-bold text-base">รายการจองบริการของฉัน</h3>
            <p class="text-[11px] text-slate-400">ประวัติการจองทั้งหมดที่บันทึกไว้ในอุปกรณ์ของคุณ</p>
          </div>
        </div>
        <button onclick="closeMyBookingsModal()" class="text-slate-400 hover:text-white text-xl p-1.5 rounded-lg">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div id="bookings-list" class="p-5 overflow-y-auto space-y-3 flex-1 bg-slate-50">
        <!-- Rendered by JS -->
      </div>

      <div class="p-4 bg-white border-t border-slate-200 flex justify-end">
        <button onclick="closeMyBookingsModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl text-xs font-semibold">
          ปิดหน้าต่าง
        </button>
      </div>
    </div>
  </div>

  <!-- ==================== FOOTER ==================== -->
  <footer class="bg-slate-900 text-slate-400 text-xs py-8 border-t border-slate-800 mt-12">
    <div class="max-w-7xl mx-auto px-4 text-center space-y-3">
      <div class="flex flex-wrap justify-center gap-4 text-slate-300 font-medium">
        <a href="index.php" class="hover:text-white">รายการหอพัก</a> •
        <a href="maid-service.php" class="hover:text-white text-pink-400">จองแม่บ้าน</a> •
        <a href="compare.php" class="hover:text-white">ตารางเปรียบเทียบหอพัก</a>
      </div>
      <p class="font-semibold text-slate-300">JingJai - บริการแม่บ้านทำความสะอาดหอพักรอบมหาวิทยาลัย</p>
      <p class="text-slate-500">ให้บริการครอบคลุมทุกโซนรอบ ม. มหาสารคาม (มมส.), ขามเรียง, ท่าขอนยาง, ซอยวุ่นวาย, มอเก่า</p>
    </div>
  </footer>

  <!-- ==================== PAGE SCRIPTS ==================== -->
  <script>
    // State
    let currentPackage = {
      id: 'general',
      name: 'Standard Clean (รายครั้ง)',
      price: 350
    };
    let discountAmount = 0;

    // Set Default Date to Tomorrow
    document.addEventListener('DOMContentLoaded', () => {
      const tomorrow = new Date();
      tomorrow.setDate(tomorrow.getDate() + 1);
      const dateInput = document.getElementById('form-date');
      if (dateInput) {
        dateInput.value = tomorrow.toISOString().split('T')[0];
        dateInput.min = new Date().toISOString().split('T')[0];
      }

      // Read Dorm query param if provided (e.g. maid-service.html?dorm=หอพักเดอะปาล์ม)
      const urlParams = new URLSearchParams(window.location.search);
      const dormParam = urlParams.get('dorm');
      if (dormParam) {
        const dormSelect = document.getElementById('form-dorm-select');
        let matched = false;
        for (let opt of dormSelect.options) {
          if (opt.value && opt.value.includes(dormParam)) {
            opt.selected = true;
            matched = true;
            break;
          }
        }
        if (!matched) {
          dormSelect.value = 'other';
          document.getElementById('form-dorm-custom').value = dormParam;
        }
      }

      updateBadge();
      calculateSummary();
    });

    // Package Selector
    function selectPackage(id, price, name) {
      currentPackage = { id, price, name };
      document.querySelectorAll('.pkg-card').forEach(el => {
        el.classList.remove('border-pink-500', 'bg-pink-50/50', 'border-2');
        el.classList.add('border-slate-200', 'bg-white', 'border');
      });
      const selected = document.querySelector(`[data-pkg="${id}"]`);
      if (selected) {
        selected.classList.remove('border-slate-200', 'bg-white', 'border');
        selected.classList.add('border-pink-500', 'bg-pink-50/50', 'border-2');
      }
      calculateSummary();
    }

    // Dorm select change helper
    function handleDormChange() {
      const val = document.getElementById('form-dorm-select').value;
      const customInput = document.getElementById('form-dorm-custom');
      if (val === 'other') {
        customInput.focus();
      }
    }

    // Dynamic Price Calculation
    function calculateSummary() {
      let addonTotal = 0;
      if (document.getElementById('addon-balcony').checked) addonTotal += 100;
      if (document.getElementById('addon-ozone').checked) addonTotal += 150;

      const base = currentPackage.price;
      const total = Math.max(0, base + addonTotal - discountAmount);

      document.getElementById('summary-pkg-name').textContent = `แพ็กเกจ: ${currentPackage.name}`;
      document.getElementById('summary-pkg-price').textContent = `${base} ฿`;
      document.getElementById('summary-addon-price').textContent = `+${addonTotal} ฿`;
      document.getElementById('summary-discount-price').textContent = `-${discountAmount} ฿`;
      document.getElementById('summary-total-price').textContent = `${total} ฿`;

      return { base, addonTotal, total };
    }

    // Coupon Code
    function applyDiscount() {
      const code = document.getElementById('coupon-code-input').value.trim().toUpperCase();
      const msg = document.getElementById('coupon-msg');
      msg.classList.remove('hidden', 'text-emerald-600', 'text-rose-500');

      if (code === 'STUDENT50' || code === 'MSU50' || code === 'JINGJAI') {
        discountAmount = 50;
        msg.classList.add('text-emerald-600');
        msg.textContent = '🎉 ใช้โค้ดส่วนลดสำเร็จ! ลด 50 บาท';
      } else if (code === '') {
        discountAmount = 0;
        msg.classList.add('text-rose-500');
        msg.textContent = 'กรุณากรอกโค้ดส่วนลด';
      } else {
        discountAmount = 0;
        msg.classList.add('text-rose-500');
        msg.textContent = '❌ โค้ดส่วนลดไม่ถูกต้องหรือหมดอายุแล้ว';
      }
      calculateSummary();
    }

    // Handle Form Submit
    function handleMaidBookingSubmit(e) {
      e.preventDefault();

      const selectDorm = document.getElementById('form-dorm-select').value;
      const customDorm = document.getElementById('form-dorm-custom').value.trim();
      const roomNo = document.getElementById('form-room-no').value.trim();

      let dormName = selectDorm;
      if (!dormName || dormName === 'other') {
        dormName = customDorm || 'ไม่ระบุชื่อหอพัก';
      }

      const slot = document.querySelector('input[name="form-slot"]:checked').value;
      const date = document.getElementById('form-date').value;
      const custName = document.getElementById('form-cust-name').value.trim();
      const phone = document.getElementById('form-cust-phone').value.trim();
      const line = document.getElementById('form-cust-line').value.trim();
      const notes = document.getElementById('form-notes').value.trim();

      const { total } = calculateSummary();
      const bookingId = 'MD-' + Math.floor(100000 + Math.random() * 900000);

      const bookingRecord = {
        id: bookingId,
        type: 'maid',
        packageName: currentPackage.name,
        dorm: dormName,
        room: roomNo,
        date: date,
        slot: slot,
        customerName: custName,
        phone: phone,
        line: line,
        notes: notes,
        totalPrice: total,
        createdAt: new Date().toISOString()
      };

      // Save to localStorage
      try {
        const currentList = JSON.parse(localStorage.getItem('jingjai_bookings') || '[]');
        currentList.unshift(bookingRecord);
        localStorage.setItem('jingjai_bookings', JSON.stringify(currentList));
      } catch (err) {
        console.error('Storage error:', err);
      }

      // Populate Success Modal
      document.getElementById('res-booking-id').textContent = bookingId;
      document.getElementById('res-pkg').textContent = currentPackage.name;
      document.getElementById('res-loc').textContent = `${dormName} (ห้อง ${roomNo})`;
      document.getElementById('res-time').textContent = `${date} | รอบ ${slot}`;
      document.getElementById('res-cust').textContent = `${custName} (${phone})`;
      document.getElementById('res-total').textContent = `${total} ฿`;

      document.getElementById('success-modal').classList.remove('hidden');
      updateBadge();
    }

    function closeSuccessModal() {
      document.getElementById('success-modal').classList.add('hidden');
    }

    // Modal My Bookings
    function openMyBookingsModal() {
      renderBookingsList();
      document.getElementById('my-bookings-modal').classList.remove('hidden');
    }

    function closeMyBookingsModal() {
      document.getElementById('my-bookings-modal').classList.add('hidden');
    }

    function renderBookingsList() {
      const container = document.getElementById('bookings-list');
      const list = JSON.parse(localStorage.getItem('jingjai_bookings') || '[]');

      if (list.length === 0) {
        container.innerHTML = `
          <div class="text-center py-8 text-slate-400 space-y-2">
            <i class="fa-regular fa-folder-open text-3xl"></i>
            <p class="text-xs">ยังไม่มีรายการจองบริการในขณะนี้</p>
          </div>
        `;
        return;
      }

      container.innerHTML = list.map(item => `
        <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs space-y-2">
          <div class="flex items-center justify-between border-b border-slate-100 pb-2">
            <div class="flex items-center gap-2">
              <span class="w-6 h-6 rounded-lg bg-pink-100 text-pink-600 flex items-center justify-center text-xs">
                <i class="fa-solid fa-broom"></i>
              </span>
              <span class="font-bold text-xs text-slate-800">${item.packageName}</span>
            </div>
            <span class="text-[11px] font-bold text-pink-600">${item.totalPrice} ฿</span>
          </div>
          <div class="text-[11px] text-slate-600 space-y-1">
            <p><i class="fa-solid fa-building text-slate-400 mr-1"></i> ${item.dorm} (ห้อง ${item.room || '-'})</p>
            <p><i class="fa-regular fa-clock text-slate-400 mr-1"></i> วันที่ ${item.date} (${item.slot})</p>
            <p><i class="fa-regular fa-user text-slate-400 mr-1"></i> ผู้จอง: ${item.customerName} (${item.phone})</p>
          </div>
          <div class="text-[10px] text-slate-400 text-right">รหัส: ${item.id}</div>
        </div>
      `).join('');
    }

    function updateBadge() {
      const list = JSON.parse(localStorage.getItem('jingjai_bookings') || '[]');
      const badge = document.getElementById('header-booking-badge');
      if (badge) {
        if (list.length > 0) {
          badge.textContent = list.length;
          badge.classList.remove('hidden');
        } else {
          badge.classList.add('hidden');
        }
      }
    }
  </script>

</body>
</html>