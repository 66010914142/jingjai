<!DOCTYPE html>
<html lang="th" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>จองรถรับจ้างขนย้ายของ & ย้ายหอพัก | JingJai</title>
  <meta name="description"
    content="บริการรถรับจ้างขนย้ายของ ย้ายหอพักนักศึกษา รถกระบะตู้ทึบ กระบะคอก มอเตอร์ไซค์พ่วงข้าง พร้อมคนช่วยยกของ ปลอดภัย ตรงเวลา">

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
              orange: '#f97316'
            }
          },
          fontFamily: {
            sans: ['Prompt', 'Kanit', 'sans-serif'],
            display: ['Outfit', 'Prompt', 'sans-serif']
          },
          boxShadow: {
            'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.07)',
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

<body class="bg-slate-50 text-slate-800 font-sans min-h-screen flex flex-col antialiased selection:bg-amber-500 selection:text-white">

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
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all text-pink-700 hover:bg-pink-100 hover:text-pink-800 flex items-center gap-1.5">
            <i class="fa-solid fa-broom text-pink-500"></i> จองแม่บ้าน
          </a>
          <a href="moving-service.php"
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all bg-white text-amber-700 shadow-xs flex items-center gap-1.5">
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
  <section class="bg-gradient-to-b from-amber-50/80 via-white to-slate-50 border-b border-amber-100/70 pt-10 pb-12">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-4">
      <span class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-semibold">
        <i class="fa-solid fa-truck-fast text-amber-600"></i> บริการรถรับจ้างย้ายหอพักรอบมหาวิทยาลัย ตรงเวลา ปลอดภัย
      </span>
      <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">
        จองรถรับจ้างขนย้ายของ & ย้ายหอพัก <br>
        <span class="bg-gradient-to-r from-amber-600 via-orange-600 to-rose-600 bg-clip-text text-transparent">
          มีคนช่วยยก ส่งถึงห้องพัก ไม่ต้องเหนื่อยเอง
        </span>
      </h1>
      <p class="text-xs sm:text-sm text-slate-600 max-w-2xl mx-auto">
        ขนตู้เย็น ที่นอน 5-6 ฟุต ลังเสื้อผ้า โต๊ะเก้าอี้ เลือกรถได้ตามขนาดของ พร้อมทีมงานคนช่วยยกของขึ้นตึก จ่ายหลังส่งของเสร็จ
      </p>

      <!-- Trust Badges -->
      <div class="pt-2 flex flex-wrap items-center justify-center gap-4 text-xs font-medium text-slate-600">
        <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-500"></i> คนขับมีใบขับขี่ถูกต้อง</div>
        <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-500"></i> มีผ้าใบ/ตู้ทึบกันฝน 100%</div>
        <div class="flex items-center gap-1.5"><i class="fa-solid fa-circle-check text-emerald-500"></i> ชำระเงินเมื่อส่งถึงปลายทาง</div>
      </div>
    </div>
  </section>

  <!-- ==================== MAIN BOOKING FORM SECTION ==================== -->
  <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 -mt-6">
    <div class="bg-white rounded-3xl border border-amber-100 shadow-xl overflow-hidden">

      <!-- Form Card Header -->
      <div class="bg-gradient-to-r from-amber-600 via-orange-500 to-amber-500 text-white p-6 flex items-center justify-between">
        <div class="flex items-center gap-3.5">
          <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-2xl border border-white/30 shadow-inner">
            <i class="fa-solid fa-truck-moving"></i>
          </div>
          <div>
            <h2 class="text-lg sm:text-xl font-bold">กรอกข้อมูลการจองรถขนย้าย</h2>
            <p class="text-xs text-amber-100 mt-0.5">เลือกรถ ระบุจุดรับ-จุดส่ง และบริการคนช่วยยกของ</p>
          </div>
        </div>
        <div class="text-right hidden sm:block">
          <span class="text-[11px] text-amber-200 block">เริ่มต้นเพียง</span>
          <span class="text-xl font-extrabold text-white">200 ฿</span>
        </div>
      </div>

      <!-- Main Form -->
      <form id="moving-booking-form" onsubmit="handleMovingBookingSubmit(event)" class="p-6 sm:p-8 space-y-6 bg-slate-50/50">

        <!-- Step 1: Vehicle Selection -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <div class="flex items-center justify-between">
            <label class="font-bold text-slate-900 flex items-center gap-2 text-sm">
              <span class="w-6 h-6 rounded-full bg-amber-600 text-white flex items-center justify-center text-xs">1</span>
              เลือกประเภทรถที่เหมาะสมกับของ:
            </label>
            <span class="text-[11px] text-slate-400 font-medium">* คลิกเลือก 1 ประเภท</span>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 gap-3" id="vehicle-grid">
            <!-- V1: กระบะตู้ทึบ (Default) -->
            <div onclick="selectVehicle('pickup_box', 450, 'กระบะตู้ทึบกันฝน')" data-v="pickup_box"
              class="v-card active-v p-4 rounded-2xl border-2 border-amber-500 bg-amber-50/50 hover:border-amber-500 transition-all cursor-pointer space-y-1.5">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-sm">🛻 กระบะตู้ทึบกันฝน (ยอดนิยม)</span>
                <span class="text-amber-700 font-extrabold text-sm">450 ฿</span>
              </div>
              <p class="text-xs text-slate-500">ปิดมิดชิด ของไม่เปียกฝน ใส่ที่นอน 5-6 ฟุต ตู้เย็น กล่องผ้าได้ครบ</p>
              <div class="text-[11px] text-amber-800 font-medium">ความจุ: ~3-4 ลูกบาศก์เมตร (เหมาะย้ายห้อง 1 คนเต็มห้อง)</div>
            </div>

            <!-- V2: กระบะคอก -->
            <div onclick="selectVehicle('pickup_open', 450, 'กระบะคอกสูง + ผ้าใบ')" data-v="pickup_open"
              class="v-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer space-y-1.5">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-sm">🚚 กระบะคอกสูง + ผ้าใบคลุม</span>
                <span class="text-amber-700 font-extrabold text-sm">450 ฿</span>
              </div>
              <p class="text-xs text-slate-500">ขนของทรงสูงได้ดี มีเชือกมัดแน่นหนาและผ้าใบกันแดด/ฝน</p>
              <div class="text-[11px] text-amber-800 font-medium">ความจุ: ใส่ต้นไม้ ตู้เสื้อผ้าทรงสูง หรือโครงเตียงได้ดี</div>
            </div>

            <!-- V3: มอเตอร์ไซค์พ่วงข้าง -->
            <div onclick="selectVehicle('sidecar', 200, 'มอเตอร์ไซค์พ่วงข้าง')" data-v="sidecar"
              class="v-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer space-y-1.5">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-sm">🛵 มอเตอร์ไซค์พ่วงข้าง</span>
                <span class="text-amber-700 font-extrabold text-sm">200 ฿</span>
              </div>
              <p class="text-xs text-slate-500">ประหยัดสุด เหมาะกับของน้อย 4-5 ลัง พัดลม ย้ายหอระยะใกล้ในซอยเดียวกัน</p>
              <div class="text-[11px] text-amber-800 font-medium">ความจุ: สัมภาระย่อย ไม่เกิน 150 กก. (ไม่มีเครื่องใช้ไฟฟ้าใหญ่)</div>
            </div>

            <!-- V4: รถ 4 ล้อใหญ่จัมโบ้ -->
            <div onclick="selectVehicle('truck4w', 800, 'รถ 4 ล้อใหญ่จัมโบ้')" data-v="truck4w"
              class="v-card p-4 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer space-y-1.5">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-sm">🚛 รถ 4 ล้อใหญ่จัมโบ้</span>
                <span class="text-amber-700 font-extrabold text-sm">800 ฿</span>
              </div>
              <p class="text-xs text-slate-500">หลังคาสูง จุของได้เป็น 2 เท่า เหมาะย้ายหอร่วมกัน 2 คนหรือของเยอะมาก</p>
              <div class="text-[11px] text-amber-800 font-medium">ความจุ: ~8 ลูกบาศก์เมตร ขนรอบเดียวหมดแน่นอน</div>
            </div>
          </div>
        </div>

        <!-- Step 2: Route (Origin & Destination) -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <label class="font-bold text-slate-900 flex items-center gap-2 text-sm">
            <span class="w-6 h-6 rounded-full bg-amber-600 text-white flex items-center justify-center text-xs">2</span>
            ระบุเส้นทางรับ-ส่ง (ต้นทาง ➔ ปลายทาง):
          </label>

          <div class="space-y-3">
            <!-- Origin -->
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">
                <i class="fa-solid fa-circle-dot text-emerald-600 mr-1"></i> จุดรับของต้นทาง *
              </label>
              <input type="text" id="route-origin" required
                placeholder="เช่น หอพักเดิม ห้อง 304, ซอยขามเรียง 4, บ้านพักอาจารย์..."
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>

            <!-- Destination -->
            <div>
              <label class="block text-xs font-semibold text-slate-600 mb-1">
                <i class="fa-solid fa-location-dot text-rose-500 mr-1"></i> จุดส่งของปลายทาง *
              </label>
              <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
                <div class="sm:col-span-6">
                  <select id="route-dest-select" onchange="handleDestSelectChange()"
                    class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
                    <option value="">-- เลือกหอพักปลายทางในระบบ --</option>
                    <option value="หอพักเดอะปาล์ม ขามเรียง">หอพักเดอะปาล์ม (ขามเรียง/มอใหม่)</option>
                    <option value="หอพักกรีนวิว ท่าขอนยาง">หอพักกรีนวิว (ท่าขอนยาง)</option>
                    <option value="หอพักสุขสบาย ซอยวุ่นวาย">หอพักสุขสบาย (ซอยวุ่นวาย)</option>
                    <option value="หอพักพรีเมี่ยมพาร์ค มอเก่า">หอพักพรีเมี่ยมพาร์ค (มอเก่า ในเมือง)</option>
                    <option value="custom">หอพัก/สถานที่อื่นๆ (พิมพ์ระบุเอง)</option>
                  </select>
                </div>
                <div class="sm:col-span-6">
                  <input type="text" id="route-dest-custom" placeholder="หรือพิมพ์ระบุปลายทางเอง (เช่น หอใหม่ ห้อง 501)"
                    class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Step 3: Helpers & Stairs -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <label class="font-bold text-slate-900 flex items-center gap-2 text-sm">
            <span class="w-6 h-6 rounded-full bg-amber-600 text-white flex items-center justify-center text-xs">3</span>
            บริการคนช่วยยกของ (Helper) & ชั้นบันได:
          </label>

          <div class="space-y-3">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2">
              <button type="button" onclick="selectHelper(0, 0)" id="helper-btn-0"
                class="helper-btn p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer text-center transition-all">
                <span class="block text-slate-800">ไม่ใช้คนช่วยยก</span>
                <span class="text-[11px] text-slate-500">(ยกเอง 0 ฿)</span>
              </button>
              <button type="button" onclick="selectHelper(1, 150)" id="helper-btn-1"
                class="helper-btn p-3 bg-amber-50 border-2 border-amber-500 rounded-xl text-xs font-semibold cursor-pointer text-center transition-all">
                <span class="block text-amber-900">คนขับช่วยยก 1 คน</span>
                <span class="text-[11px] text-amber-700">(+150 ฿ แนะนำ)</span>
              </button>
              <button type="button" onclick="selectHelper(2, 300)" id="helper-btn-2"
                class="helper-btn p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer text-center transition-all">
                <span class="block text-slate-800">ทีมงานยก 2 คน</span>
                <span class="text-[11px] text-slate-500">(+300 ฿ ไม่ต้องยกเอง)</span>
              </button>
            </div>

            <label class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-amber-50/40 transition-colors">
              <input type="checkbox" id="addon-stairs" onchange="calculateSummary()" class="rounded text-amber-600 focus:ring-amber-500 w-4 h-4 mt-0.5">
              <div>
                <span class="text-xs font-bold text-slate-800 block">หอพักไม่มีลิฟต์ ต้องยกขึ้นบันไดชั้น 3 ขึ้นไป (+100 ฿)</span>
                <span class="text-[11px] text-slate-500">มีสัมภาระหนัก เช่น ตู้เย็น ที่นอน แล้วต้องยกขึ้นบันไดตั้งแต่ชั้น 3 เป็นต้นไป</span>
              </div>
            </label>
          </div>
        </div>

        <!-- Step 4: Items Checkboxes -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <label class="font-bold text-slate-900 text-xs">
            สิ่งของหลักที่ต้องการขนย้าย (ช่วยให้คนขับเตรียมสายรัดและพื้นที่ให้พอดี):
          </label>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
            <label class="flex items-center gap-2 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-item" value="ตู้เย็น" checked class="rounded text-amber-600">
              <span>🧊 ตู้เย็น</span>
            </label>
            <label class="flex items-center gap-2 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-item" value="ที่นอน 5-6 ฟุต" checked class="rounded text-amber-600">
              <span>🛏️ ที่นอน 5-6 ฟุต</span>
            </label>
            <label class="flex items-center gap-2 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-item" value="โต๊ะ/เก้าอี้เกมมิ่ง" class="rounded text-amber-600">
              <span>🪑 โต๊ะ / เก้าอี้</span>
            </label>
            <label class="flex items-center gap-2 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-item" value="กล่องเสื้อผ้า/ของใช้" checked class="rounded text-amber-600">
              <span>📦 ลัง / กล่องของ</span>
            </label>
            <label class="flex items-center gap-2 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-item" value="พัดลม/ไมโครเวฟ" class="rounded text-amber-600">
              <span>🔌 เครื่องใช้ไฟฟ้า</span>
            </label>
            <label class="flex items-center gap-2 p-2 bg-slate-50 border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" name="moving-item" value="ราวตากผ้า/ชั้นวาง" class="rounded text-amber-600">
              <span>👗 ราวตากผ้า</span>
            </label>
          </div>
        </div>

        <!-- Step 5: Date, Time & Contact -->
        <div class="space-y-3 bg-white p-5 rounded-2xl border border-slate-200 shadow-2xs">
          <label class="font-bold text-slate-900 flex items-center gap-2 text-sm">
            <span class="w-6 h-6 rounded-full bg-amber-600 text-white flex items-center justify-center text-xs">4</span>
            วันเวลา และข้อมูลผู้จอง:
          </label>

          <div class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
              <label class="block text-xs font-semibold text-slate-600 mb-1">วันที่ขนย้าย *</label>
              <input type="date" id="form-date" required
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
            <div class="sm:col-span-6">
              <label class="block text-xs font-semibold text-slate-600 mb-1">เวลานัดหมาย *</label>
              <input type="time" id="form-time" value="10:00" required
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
            <div class="sm:col-span-6">
              <label class="block text-xs font-semibold text-slate-600 mb-1">ชื่อผู้จองรถ *</label>
              <input type="text" id="form-cust-name" required placeholder="เช่น ธนภัทร สุขสม"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
            <div class="sm:col-span-6">
              <label class="block text-xs font-semibold text-slate-600 mb-1">เบอร์โทรศัพท์ติดต่อ *</label>
              <input type="tel" id="form-cust-phone" required placeholder="เช่น 089-123-4567"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
            <div class="sm:col-span-12">
              <label class="block text-xs font-semibold text-slate-600 mb-1">รายละเอียดเพิ่มเติมถึงคนขับ</label>
              <input type="text" id="form-notes" placeholder="เช่น ซอยแคบเข้าได้เฉพาะกระบะ, นัดเจอกันที่ป้อมยามหน้าหอ"
                class="w-full text-xs p-2.5 bg-slate-50 border border-slate-300 rounded-xl focus:ring-2 focus:ring-amber-500 outline-none">
            </div>
          </div>
        </div>

        <!-- Summary & Coupon Box -->
        <div class="bg-gradient-to-r from-amber-500/10 via-orange-50 to-white p-5 rounded-2xl border border-amber-200 space-y-3">
          <div class="flex items-center gap-2">
            <input type="text" id="coupon-code-input" placeholder="โค้ดส่วนลด (ทดลอง: MOVE50)"
              class="flex-1 text-xs p-2.5 bg-white border border-amber-300 rounded-xl uppercase font-semibold outline-none">
            <button type="button" onclick="applyDiscount()"
              class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold px-4 py-2.5 rounded-xl transition-all cursor-pointer">
              ใช้ส่วนลด
            </button>
          </div>
          <p id="coupon-msg" class="hidden text-xs font-semibold"></p>

          <div class="border-t border-amber-200/80 pt-3 space-y-1.5 text-xs text-slate-600">
            <div class="flex justify-between">
              <span id="summary-v-name">ประเภทรถ: กระบะตู้ทึบกันฝน</span>
              <span id="summary-v-price" class="font-bold text-slate-800">450 ฿</span>
            </div>
            <div class="flex justify-between text-slate-500">
              <span id="summary-helper-label">คนขับช่วยยก 1 คน</span>
              <span id="summary-helper-price">+150 ฿</span>
            </div>
            <div class="flex justify-between text-slate-500">
              <span>ค่ายกขึ้นบันได (ไม่มีลิฟต์)</span>
              <span id="summary-stairs-price">0 ฿</span>
            </div>
            <div class="flex justify-between text-emerald-600 font-medium">
              <span>ส่วนลด</span>
              <span id="summary-discount-price">-0 ฿</span>
            </div>
            <div class="flex justify-between items-center text-sm font-extrabold text-slate-900 border-t border-amber-200/80 pt-2.5">
              <span class="text-amber-800 text-sm sm:text-base">ราคาประเมินเบื้องต้น (จ่ายคนขับเมื่อส่งถึง):</span>
              <span id="summary-total-price" class="text-2xl text-amber-700 font-extrabold">600 ฿</span>
            </div>
          </div>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit"
            class="w-full bg-gradient-to-r from-amber-600 via-orange-600 to-amber-500 hover:from-amber-700 hover:to-orange-700 text-white font-bold py-4 rounded-2xl shadow-lg shadow-amber-500/20 transition-all flex items-center justify-center gap-2 text-sm sm:text-base cursor-pointer">
            <i class="fa-solid fa-truck-moving"></i> ยืนยันการจองรถรับจ้างขนย้ายของ
          </button>
          <div class="flex items-center justify-center gap-4 text-[11px] text-slate-400 mt-3">
            <span>🔒 ไม่ต้องมัดจำ จ่ายเมื่อส่งถึงที่</span>
            <span>•</span>
            <span>📞 คนขับโทรคอนเฟิร์มล่วงหน้าก่อนออกเดินทาง</span>
          </div>
        </div>

      </form>
    </div>
  </main>

  <!-- ==================== BOOKING SUCCESS MODAL ==================== -->
  <div id="success-modal"
    class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
    <div
      class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-amber-200 text-center space-y-4 my-auto">
      <div
        class="w-16 h-16 rounded-3xl bg-emerald-100 text-emerald-600 mx-auto flex items-center justify-center text-3xl">
        <i class="fa-solid fa-circle-check"></i>
      </div>

      <div>
        <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">บันทึกการจองรถสำเร็จ!</span>
        <h3 class="text-lg font-extrabold text-slate-900 mt-2">รับจองคิวรถเรียบร้อย</h3>
        <p class="text-xs text-slate-500">รหัสการจอง: <strong id="res-booking-id" class="text-amber-700">MV-000000</strong></p>
      </div>

      <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 text-xs text-left space-y-2">
        <p><strong>ประเภทรถ:</strong> <span id="res-vehicle">-</span></p>
        <p><strong>เส้นทาง:</strong> <span id="res-route">-</span></p>
        <p><strong>วันและเวลา:</strong> <span id="res-time">-</span></p>
        <p><strong>ผู้จอง:</strong> <span id="res-cust">-</span></p>
        <div class="border-t border-slate-200 pt-2 flex justify-between items-center font-bold">
          <span>ยอดชำระโดยประมาณ:</span>
          <span id="res-total" class="text-base text-amber-700">0 ฿</span>
        </div>
      </div>

      <div class="flex items-center gap-2 pt-2">
        <button onclick="closeSuccessModal(); openMyBookingsModal();"
          class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-xl text-xs transition-colors cursor-pointer">
          <i class="fa-solid fa-receipt mr-1 text-amber-400"></i> ดูรายการจองของฉัน
        </button>
        <a href="index.php"
          class="bg-amber-50 hover:bg-amber-100 text-amber-800 font-semibold px-4 py-2.5 rounded-xl text-xs transition-colors cursor-pointer">
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
          <div class="w-9 h-9 rounded-xl bg-amber-600 flex items-center justify-center text-base">
            <i class="fa-solid fa-receipt"></i>
          </div>
          <div>
            <h3 class="font-bold text-base">รายการจองบริการของฉัน</h3>
            <p class="text-[11px] text-slate-400">ประวัติการจองทั้งหมด (ทั้งแม่บ้านและรถขนของ)</p>
          </div>
        </div>
        <button onclick="closeMyBookingsModal()" class="text-slate-400 hover:text-white text-xl p-1.5 rounded-lg">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <div id="bookings-list" class="p-5 overflow-y-auto space-y-3 flex-1 bg-slate-50">
        <!-- Rendered by JS -->
      </div>

      <div class="p-4 bg-white border-t border-slate-200 flex justify-between items-center text-xs">
        <div class="flex items-center gap-2">
          <a href="maid-service.php" class="text-pink-600 font-bold hover:underline">+ จองแม่บ้าน</a>
          <span>•</span>
          <a href="moving-service.php" class="text-amber-700 font-bold hover:underline">+ จองรถขนของ</a>
        </div>
        <button onclick="closeMyBookingsModal()" class="bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-xl font-semibold">
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
        <a href="maid-service.php" class="hover:text-white">จองแม่บ้าน</a> •
        <a href="moving-service.php" class="hover:text-white text-amber-400">จองรถขนของ</a> •
        <a href="compare.php" class="hover:text-white">ตารางเปรียบเทียบหอพัก</a>
      </div>
      <p class="font-semibold text-slate-300">JingJai - บริการรถรับจ้างขนย้ายของ & ย้ายหอพักรอบมหาวิทยาลัย</p>
      <p class="text-slate-500">ให้บริการครอบคลุมทุกโซนรอบ ม. มหาสารคาม (มมส.), ขามเรียง, ท่าขอนยาง, ซอยวุ่นวาย, มอเก่า</p>
    </div>
  </footer>

  <!-- ==================== PAGE SCRIPTS ==================== -->
  <script>
    // State
    let currentVehicle = {
      id: 'pickup_box',
      name: 'กระบะตู้ทึบกันฝน',
      price: 450
    };
    let currentHelper = {
      count: 1,
      price: 150,
      label: 'คนขับช่วยยก 1 คน'
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

      // Check query param for destination dorm (?dorm=...)
      const urlParams = new URLSearchParams(window.location.search);
      const dormParam = urlParams.get('dorm');
      if (dormParam) {
        const destSelect = document.getElementById('route-dest-select');
        let matched = false;
        for (let opt of destSelect.options) {
          if (opt.value && opt.value.includes(dormParam)) {
            opt.selected = true;
            matched = true;
            break;
          }
        }
        if (!matched) {
          destSelect.value = 'custom';
          document.getElementById('route-dest-custom').value = dormParam;
        }
      }

      updateBadge();
      calculateSummary();
    });

    // Select Vehicle
    function selectVehicle(id, price, name) {
      currentVehicle = { id, price, name };
      document.querySelectorAll('.v-card').forEach(el => {
        el.classList.remove('border-amber-500', 'bg-amber-50/50', 'border-2');
        el.classList.add('border-slate-200', 'bg-white', 'border');
      });
      const selected = document.querySelector(`[data-v="${id}"]`);
      if (selected) {
        selected.classList.remove('border-slate-200', 'bg-white', 'border');
        selected.classList.add('border-amber-500', 'bg-amber-50/50', 'border-2');
      }
      calculateSummary();
    }

    // Select Helper
    function selectHelper(count, price) {
      let label = 'ไม่ใช้คนช่วยยก';
      if (count === 1) label = 'คนขับช่วยยก 1 คน';
      if (count === 2) label = 'ทีมงานยก 2 คน';

      currentHelper = { count, price, label };

      for (let i = 0; i <= 2; i++) {
        const btn = document.getElementById(`helper-btn-${i}`);
        if (i === count) {
          btn.className = 'helper-btn p-3 bg-amber-50 border-2 border-amber-500 rounded-xl text-xs font-semibold cursor-pointer text-center transition-all';
        } else {
          btn.className = 'helper-btn p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer text-center transition-all';
        }
      }
      calculateSummary();
    }

    function handleDestSelectChange() {
      const val = document.getElementById('route-dest-select').value;
      const customInput = document.getElementById('route-dest-custom');
      if (val === 'custom') {
        customInput.focus();
      }
    }

    // Dynamic Price Calculation
    function calculateSummary() {
      let stairsPrice = 0;
      if (document.getElementById('addon-stairs').checked) stairsPrice = 100;

      const base = currentVehicle.price;
      const helper = currentHelper.price;
      const total = Math.max(0, base + helper + stairsPrice - discountAmount);

      document.getElementById('summary-v-name').textContent = `ประเภทรถ: ${currentVehicle.name}`;
      document.getElementById('summary-v-price').textContent = `${base} ฿`;
      document.getElementById('summary-helper-label').textContent = currentHelper.label;
      document.getElementById('summary-helper-price').textContent = helper > 0 ? `+${helper} ฿` : '0 ฿';
      document.getElementById('summary-stairs-price').textContent = stairsPrice > 0 ? `+${stairsPrice} ฿` : '0 ฿';
      document.getElementById('summary-discount-price').textContent = `-${discountAmount} ฿`;
      document.getElementById('summary-total-price').textContent = `${total} ฿`;

      return { base, helper, stairsPrice, total };
    }

    // Coupon Code
    function applyDiscount() {
      const code = document.getElementById('coupon-code-input').value.trim().toUpperCase();
      const msg = document.getElementById('coupon-msg');
      msg.classList.remove('hidden', 'text-emerald-600', 'text-rose-500');

      if (code === 'MOVE50' || code === 'STUDENT50' || code === 'JINGJAI') {
        discountAmount = 50;
        msg.classList.add('text-emerald-600');
        msg.textContent = '🎉 ใช้โค้ดสำเร็จ! ลด 50 บาท';
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

    // Form Submit
    function handleMovingBookingSubmit(e) {
      e.preventDefault();

      const origin = document.getElementById('route-origin').value.trim();
      const selectDest = document.getElementById('route-dest-select').value;
      const customDest = document.getElementById('route-dest-custom').value.trim();

      let destination = selectDest;
      if (!destination || destination === 'custom') {
        destination = customDest || 'ไม่ระบุปลายทาง';
      }

      // Checked items
      const checkedBoxes = document.querySelectorAll('input[name="moving-item"]:checked');
      const items = Array.from(checkedBoxes).map(cb => cb.value);

      const date = document.getElementById('form-date').value;
      const time = document.getElementById('form-time').value;
      const custName = document.getElementById('form-cust-name').value.trim();
      const phone = document.getElementById('form-cust-phone').value.trim();
      const notes = document.getElementById('form-notes').value.trim();

      const { total } = calculateSummary();
      const bookingId = 'MV-' + Math.floor(100000 + Math.random() * 900000);

      const bookingRecord = {
        id: bookingId,
        type: 'moving',
        packageName: currentVehicle.name,
        origin: origin,
        destination: destination,
        helper: currentHelper.label,
        items: items,
        date: date,
        time: time,
        customerName: custName,
        phone: phone,
        notes: notes,
        totalPrice: total,
        createdAt: new Date().toISOString()
      };

      // Save to shared localStorage (jingjai_bookings)
      try {
        const currentList = JSON.parse(localStorage.getItem('jingjai_bookings') || '[]');
        currentList.unshift(bookingRecord);
        localStorage.setItem('jingjai_bookings', JSON.stringify(currentList));
      } catch (err) {
        console.error('Storage error:', err);
      }

      // Populate Success Modal
      document.getElementById('res-booking-id').textContent = bookingId;
      document.getElementById('res-vehicle').textContent = currentVehicle.name;
      document.getElementById('res-route').textContent = `${origin} ➔ ${destination}`;
      document.getElementById('res-time').textContent = `${date} เวลา ${time} น.`;
      document.getElementById('res-cust').textContent = `${custName} (${phone})`;
      document.getElementById('res-total').textContent = `${total} ฿`;

      document.getElementById('success-modal').classList.remove('hidden');
      updateBadge();
    }

    function closeSuccessModal() {
      document.getElementById('success-modal').classList.add('hidden');
    }

    // Modal Bookings
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

      container.innerHTML = list.map(item => {
        const isMaid = item.type === 'maid';
        const icon = isMaid ? 'fa-broom' : 'fa-truck-moving';
        const color = isMaid ? 'pink' : 'amber';

        return `
          <div class="bg-white p-4 rounded-2xl border border-slate-200 shadow-2xs space-y-2">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2">
              <div class="flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-${color}-100 text-${color}-600 flex items-center justify-center text-xs">
                  <i class="fa-solid ${icon}"></i>
                </span>
                <span class="font-bold text-xs text-slate-800">${item.packageName}</span>
              </div>
              <span class="text-[11px] font-bold text-${color}-600">${item.totalPrice} ฿</span>
            </div>
            <div class="text-[11px] text-slate-600 space-y-1">
              ${isMaid 
                ? `<p><i class="fa-solid fa-building text-slate-400 mr-1"></i> ${item.dorm} (ห้อง ${item.room || '-'})</p>
                   <p><i class="fa-regular fa-clock text-slate-400 mr-1"></i> วันที่ ${item.date} (${item.slot})</p>`
                : `<p><i class="fa-solid fa-route text-slate-400 mr-1"></i> ${item.origin} ➔${item.destination}</p>
                   <p><i class="fa-regular fa-clock text-slate-400 mr-1"></i> วันที่ ${item.date} เวลา ${item.time} น. (${item.helper})</p>`
              }
              <p><i class="fa-regular fa-user text-slate-400 mr-1"></i> ผู้จอง: ${item.customerName} (${item.phone})</p>
            </div>
            <div class="text-[10px] text-slate-400 text-right">รหัส: ${item.id}</div>
          </div>
        `;
      }).join('');
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