<?php
// Admin Content Management - Dynamic
$courses = $conn->query("SELECT * FROM courses ORDER BY created_at DESC");
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-black text-gray-900">المحتوى التعليمي</h2>
        <button onclick="document.getElementById('addCourseModal').classList.add('active')" class="flex items-center gap-2 px-5 py-2.5 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold text-sm hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
            <span class="material-icons-outlined text-sm">add</span> إضافة مسار
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php while($c = $courses->fetch_assoc()): $clr=$c['color']??'emerald'; ?>
        <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-6 hover:shadow-md transition-all group">
            <div class="flex items-start justify-between mb-4">
                <div class="w-12 h-12 rounded-[1.5rem] bg-<?php echo $clr; ?>-50 text-<?php echo $clr; ?>-600 flex items-center justify-center group-hover:scale-110 transition-transform"><span class="material-icons-outlined">menu_book</span></div>
                <span class="px-2 py-0.5 rounded-lg text-[10px] font-black bg-<?php echo $clr; ?>-50 text-<?php echo $clr; ?>-600"><?php echo $c['type']; ?></span>
            </div>
            <h3 class="text-lg font-black text-gray-900 mb-2"><?php echo htmlspecialchars($c['title']); ?></h3>
            <p class="text-sm text-gray-400 mb-4 line-clamp-2"><?php echo htmlspecialchars($c['description']); ?></p>
            <div class="space-y-1 text-xs text-gray-500 mb-4">
                <div class="flex items-center gap-2"><span class="material-icons-outlined text-sm">schedule</span><?php echo $c['sessions_count']; ?></div>
                <div class="flex items-center gap-2"><span class="material-icons-outlined text-sm">people</span><?php echo $c['students_count']; ?> طالب</div>
                <div class="flex items-center gap-2"><span class="material-icons-outlined text-sm">payments</span><?php echo number_format($c['price']); ?> ج.م</div>
            </div>
            <div class="flex gap-2 pt-4 border-t border-gray-50">
                <button class="flex-1 py-2 bg-gray-50 text-gray-600 rounded-lg text-xs font-bold hover:bg-gray-100 transition-all">تعديل</button>
                <button onclick="deleteCourse(<?php echo $c['id']; ?>)" class="py-2 px-3 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-100 transition-all"><span class="material-icons-outlined text-sm">delete</span></button>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<div class="modal-backdrop" id="addCourseModal">
    <div class="modal-box">
        <h3 class="text-lg font-black text-gray-900 mb-4">إضافة مسار تعليمي</h3>
        <form id="courseForm" class="space-y-4">
            <input type="text" name="title" placeholder="عنوان المسار" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <input type="text" name="type" placeholder="النوع (أساسي، متقدم...)" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            <textarea name="description" placeholder="الوصف" rows="2" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold"></textarea>
            <div class="grid grid-cols-2 gap-3">
                <input type="text" name="sessions_count" placeholder="عدد الحصص" class="px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
                <input type="number" name="price" placeholder="السعر" class="px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
            </div>
            
            <div class="space-y-2">
                <label class="text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">محتوى المسار (اختياري)</label>
                <select name="content_type" id="course_content_type" onchange="toggleCourseContent(this.value)" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold outline-none">
                    <option value="text">نص فقط</option>
                    <option value="youtube">رابط يوتيوب</option>
                    <option value="file">رفع فيديو</option>
                </select>
                <div id="course_yt_input" class="hidden">
                    <input type="text" name="content_data" placeholder="رابط اليوتيوب" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
                </div>
                <div id="course_file_input" class="hidden">
                    <input type="file" name="video_file" accept="video/*" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none text-sm font-bold">
                </div>
            </div>

            <select name="color" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] text-sm font-bold">
                <option value="emerald">أخضر</option><option value="blue">أزرق</option><option value="amber">ذهبي</option>
            </select>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addCourseModal').classList.remove('active')" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[1.5rem] font-bold">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold">إضافة</button>
            </div>
        </form>
    </div>
</div>

<script>
function toggleCourseContent(val) {
    document.getElementById('course_yt_input').classList.toggle('hidden', val !== 'youtube');
    document.getElementById('course_file_input').classList.toggle('hidden', val !== 'file');
}

document.getElementById('courseForm').addEventListener('submit', function(e) {
    e.preventDefault(); const fd=new FormData(this); fd.append('action','add_course');
    fetch('api.php',{method:'POST',body:fd}).then(r=>r.json()).then(res => {
        if(res.success) { showToast('تم إضافة المسار'); setTimeout(()=>location.reload(),500); }
        else showToast(res.message||'خطأ','error');
    });
});
function deleteCourse(id) {
    confirmDialog('هل تريد حذف هذا المسار؟').then(ok => {
        if(ok) apiCall('delete_course',{course_id:id}).then(res => { if(res.success) { showToast('تم الحذف'); setTimeout(()=>location.reload(),500); } });
    });
}
</script>
