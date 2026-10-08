<?php
session_start();

$demoUsers = [
    ['email' => '5530@msu.ac.th', 'password' => '123456', 'name' => 'Admin JingJai'],
    ['email' => 'student@msu.ac.th', 'password' => 'msu123', 'name' => 'นิสิต มมส.'],
    ['email' => 'guest@jingjai.com', 'password' => 'guest123', 'name' => 'Guest JingJai'],
];

$message = '';
$loginError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $matchedUser = null;

    foreach ($demoUsers as $user) {
        if (strcasecmp($user['email'], $email) === 0 && $user['password'] === $password) {
            $matchedUser = $user;
            break;
        }
    }

    if ($matchedUser) {
        $_SESSION['user'] = [
            'email' => $matchedUser['email'],
            'name' => $matchedUser['name'],
        ];

        setcookie('jingjai_logged_in', 'true', time() + 86400 * 30, '/');
        setcookie('jingjai_user_name', $matchedUser['name'], time() + 86400 * 30, '/');

        header('Location: index.php');
        exit;
    }

    $loginError = true;
    $message = 'อีเมลหรือรหัสผ่านไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง';
}

$loggedUser = $_SESSION['user']['name'] ?? null;
?>
<!DOCTYPE html>
<html lang="th">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>เข้าสู่ระบบ | JingJai</title>
  <meta name="description" content="เข้าสู่ระบบ JingJai เพื่อจัดการการจองและดูประวัติหอพักที่ใช่">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&family=Outfit:wght@400;600;700&family=Prompt:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            'glass': '0 8px 32px 0 rgba(31, 38, 135, 0.08)',
            'glow-blue': '0 0 24px rgba(37, 99, 235, 0.20)',
          }
        }
      }
    }
  </script>
</head>

