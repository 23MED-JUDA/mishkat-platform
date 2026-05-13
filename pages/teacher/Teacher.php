<?php
// Converted from Teacher.jsx
require_once __DIR__ . '/../../includes/db.php';

$teachersData = [];
$res = $conn->query("SELECT u.name, ti.* FROM users u JOIN teachers_info ti ON u.id = ti.user_id WHERE u.role = 'teacher'");
while ($row = $res->fetch_assoc()) {
    $row['img'] = null; // We don't have images in DB yet
    $teachersData[] = $row;
}

if (empty($teachersData)) {
    $teachersData = [
        ['id' => 1, 'name' => "محمود خالد", 'experience_years' => 28, 'img' => null, 'location' => 'القاهرة'],
    ];
}
?>

<div dir="rtl" class='w-[95%] mx-auto px-4 mt-8 py-12 bg-[#F8F9FA] rounded-3xl font-sans'>
  
  <!-- عنوان القسم -->
  <div class="text-center mb-12">
    <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
      نخبة من <span class="text-[#00A859]">المعلمين</span>
    </h2>
    <div class="w-20 h-1 bg-[#00A859] mx-auto mt-4 rounded-full"></div>
  </div>

  <!-- شبكة المعلمين -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
    <?php foreach ($teachersData as $item): ?>
      <div 
        class='group flex flex-col items-center luxury-card border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 px-8 py-10 rounded-[2rem]'
      >
        <!-- إطار الصورة الشخصية -->
        <div class="relative mb-6">
          <!-- تأثير التوهج عند التمرير -->
          <div class="absolute inset-0 bg-[#00A859] rounded-full blur-md opacity-0 group-hover:opacity-20 transition-opacity duration-300"></div>
          
          <?php if ($item['img']): ?>
            <img 
              class='relative w-36 h-36 rounded-full object-cover border-4 border-[#00A859]/10 group-hover:border-[#00A859] shadow-md transition-all duration-300' 
              src="<?php echo $item['img']; ?>" 
              alt="<?php echo $item['name']; ?>" 
            />
          <?php else: ?>
            <div class="relative w-36 h-36 rounded-full bg-mishkat-green-100 flex items-center justify-center text-mishkat-green-700 text-5xl font-black border-4 border-[#00A859]/10 group-hover:border-[#00A859] shadow-md transition-all duration-300">
              <?php echo mb_substr($item['name'], 0, 1, "UTF-8"); ?>
            </div>
          <?php endif; ?>
        </div>

        <!-- بيانات المعلم -->
        <h3 class='text-[#2D3436] text-2xl font-bold mb-3 group-hover:text-[#00A859] transition-colors'>
          <?php echo $item['name']; ?>
        </h3>
        
        <div class="flex items-center gap-2 bg-[#F0FDF4] px-5 py-1.5 rounded-full border border-[#DCFCE7]">
          <span class="text-[#00A859] font-bold text-lg">
             <?php echo $item['experience_years']; ?>
          </span>
          <span class="text-[#166534] text-sm">عاماً من الخبرة</span>
        </div>

        <!-- حقل المكان -->
        <?php if (isset($item['location'])): ?>
          <div class="mt-4 flex items-center gap-2 text-gray-500 text-sm">
            <span class="font-semibold text-mishkat-green-600">المكان:</span>
            <span><?php echo $item['location']; ?></span>
          </div>
        <?php endif; ?>

      </div>
    <?php endforeach; ?>
  </div>
</div>
