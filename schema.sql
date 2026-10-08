-- ====================================================================
-- โครงสร้างฐานข้อมูลระบบค้นหาและรีวิวหอพักนิสิต/นักศึกษา (PostgreSQL / pgAdmin 4)
-- ====================================================================

-- 1. สร้าง ENUM สำหรับระดับความปลอดภัยประเภทรูปภาพ และบทบาท
CREATE TYPE safety_level_enum AS ENUM ('GREEN', 'YELLOW', 'RED');
CREATE TYPE photo_source_enum AS ENUM ('LANDLORD', 'STUDENT');

-- 2. ตารางมหาวิทยาลัย (Universities)
CREATE TABLE universities (
    id SERIAL PRIMARY KEY,
    code VARCHAR(20) NOT NULL UNIQUE, -- เช่น MSU, KKU, SUT, UBU
    name_th VARCHAR(100) NOT NULL,
    name_en VARCHAR(100),
    province VARCHAR(50) NOT NULL,
    latitude NUMERIC(10, 7),
    longitude NUMERIC(10, 7),
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 3. ตารางหอพัก (Dormitories)
CREATE TABLE dorms (
    id SERIAL PRIMARY KEY,
    university_id INT REFERENCES universities(id) ON DELETE CASCADE,
    name_th VARCHAR(100) NOT NULL,
    address TEXT,
    distance_km NUMERIC(4, 2) NOT NULL, -- ระยะทางจาก ม. (กิโลเมตร)
    walking_min INT NOT NULL,           -- เวลาเดินถึง ม. (นาที)
    price_monthly INT NOT NULL,         -- ค่าเช่า (บาท/เดือน)
    water_rate NUMERIC(5, 2) NOT NULL,  -- ค่าน้ำ (บาท/ยูนิต หรือบาท/เดือน)
    electric_rate NUMERIC(5, 2) NOT NULL, -- ค่าไฟ (บาท/ยูนิต)
    has_air BOOLEAN DEFAULT TRUE,
    has_furniture BOOLEAN DEFAULT TRUE,
    has_internet BOOLEAN DEFAULT TRUE,
    pet_friendly BOOLEAN DEFAULT FALSE,
    has_parking BOOLEAN DEFAULT TRUE,
    cover_image TEXT,
    video_url TEXT,
    map_lat NUMERIC(10, 7),
    map_lng NUMERIC(10, 7),
    overall_rating NUMERIC(3, 2) DEFAULT 0.0,
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 4. ตารางคะแนนประเมิน 6 มิติ (Dorm Ratings Breakdown)
CREATE TABLE dorm_ratings (
    dorm_id INT PRIMARY KEY REFERENCES dorms(id) ON DELETE CASCADE,
    quietness NUMERIC(3, 2) DEFAULT 0.0,   -- ความเงียบ
    water_supply NUMERIC(3, 2) DEFAULT 0.0, -- น้ำประปา
    internet NUMERIC(3, 2) DEFAULT 0.0,     -- อินเทอร์เน็ต
    security NUMERIC(3, 2) DEFAULT 0.0,     -- ความปลอดภัย
    landlord NUMERIC(3, 2) DEFAULT 0.0,     -- เจ้าของหอ
    cleanliness NUMERIC(3, 2) DEFAULT 0.0   -- ความสะอาด
);

-- 5. ตารางรีวิวนิสิตจริง (Student Reviews & Detail Surveys)
CREATE TABLE dorm_reviews (
    id SERIAL PRIMARY KEY,
    dorm_id INT REFERENCES dorms(id) ON DELETE CASCADE,
    user_name VARCHAR(50) DEFAULT 'นิสิตไม่ประสงค์ออกนาม',
    review_text TEXT NOT NULL,
    -- แบบสอบถามความพึงพอใจเฉพาะด้าน
    wifi_score INT CHECK (wifi_score BETWEEN 1 AND 5),
    is_zoom_smooth BOOLEAN DEFAULT TRUE,
    is_gaming_good BOOLEAN DEFAULT TRUE,
    is_netflix_smooth BOOLEAN DEFAULT TRUE,
    
    quietness_score INT CHECK (quietness_score BETWEEN 1 AND 5),
    daytime_noise_level VARCHAR(20),   -- 'เงียบมาก', 'ปานกลาง', 'เสียงดัง'
    nighttime_noise_level VARCHAR(20), -- 'เงียบมาก', 'ปานกลาง', 'เสียงดัง'
    
    water_score INT CHECK (water_score BETWEEN 1 AND 5),
    is_water_pressure_ok BOOLEAN DEFAULT TRUE,
    has_evening_drop BOOLEAN DEFAULT FALSE, -- น้ำไหลเบาช่วงเย็น 18.00-20.00 น.
    is_water_clean BOOLEAN DEFAULT TRUE,

    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 6. ตาราง AI วิเคราะห์รีวิว (AI Review Summaries & Insights)
CREATE TABLE ai_review_summaries (
    dorm_id INT PRIMARY KEY REFERENCES dorms(id) ON DELETE CASCADE,
    pros JSONB DEFAULT '[]'::jsonb,           -- รายการข้อดีที่ AI สรุปได้
    considerations JSONB DEFAULT '[]'::jsonb, -- รายการข้อควรทราบที่ AI สรุปได้
    wifi_ai_summary TEXT,                     -- ข้อสรุป AI เรื่อง Wi-Fi
    quietness_ai_summary TEXT,                -- ข้อสรุป AI เรื่องความเงียบ
    water_ai_summary TEXT,                    -- ข้อสรุป AI เรื่องน้ำประปา
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 7. ตาราง Heatmap ความปลอดภัย (Safety Indicators)
CREATE TABLE safety_indicators (
    dorm_id INT PRIMARY KEY REFERENCES dorms(id) ON DELETE CASCADE,
    safety_level safety_level_enum DEFAULT 'GREEN',
    streetlight_count INT DEFAULT 10,
    student_safety_score NUMERIC(3, 2) DEFAULT 4.5,
    reported_incidents INT DEFAULT 0,
    safety_note TEXT,
    updated_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 8. ตารางรูปภาพหอพัก (Photos: เจ้าของหอ vs นิสิตจริง)
CREATE TABLE dorm_photos (
    id SERIAL PRIMARY KEY,
    dorm_id INT REFERENCES dorms(id) ON DELETE CASCADE,
    photo_url TEXT NOT NULL,
    photo_source photo_source_enum DEFAULT 'STUDENT',
    caption VARCHAR(150),
    uploaded_by VARCHAR(50) DEFAULT 'ผู้พักจริง',
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);

-- 9. ตารางถาม-ตอบกับผู้เคยพัก (Student Q&A)
CREATE TABLE dorm_qa (
    id SERIAL PRIMARY KEY,
    dorm_id INT REFERENCES dorms(id) ON DELETE CASCADE,
    question TEXT NOT NULL,
    asker_name VARCHAR(50) DEFAULT 'ผู้สนใจหอพัก',
    answer TEXT,
    responder_name VARCHAR(50) DEFAULT 'ศิษย์เก่า/ผู้พักปัจจุบัน',
    created_at TIMESTAMP WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP
);


-- ====================================================================
-- ข้อมูลตัวอย่าง (Sample Data)
-- ====================================================================

-- เพิ่มมหาวิทยาลัย
INSERT INTO universities (code, name_th, name_en, province, latitude, longitude) VALUES
('MSU', 'มหาวิทยาลัยมหาสารคาม (มมส. มอใหม่)', 'Mahasarakham University', 'มหาสารคาม', 16.2464, 103.2523),
('KKU', 'มหาวิทยาลัยขอนแก่น (มข.)', 'Khon Kaen University', 'ขอนแก่น', 16.4744, 102.8228),
('SUT', 'มหาวิทยาลัยเทคโนโลยีสุรนารี (มทส.)', 'Suranaree University of Technology', 'นครราชสีมา', 14.8817, 102.0207),
('UBU', 'มหาวิทยาลัยอุบลราชธานี (อุบลฯ)', 'Ubon Ratchathani University', 'อุบลราชธานี', 15.1189, 104.9031);

-- เพิ่มหอพักตัวอย่าง
INSERT INTO dorms (university_id, name_th, address, distance_km, walking_min, price_monthly, water_rate, electric_rate, has_air, has_furniture, has_internet, pet_friendly, has_parking, video_url, map_lat, map_lng, overall_rating) VALUES
(1, 'หอพักเดอะเฟรชชี่ (The Freshy Living Complex)', '123 ซอยหน้า มมส. มอใหม่ ต.ขามเรียง อ.กันทรวิชัย', 0.4, 5, 3500, 25.00, 7.00, true, true, true, false, true, 'https://www.youtube.com/embed/dQw4w9WgXcQ', 16.2480, 103.2540, 4.4),
(1, 'เคหะเพลส มมส. สารคาม', '88 ถ.ขามเรียง มอใหม่', 0.8, 10, 2800, 20.00, 7.00, true, true, true, true, true, NULL, 16.2440, 103.2510, 4.1),
(2, 'กังสดาล กรีนเรสซิเดนซ์ (มข.)', '456 โซนกังสดาล อ.เมืองขอนแก่น', 0.5, 6, 4200, 25.00, 8.00, true, true, true, false, true, NULL, 16.4710, 102.8200, 4.6),
(2, 'หลังมอ คอมเพล็กซ์ (มข.)', '789 โซนหลังมอ ถ.มิตรภาพ ขอนแก่น', 1.2, 15, 3200, 23.00, 7.50, true, true, true, true, true, NULL, 16.4780, 102.8260, 3.9),
(3, 'สุรนารี วิลล์ (มทส. ประตู 1)', '99 ม.1 ต.สุรนารี อ.เมืองนครราชสีมา', 0.6, 7, 3800, 22.00, 7.00, true, true, true, false, true, NULL, 14.8830, 102.0220, 4.3),
(4, 'อุบลทาวเวอร์ เรสซิเดนซ์ (ม.อุบลฯ)', '55 ถ.สถลมาร์ค อ.วารินชำราบ อุบลราชธานี', 0.3, 4, 3400, 20.00, 6.50, true, true, true, false, true, NULL, 15.1200, 104.9050, 4.5);

-- คะแนน 6 มิติ
INSERT INTO dorm_ratings (dorm_id, quietness, water_supply, internet, security, landlord, cleanliness) VALUES
(1, 4.8, 3.2, 4.7, 4.6, 4.5, 4.3),
(2, 3.8, 4.5, 4.0, 4.2, 4.8, 4.0),
(3, 4.5, 4.6, 4.8, 4.7, 4.4, 4.6),
(4, 3.2, 3.5, 4.2, 3.9, 4.0, 3.8),
(5, 4.4, 4.2, 4.5, 4.5, 4.3, 4.2),
(6, 4.7, 4.4, 4.6, 4.8, 4.6, 4.5);

-- AI Summaries (ข้อดี / ข้อควรทราบ / สรุปเฉพาะด้าน)
INSERT INTO ai_review_summaries (dorm_id, pros, considerations, wifi_ai_summary, quietness_ai_summary, water_ai_summary) VALUES
(1, 
 '["อินเทอร์เน็ตเร็วมาก เล่นเกมไม่กระตุก", "ห้องพักสะอาด เฟอร์นิเจอร์ใหม่ครบชุด", "เจ้าของหอใจดี เป็นกันเอง ช่วยเหลือเร็ว", "ระบบความปลอดภัยคีย์การ์ด + กล้องวงจรปิดแน่นหนา"]'::jsonb,
 '["ช่วงเย็น 18:00–20:00 น. น้ำประปาอาจไหลเบาลงบ้าง", "กลางคืนอาจมีเสียงรถมอเตอร์ไซค์ผ่านซอยเป็นระยะ"]'::jsonb,
 'Wi-Fi ไฟเบอร์ออปติก ความเร็วสูง เหมาะมากสำหรับเรียนออนไลน์ผ่าน Zoom และเล่นเกมออนไลน์ ช่วงหัวค่ำมีการแชร์แบนด์วิธเล็กน้อยแต่ยังลื่นไหล',
 'ตัวหอพักตั้งอยู่ในซอยที่เป็นส่วนตัว บรรยากาศเงียบสงบในเวลาทำการ เหมาะกับการอ่านหนังสือสอบ แต่อาจมีเสียงรถผ่านช่วงหัวค่ำ',
 'นิสิตผู้พัก 83% ระบุว่าน้ำสะอาดและไหลปกติทุกวัน แต่อาจมีแรงดันตกเล็กน้อยในช่วงเวลาแย่งกันใช้น้ำ 18:00 - 20:00 น.'
);

-- Safety Indicators (สำหรับ Safety Heatmap)
INSERT INTO safety_indicators (dorm_id, safety_level, streetlight_count, student_safety_score, reported_incidents, safety_note) VALUES
(1, 'GREEN', 14, 4.6, 0, 'ซอยมีไฟสว่างตลอดทาง มีกล้องวงจรปิดของเทศบาลและหอพัก'),
(2, 'YELLOW', 6, 3.9, 2, 'ช่วงท้ายซอยค่อนข้างมืดเล็กน้อย แนะนำเดินกลุ่มช่วงดึก'),
(3, 'GREEN', 18, 4.8, 0, 'ย่านกังสดาลคึกคัก มีร้านค้าตลอด 24 ชม. ปลอดภัยสูง'),
(4, 'RED', 4, 3.4, 5, 'ทางเข้าหอลึก ไฟถนนเสีย 2 จุด นิสิตควรระมัดระวังยามดึก'),
(5, 'GREEN', 12, 4.5, 0, 'ใกล้ประตู มทส. มีป้อมยามรักษาความปลอดภัยตลอด 24 ชม.'),
(6, 'GREEN', 15, 4.7, 0, 'ติดถนนใหญ่ สว่างสดใส เดินไปเรียนสะดวก');

-- รูปภาพหอพัก (นิสิต vs เจ้าของหอ)
INSERT INTO dorm_photos (dorm_id, photo_url, photo_source, caption, uploaded_by) VALUES
(1, 'https://images.unsplash.com/photo-1522771739844-6a9f6d5f14af?auto=format&fit=crop&w=800&q=80', 'LANDLORD', 'มุมมองห้องพักแบบเต็ม (รูปจากเจ้าของหอ)', 'เจ้าของหอ ABC'),
(1, 'https://images.unsplash.com/photo-1598928506311-c55ded91a20c?auto=format&fit=crop&w=800&q=80', 'STUDENT', 'สภาพห้องจริงตอนเข้าพัก มีโต๊ะอ่านหนังสือพร้อม (รูปจากผู้พัก)', 'นิสิตปี 3 มมส.'),
(1, 'https://images.unsplash.com/photo-1584622650111-993a426fbf0a?auto=format&fit=crop&w=800&q=80', 'STUDENT', 'ห้องน้ำจริง กว้างขวาง มีเครื่องทำน้ำอุ่น', 'นิสิตปี 2 มมส.');

-- เพิ่มหอเฟรชชี่ The Freshy Living Complex
INSERT INTO dorms (university_id, name_th, address, distance_km, walking_min, price_monthly, water_rate, electric_rate, has_air, has_furniture, has_internet, pet_friendly, has_parking, cover_image, video_url, map_lat, map_lng, overall_rating) VALUES
(1, 'หอเฟรชชี่ The Freshy Living Complex', '88/1 ซอยขามเรียง มอใหม่ ต.ขามเรียง อ.กันทรวิชัย จ.มหาสารคาม', 0.6, 8, 4200, 25.00, 7.00, true, true, true, false, true, 'images/freshy-building.jpg', NULL, 16.2475, 103.2535, 4.7);

-- คะแนน 6 มิติ สำหรับหอเฟรชชี่
INSERT INTO dorm_ratings (dorm_id, quietness, water_supply, internet, security, landlord, cleanliness) VALUES
(7, 4.8, 4.5, 4.8, 4.7, 4.8, 4.7);

-- AI Summary สำหรับหอเฟรชชี่
INSERT INTO ai_review_summaries (dorm_id, pros, considerations, wifi_ai_summary, quietness_ai_summary, water_ai_summary) VALUES
(7,
 '["ทำเลดี ใกล้ มมส. เดินถึงได้สะดวก", "ห้องพักสะอาด มีเฟอร์นิเจอร์ครบ", "อินเทอร์เน็ตแรงและเสถียร เหมาะสำหรับเรียนออนไลน์", "มีพื้นที่ส่วนกลางและสิ่งอำนวยความสะดวกครบ"]'::jsonb,
 '["ราคาเริ่มต้นค่อนข้างสูงกว่าหอธรรมดาเล็กน้อย", "ช่วงเปิดเทอมมีคนจองเร็ว จึงควรจองล่วงหน้า"]'::jsonb,
 'อินเทอร์เน็ตความเร็วสูงและเสถียร เหมาะสำหรับเรียนออนไลน์ ดูหนัง และทำงานจากห้องพักได้ดีเยี่ยม',
 'เงียบสงบและเหมาะสำหรับการอ่านหนังสือและพักผ่อนในห้อง มีบรรยากาศที่ดีสำหรับนักศึกษา',
 'น้ำประปาแรงดี ไม่มีปัญหาเรื่องน้ำขาด และใช้งานได้ตลอดเวลา');

-- Safety Indicators สำหรับหอเฟรชชี่
INSERT INTO safety_indicators (dorm_id, safety_level, streetlight_count, student_safety_score, reported_incidents, safety_note) VALUES
(7, 'GREEN', 16, 4.7, 0, 'บริเวณหอมีแสงสว่างเพียงพอ มีกล้องวงจรปิด และทางเข้าหอปลอดภัย');

-- รูปภาพหอเฟรชชี่
INSERT INTO dorm_photos (dorm_id, photo_url, photo_source, caption, uploaded_by) VALUES
(7, 'images/freshy-building.jpg', 'LANDLORD', 'ภายนอกอาคารหอพักและบรรยากาศด้านหน้า', 'เจ้าของหอเฟรชชี่'),
(7, 'images/freshy-cuisine.jpg', 'LANDLORD', 'โซนรับประทานอาหารและบรรยากาศด้านในหอ', 'เจ้าของหอเฟรชชี่'),
(7, 'images/freshy-fitness.jpg', 'LANDLORD', 'สภาพห้องออกกำลังกายภายในหอพัก', 'เจ้าของหอเฟรชชี่'),
(7, 'images/freshy-bed.jpg', 'STUDENT', 'ห้องนอนแบบเรียบง่าย สบายและมีเฟอร์นิเจอร์ครบ', 'นิสิตผู้พักจริง'),
(7, 'images/freshy-room.jpg', 'STUDENT', 'ภายในห้องพักพร้อมพื้นที่ทำงานและการจัดวางสบาย', 'นิสิตผู้พักจริง'),
(7, 'images/freshy-toilet.jpg', 'STUDENT', 'ห้องน้ำสะอาดเรียบร้อยและใช้งานง่าย', 'นิสิตผู้พักจริง');

-- ถาม-ตอบ Q&A
INSERT INTO dorm_qa (dorm_id, question, asker_name, answer, responder_name) VALUES
(1, 'หอนี้ติดสัญญาเช่ากี่เดือนครับ และค่าน้ำมีขั้นต่ำไหม?', 'น้องปี 1 มมส.', 'สัญญาเช่าขั้นต่ำ 6 เดือนครับ ค่าน้ำคิดตามจริงยูนิตละ 25 บาท ไม่มีขั้นต่ำครับ', 'พี่ปี 4 ผู้พักปัจจุบัน'),
(1, 'เลี้ยงแมวพันธุ์เล็กในห้องได้ไหมครับ?', 'Student_MSU', 'หอนี้ไม่อนุญาตให้เลี้ยงสัตว์เลี้ยงทุกชนิดครับ เพื่อความสงบของเพื่อนร่วมหอ', 'เจ้าของหอ ABC'),
(7, 'หอเฟรชชี่อยู่ใกล้ มมส. มากไหมครับ?', 'Student_MSU', 'เดินประมาณ 8-10 นาทีถึงมหาวิทยาลัยได้เลยครับ สะดวกมาก', 'ผู้พักจริง');

