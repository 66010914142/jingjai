<!DOCTYPE html>
<html lang="th" class="scroll-smooth">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>คำนวณค่าใช้จ่ายรายเดือน | JingJai</title>
  <meta name="description"
    content="เครื่องมือประเมินค่าน้ำ ค่าไฟ ค่าเดินทาง และค่าเช่าหอพักรายเดือนสำหรับนิสิตนักศึกษา">

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
          <button onclick="openMaidServiceModal()"
            class="px-3.5 py-1.5 rounded-lg text-sm font-semibold transition-all text-pink-700 hover:bg-pink-100 hover:text-pink-800 flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-broom text-pink-500"></i> จองแม่บ้าน
          </button>
          <!-- Moving Service Button -->
          <button onclick="openMovingServiceModal()"
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
            <i class="fa-solid fa-arrow-left"></i> กลับหน้ารายการ
          </a>
        </div>
      </div>
    </div>
  </header>


  <!-- ==================== CALCULATOR PAGE CONTENT ==================== -->
  <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 space-y-6">

    <!-- Page Header -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-2">
      <span class="bg-emerald-100 text-emerald-800 text-xs font-bold px-3 py-0.5 rounded-full">Monthly Expense
        Estimator</span>
      <h1 class="text-2xl font-extrabold text-slate-900 flex items-center gap-2">
        <i class="fa-solid fa-calculator text-emerald-600"></i> เครื่องมือประเมินค่าใช้จ่ายรวมรายเดือน
      </h1>
      <p class="text-xs text-slate-500">คำนวณงบประมาณสุทธิต่อเดือนโดยคำนวณจาก ค่าเช่าห้อง + ค่าน้ำจริง +
        ค่าไฟเปิดแอร์จริง + ค่าเดินทางไปเรียน</p>
    </div>

    <!-- Calculator Card -->
    <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-lg space-y-6">

      <!-- Select Dorm -->
      <div>
        <label class="block font-bold text-slate-800 text-sm mb-1.5">1. เลือกหอพักที่ต้องการประเมิน:</label>
        <select id="calc-dorm-select"
          class="w-full p-3.5 rounded-2xl border border-slate-300 text-sm font-semibold text-slate-800 focus:ring-2 focus:ring-brand-500">
          <!-- Populated by JS -->
        </select>
      </div>

      <!-- Utilities inputs -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
          <label class="block font-bold text-slate-700 text-xs">💧 หน่วยค่าน้ำ (ยูนิต/เดือน)</label>
          <input type="number" id="calc-water-units" value="5" min="0" oninput="calculateMonthlyExpense()"
            class="w-full p-2.5 bg-white rounded-xl border border-slate-300 text-sm font-bold text-slate-800">
          <p class="text-[11px] text-slate-500">อัตราหอนี้: <span id="calc-water-rate-display"
              class="font-bold text-slate-700">0</span> ฿/ยูนิต</p>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
          <label class="block font-bold text-slate-700 text-xs">⚡ หน่วยค่าไฟ (ยูนิต/เดือน)</label>
          <input type="number" id="calc-electric-units" value="120" min="0" oninput="calculateMonthlyExpense()"
            class="w-full p-2.5 bg-white rounded-xl border border-slate-300 text-sm font-bold text-slate-800">
          <p class="text-[11px] text-slate-500">อัตราหอนี้: <span id="calc-electric-rate-display"
              class="font-bold text-slate-700">0</span> ฿/ยูนิต (เปิดแอร์ ~4-6 ชม./วัน)</p>
        </div>

        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200 space-y-2">
          <label class="block font-bold text-slate-700 text-xs">🛵 ค่าน้ำมัน/เดินทาง (บาท/เดือน)</label>
          <input type="number" id="calc-travel-cost" value="300" min="0" oninput="calculateMonthlyExpense()"
            class="w-full p-2.5 bg-white rounded-xl border border-slate-300 text-sm font-bold text-slate-800">
          <p class="text-[11px] text-slate-500">ระยะทางใกล้-ไกลตามพิกัดจริง</p>
        </div>

      </div>

      <!-- Result Card -->
      <div class="bg-slate-900 text-white p-6 rounded-3xl space-y-3 shadow-xl">
        <h3 class="font-bold text-base text-slate-200 border-b border-slate-800 pb-2 flex items-center gap-2">
          <i class="fa-solid fa-receipt text-amber-400"></i> สรุปค่าใช้จ่ายสุทธิโดยประมาณ
        </h3>
        <div class="space-y-2 text-xs sm:text-sm">
          <div class="flex justify-between text-slate-300">
            <span>🏠 ค่าเช่าห้องพัก:</span>
            <span id="calc-rent-sum" class="font-bold text-white">0 บาท</span>
          </div>
          <div class="flex justify-between text-slate-300">
            <span>💧 ค่าน้ำประปาประมาณการ:</span>
            <span id="calc-water-sum" class="font-bold text-white">0 บาท</span>
          </div>
          <div class="flex justify-between text-slate-300">
            <span>⚡ ค่าไฟฟ้าประมาณการ:</span>
            <span id="calc-electric-sum" class="font-bold text-white">0 บาท</span>
          </div>
          <div class="flex justify-between text-slate-300">
            <span>🛵 ค่าเดินทางไป-กลับ ม.:</span>
            <span id="calc-travel-sum" class="font-bold text-white">0 บาท</span>
          </div>
          <div class="border-t border-slate-700 pt-3 flex flex-col sm:flex-row justify-between sm:items-center gap-1">
            <span class="font-bold text-amber-400 text-sm">💰 ค่าใช้จ่ายรวมประมาณการต่อเดือน:</span>
            <span id="calc-total-sum" class="text-2xl font-extrabold text-emerald-400">0 บาท/เดือน</span>
          </div>
        </div>
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

      <form onsubmit="submitMaidBooking(event)"
        class="p-5 sm:p-6 overflow-y-auto space-y-5 flex-1 bg-slate-50 text-xs sm:text-sm">
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

        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-pink-600 text-white flex items-center justify-center text-[10px]">2</span>
            ระบุหอพัก และหมายเลขห้อง:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
            <div class="sm:col-span-8">
              <select id="maid-dorm-select"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none"></select>
            </div>
            <div class="sm:col-span-4">
              <input type="text" id="maid-room-no" placeholder="เลขห้องพัก"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
            <div class="sm:col-span-12">
              <input type="text" id="maid-custom-dorm" placeholder="หรือพิมพ์ระบุชื่อหอพัก / ซอย / ที่อยู่ละเอียด"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl focus:ring-2 focus:ring-pink-500 outline-none">
            </div>
          </div>
        </div>

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
                <span>09:00-12:00</span>
              </label>
              <label
                class="flex-1 flex items-center justify-center gap-1.5 p-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold cursor-pointer has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:text-pink-700">
                <input type="radio" name="maid-timeslot" value="13:00 - 16:00 น." class="text-pink-600">
                <span>13:00-16:00</span>
              </label>
              <label
                class="flex-1 flex items-center justify-center gap-1.5 p-2 bg-white border border-slate-300 rounded-xl text-xs font-semibold cursor-pointer has-[:checked]:bg-pink-50 has-[:checked]:border-pink-500 has-[:checked]:text-pink-700">
                <input type="radio" name="maid-timeslot" value="16:30 - 19:30 น." class="text-pink-600">
                <span>16:30-19:30</span>
              </label>
            </div>
          </div>
        </div>

        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 text-xs">บริการเสริมเพิ่มเติม (Add-ons):</label>
          <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
            <label
              class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" id="maid-addon-balcony" onchange="toggleMaidAddon('balcony')"
                class="rounded text-pink-600">
              <span>🧹 ขัดระเบียง + ล้างพัดลม (+100฿)</span>
            </label>
            <label
              class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer">
              <input type="checkbox" id="maid-addon-ozone" onchange="toggleMaidAddon('ozone')"
                class="rounded text-pink-600">
              <span>💨 ฆ่าเชื้อโอโซนกำจัดกลิ่นห้อง (+150฿)</span>
            </label>
          </div>
        </div>

        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-pink-600 text-white flex items-center justify-center text-[10px]">4</span>
            ข้อมูลผู้จอง & เบอร์ติดต่อ:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
            <div>
              <input type="text" id="maid-cust-name" required placeholder="ชื่อ-นามสกุล *"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
            </div>
            <div>
              <input type="tel" id="maid-cust-phone" required placeholder="เบอร์โทรศัพท์ *"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
            </div>
            <div>
              <input type="text" id="maid-cust-line" placeholder="Line ID"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
            </div>
            <div class="sm:col-span-3">
              <input type="text" id="maid-notes" placeholder="หมายเหตุเพิ่มเติม"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
            </div>
          </div>
        </div>

        <div
          class="bg-gradient-to-r from-pink-500/10 via-rose-50 to-white p-4 rounded-2xl border border-pink-200 space-y-2">
          <div class="flex items-center gap-2">
            <input type="text" id="maid-promo-input" placeholder="โค้ดส่วนลด (เช่น STUDENT50)"
              class="flex-1 text-xs p-2 bg-white border border-pink-300 rounded-xl uppercase font-semibold">
            <button type="button" onclick="applyMaidDiscount()"
              class="bg-pink-600 text-white text-xs font-bold px-4 py-2 rounded-xl">ใช้โค้ด</button>
          </div>
          <p id="maid-promo-msg" class="hidden text-xs"></p>
          <div
            class="border-t border-pink-200/80 pt-2 flex justify-between items-center text-sm font-extrabold text-slate-900">
            <span class="text-pink-700">ยอดรวมทั้งสิ้น (ชำระหลังเสร็จงาน)</span>
            <span id="maid-calc-total-price" class="text-xl text-pink-600">350 ฿</span>
          </div>
        </div>

        <button type="submit"
          class="w-full bg-gradient-to-r from-pink-600 to-rose-600 text-white font-bold py-3.5 rounded-2xl shadow-md cursor-pointer flex items-center justify-center gap-2">
          <i class="fa-solid fa-broom"></i> ยืนยันการจองแม่บ้านทำความสะอาด
        </button>
      </form>
    </div>
  </div>

  <!-- ==================== MOVING SERVICE BOOKING MODAL ==================== -->
  <div id="moving-service-modal"
    class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
    <div
      class="bg-white rounded-3xl max-w-2xl w-full max-h-[92vh] flex flex-col shadow-2xl border border-amber-200 overflow-hidden my-auto animate-in fade-in zoom-in duration-200">
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
          class="text-white/80 hover:text-white text-2xl p-2 rounded-xl cursor-pointer">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form onsubmit="submitMovingBooking(event)"
        class="p-5 sm:p-6 overflow-y-auto space-y-5 flex-1 bg-slate-50 text-xs sm:text-sm">
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
              <p class="text-[11px] text-slate-500">เหมาะกับของน้อย 4-5 กล่อง ย้ายระยะใกล้</p>
            </div>
            <div onclick="selectMovingVehicle('truck4w')" data-vehicle="truck4w"
              class="moving-v-card p-3 rounded-2xl border border-slate-200 bg-white hover:border-amber-300 transition-all cursor-pointer shadow-2xs space-y-1">
              <div class="flex items-center justify-between">
                <span class="font-bold text-slate-900 text-xs">🚛 รถ 4 ล้อใหญ่จัมโบ้</span>
                <span class="text-amber-700 font-extrabold text-xs">800 ฿</span>
              </div>
              <p class="text-[11px] text-slate-500">พื้นที่กว้าง จุของได้ 2 เท่า ย้ายพร้อมรูมเมท</p>
            </div>
          </div>
        </div>

        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-amber-600 text-white flex items-center justify-center text-[10px]">2</span>
            ระบุเส้นทางต้นทาง ➔ ปลายทาง:
          </label>
          <div class="space-y-2">
            <input type="text" id="moving-origin-input" required placeholder="จุดรับของต้นทาง (เช่น หอเดิม)..."
              class="w-full p-2.5 text-xs bg-white border border-slate-300 rounded-xl outline-none">
            <div class="grid grid-cols-1 sm:grid-cols-12 gap-2">
              <div class="sm:col-span-6">
                <select id="moving-dest-dorm-select"
                  class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none"></select>
              </div>
              <div class="sm:col-span-6">
                <input type="text" id="moving-custom-dest" placeholder="หรือพิมพ์ระบุจุดส่งปลายทางเอง"
                  class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
              </div>
            </div>
          </div>
        </div>

        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-amber-600 text-white flex items-center justify-center text-[10px]">3</span>
            บริการคนช่วยยกของ (Helper):
          </label>
          <div class="flex flex-wrap items-center gap-2">
            <button type="button" onclick="selectMovingHelper(0)" data-level="0"
              class="moving-helper-pill flex-1 py-2 px-3 bg-white border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer">ไม่ใช้คนช่วยยก
              (0฿)</button>
            <button type="button" onclick="selectMovingHelper(1)" data-level="1"
              class="moving-helper-pill flex-1 py-2 px-3 bg-amber-600 text-white border border-amber-600 rounded-xl text-xs font-semibold cursor-pointer">คนขับช่วยยก
              1 คน (+150฿)</button>
            <button type="button" onclick="selectMovingHelper(2)" data-level="2"
              class="moving-helper-pill flex-1 py-2 px-3 bg-white border border-slate-200 rounded-xl text-xs font-semibold cursor-pointer">คนช่วยยก
              2 คน (+300฿)</button>
          </div>
          <label
            class="flex items-center gap-2 p-2.5 bg-white border border-slate-200 rounded-xl text-xs cursor-pointer hover:bg-slate-50 mt-2">
            <input type="checkbox" id="moving-addon-stairs" onchange="toggleMovingStairs()"
              class="rounded text-amber-600">
            <span>🏢 หอพักไม่มีลิฟต์ ต้องยกขึ้นบันไดชั้น 3 ขึ้นไป (+100฿)</span>
          </label>
        </div>

        <div class="space-y-2 pt-2 border-t border-slate-200">
          <label class="font-bold text-slate-800 flex items-center gap-1.5 text-xs">
            <span
              class="w-5 h-5 rounded-full bg-amber-600 text-white flex items-center justify-center text-[10px]">4</span>
            วันเวลา และข้อมูลผู้จอง:
          </label>
          <div class="grid grid-cols-1 sm:grid-cols-12 gap-2.5">
            <div class="sm:col-span-6">
              <input type="date" id="moving-date-input" required
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
            </div>
            <div class="sm:col-span-6">
              <input type="time" id="moving-time-input" value="10:00" required
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
            </div>
            <div class="sm:col-span-6">
              <input type="text" id="moving-cust-name" required placeholder="ชื่อผู้จอง *"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
            </div>
            <div class="sm:col-span-6">
              <input type="tel" id="moving-cust-phone" required placeholder="เบอร์โทรศัพท์ *"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
            </div>
            <div class="sm:col-span-12">
              <input type="text" id="moving-items-detail" placeholder="รายละเอียดสิ่งของเพิ่มเติม"
                class="w-full text-xs p-2.5 bg-white border border-slate-300 rounded-xl outline-none">
            </div>
          </div>
        </div>

        <div
          class="bg-gradient-to-r from-amber-500/10 via-orange-50 to-white p-4 rounded-2xl border border-amber-200 flex justify-between items-center text-sm font-extrabold text-slate-900">
          <span class="text-amber-800">ราคาประเมินเบื้องต้น (จ่ายคนขับเมื่อส่งถึง)</span>
          <span id="moving-calc-total-price" class="text-xl text-amber-700">600 ฿</span>
        </div>

        <button type="submit"
          class="w-full bg-gradient-to-r from-amber-600 to-orange-600 text-white font-bold py-3.5 rounded-2xl shadow-md cursor-pointer flex items-center justify-center gap-2">
          <i class="fa-solid fa-truck-moving"></i> ยืนยันการจองรถรับจ้างขนย้ายของ
        </button>
      </form>
    </div>
  </div>

  <!-- ==================== BOOKING SUCCESS MODAL ==================== -->
  <div id="service-success-modal"
    class="hidden fixed inset-0 z-50 bg-slate-950/80 backdrop-blur-md flex items-center justify-center p-4 overflow-y-auto">
    <div
      class="bg-white rounded-3xl max-w-md w-full p-6 shadow-2xl border border-emerald-200 text-center space-y-4 my-auto animate-in fade-in zoom-in duration-200">
      <div
        class="w-16 h-16 rounded-3xl bg-emerald-100 text-emerald-600 mx-auto flex items-center justify-center text-3xl">
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
          class="flex-1 bg-slate-900 hover:bg-slate-800 text-white font-semibold py-2.5 rounded-xl text-xs cursor-pointer">
          <i class="fa-solid fa-receipt mr-1"></i> ดูรายการจองของฉัน
        </button>
        <button onclick="closeSuccessModal()"
          class="bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-4 py-2.5 rounded-xl text-xs cursor-pointer">
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

      <div id="my-bookings-list-container" class="p-5 overflow-y-auto space-y-3 flex-1 bg-slate-50"></div>

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

  <script src="app.js"></script>
</body>

</html>