<body class="bg-slate-50 text-slate-800 font-sans min-h-screen relative overflow-hidden">
  <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(37,99,235,0.10),transparent_35%),radial-gradient(circle_at_bottom_right,_rgba(168,85,247,0.10),transparent_30%)]"></div>

  <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
    <div class="mb-6">
      <a href="index.php" class="inline-flex items-center gap-3 text-slate-700 hover:text-brand-600 transition-colors">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-600 via-accent-purple to-pink-500 flex items-center justify-center text-white font-bold text-lg shadow-glow-blue">
          <i class="fa-solid fa-building-user"></i>
        </div>
        <div>
          <span class="text-xl font-extrabold bg-gradient-to-r from-brand-600 to-accent-purple bg-clip-text text-transparent">JingJai</span>
          <span class="block text-[10px] font-semibold text-slate-500 -mt-1">ค้นหาหอพักนิสิต & AI สรุปรีวิว</span>
        </div>
      </a>
    </div>

    <div class="grid lg:grid-cols-[1.15fr_0.85fr] gap-6 items-center">
      <div class="rounded-3xl border border-slate-200 bg-white/85 backdrop-blur-md shadow-glass p-6 sm:p-8">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-100 text-brand-700 text-[11px] font-bold">
          <i class="fa-solid fa-shield-heart"></i>
          เข้าถึงข้อมูลหอพักที่เชื่อถือได้
        </div>

        <h1 class="mt-5 text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight leading-tight text-slate-900">
          จัดการหอพักที่ใช่
          <span class="block bg-gradient-to-r from-brand-600 via-indigo-600 to-accent-purple bg-clip-text text-transparent">
            ได้ใน 1 นาที
          </span>
        </h1>

        <p class="mt-4 text-sm sm:text-base text-slate-600 max-w-xl">
          เข้าสู่ระบบเพื่อดูรายการจองที่บันทึกไว้ จัดการประวัติการค้นหาหอพัก และใช้ประโยชน์จากฟังก์ชันบริการอื่น ๆ อย่างครบถ้วน
        </p>

        <div class="mt-8 grid sm:grid-cols-2 gap-4">
          <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
            <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-600 flex items-center justify-center text-lg mb-3">
              <i class="fa-solid fa-magnifying-glass"></i>
            </div>
            <h3 class="font-bold text-slate-800">ค้นหาหอพัก</h3>
            <p class="text-xs text-slate-500 mt-1">ค้นหาตามงบประมาณ ซอย และคุณสมบัติที่ต้องการ</p>
          </div>

          <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
            <div class="w-10 h-10 rounded-xl bg-pink-100 text-pink-600 flex items-center justify-center text-lg mb-3">
              <i class="fa-solid fa-broom"></i>
            </div>
            <h3 class="font-bold text-slate-800">จองแม่บ้าน</h3>
            <p class="text-xs text-slate-500 mt-1">จองทำความสะอาดหอพักพร้อมดูประวัติและรอบเวลา</p>
          </div>

          <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg mb-3">
              <i class="fa-solid fa-truck-moving"></i>
            </div>
            <h3 class="font-bold text-slate-800">รถขนของ</h3>
            <p class="text-xs text-slate-500 mt-1">บันทึกการย้ายห้องและติดตามสถานะได้ทันที</p>
          </div>

          <div class="bg-slate-50 border border-slate-200 rounded-2xl p-4">
            <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg mb-3">
              <i class="fa-solid fa-circle-check"></i>
            </div>
            <h3 class="font-bold text-slate-800">ข้อมูลเชื่อถือได้</h3>
            <p class="text-xs text-slate-500 mt-1">AI สรุปรีวิว + แผนที่จริงช่วยตัดสินใจได้ง่ายขึ้น</p>
          </div>
        </div>
      </div>

      <div class="rounded-3xl border border-slate-200 bg-white shadow-glass p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6">
          <div>
            <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-400">Welcome back</p>
            <h2 class="text-2xl font-extrabold text-slate-900">เข้าสู่ระบบ</h2>
          </div>
          <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-brand-500 to-accent-purple text-white flex items-center justify-center shadow-glow-blue">
            <i class="fa-solid fa-user-check"></i>
          </div>
        </div>

        <?php if ($loggedUser): ?>
          <div class="rounded-2xl bg-emerald-50 border border-emerald-200 p-5 text-center">
            <div class="w-14 h-14 mx-auto rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-2xl">
              <i class="fa-solid fa-circle-check"></i>
            </div>
            <h3 class="mt-4 text-lg font-extrabold text-emerald-700">เข้าสู่ระบบสำเร็จ</h3>
            <p class="mt-2 text-sm text-slate-600">สวัสดี <strong><?php echo htmlspecialchars($loggedUser); ?></strong></p>
            <div class="mt-5 flex gap-3 justify-center">
              <a href="index.php" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white text-sm font-semibold transition-colors">
                <i class="fa-solid fa-house mr-2"></i> กลับหน้าหลัก
              </a>
              <a href="logout.php" class="inline-flex items-center justify-center px-4 py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold transition-colors">
                <i class="fa-solid fa-right-from-bracket mr-2"></i> ออกจากระบบ
              </a>
            </div>
          </div>
        <?php else: ?>
          <form method="POST" action="login.php" class="space-y-4">
            <div>
              <label for="email" class="block text-xs font-semibold text-slate-600 mb-1">อีเมล / เบอร์โทร</label>
              <div class="relative">
                <i class="fa-solid fa-envelope absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input id="email" name="email" type="text" placeholder="admin@jingjai.com" value="admin@jingjai.com"
                  class="w-full pl-10 pr-3 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
              </div>
            </div>

            <div>
              <label for="password" class="block text-xs font-semibold text-slate-600 mb-1">รหัสผ่าน</label>
              <div class="relative">
                <i class="fa-solid fa-lock absolute left-3 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input id="password" name="password" type="password" placeholder="กรอกรหัสผ่าน" value="123456"
                  class="w-full pl-10 pr-3 py-3 bg-slate-50 border border-slate-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500" required>
              </div>
            </div>

            <div class="flex items-center justify-between text-[11px] text-slate-500">
              <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" class="rounded text-brand-600 focus:ring-brand-500">
                <span>จดจำการเข้าสู่ระบบ</span>
              </label>
              <button type="button" class="font-semibold text-brand-600 hover:text-brand-700 cursor-pointer">ลืมรหัสผ่าน?</button>
            </div>

            <?php if ($loginError): ?>
              <div class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-xs font-semibold text-rose-600">
                <i class="fa-solid fa-circle-xmark mr-1"></i><?php echo htmlspecialchars($message); ?>
              </div>
            <?php endif; ?>

            <button type="submit"
              class="w-full bg-gradient-to-r from-brand-600 via-indigo-600 to-accent-purple hover:from-brand-700 hover:to-indigo-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-brand-500/20 transition-all cursor-pointer">
              <i class="fa-solid fa-right-to-bracket mr-2"></i> เข้าสู่ระบบ
            </button>

            <div class="text-center text-[11px] text-slate-500">
              ยังไม่มีบัญชี?
              <button type="button" class="font-semibold text-brand-600 hover:text-brand-700 cursor-pointer">สมัครสมาชิก</button>
            </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <script>
    document.querySelectorAll('.demo-login-btn').forEach((btn) => {
      btn.addEventListener('click', () => {
        const emailField = document.getElementById('email');
        const passwordField = document.getElementById('password');
        if (emailField && passwordField) {
          emailField.value = btn.dataset.email;
          passwordField.value = btn.dataset.password;
        }
      });
    });
  </script>
</body>

</html>
