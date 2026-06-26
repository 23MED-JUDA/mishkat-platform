<?php
// Student Calendar - Dynamic
$events = $conn->query("SELECT * FROM calendar_events WHERE user_id=$uid ORDER BY event_date, event_time");
$eventsList = [];
while($e = $events->fetch_assoc()) $eventsList[] = $e;
?>
<div class="space-y-6 animate-fadeIn" dir="rtl">
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-black text-gray-900">التقويم الدراسي</h2>
        <button onclick="document.getElementById('addEventModal').classList.add('active')" class="flex items-center gap-2 px-5 py-2.5 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold text-sm hover:bg-mishkat-green-800 transition-all shadow-lg shadow-mishkat-green-100">
            <span class="material-icons-outlined text-sm">add</span> إضافة حدث
        </button>
    </div>

    <!-- Calendar Grid -->
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-5 border-b border-gray-50 flex justify-between items-center">
            <h3 class="font-bold text-gray-800" id="calendarTitle"><?php echo date('F Y'); ?></h3>
            <div class="flex gap-2">
                <button onclick="changeMonth(-1)" class="p-2 hover:bg-gray-100 rounded-lg transition-all"><span class="material-icons-outlined text-gray-500">chevron_right</span></button>
                <button onclick="changeMonth(1)" class="p-2 hover:bg-gray-100 rounded-lg transition-all"><span class="material-icons-outlined text-gray-500">chevron_left</span></button>
            </div>
        </div>
        <div class="grid grid-cols-7 gap-px bg-gray-100">
            <?php foreach(['أحد','إثنين','ثلاثاء','أربعاء','خميس','جمعة','سبت'] as $day): ?>
            <div class="bg-gray-50 py-2 text-center text-xs font-bold text-gray-500"><?php echo $day; ?></div>
            <?php endforeach; ?>
        </div>
        <div class="grid grid-cols-7 gap-px bg-gray-100" id="calendarDays"></div>
    </div>

    <!-- Events List -->
    <div class="luxury-card rounded-[2rem] shadow-sm border border-gray-100 p-5">
        <h3 class="text-lg font-black text-gray-900 mb-4">الأحداث القادمة</h3>
        <div class="space-y-3" id="eventsList">
            <?php foreach($eventsList as $ev): 
                $typeColors = ['class'=>'emerald','exam'=>'blue','meeting'=>'amber','holiday'=>'red'];
                $typeNames = ['class'=>'حلقة','exam'=>'اختبار','meeting'=>'اجتماع','holiday'=>'عطلة'];
                $tc = $typeColors[$ev['type']]??'gray';
            ?>
            <div class="flex items-center justify-between p-4 rounded-[1.5rem] border border-gray-50 hover:bg-gray-50 transition-all">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-[1.5rem] bg-<?php echo $tc; ?>-50 text-<?php echo $tc; ?>-600 flex items-center justify-center">
                        <span class="material-icons-outlined text-lg"><?php echo $ev['type']==='exam'?'quiz':($ev['type']==='meeting'?'groups':'event'); ?></span>
                    </div>
                    <div>
                        <h4 class="font-bold text-gray-800 text-sm"><?php echo htmlspecialchars($ev['title']); ?></h4>
                        <p class="text-xs text-gray-400"><?php echo $ev['event_date']; ?> • <?php echo substr($ev['event_time'],0,5); ?></p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded-lg text-[10px] font-black bg-<?php echo $tc; ?>-50 text-<?php echo $tc; ?>-600"><?php echo $typeNames[$ev['type']]??$ev['type']; ?></span>
                    <button onclick="deleteEvent(<?php echo $ev['id']; ?>)" class="p-1.5 text-gray-300 hover:text-red-500 transition-colors"><span class="material-icons-outlined text-sm">close</span></button>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if(empty($eventsList)): ?>
            <p class="text-center text-gray-400 text-sm py-6">لا توجد أحداث قادمة</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Add Event Modal -->
<div class="modal-backdrop" id="addEventModal">
    <div class="modal-box">
        <h3 class="text-lg font-black text-gray-900 mb-4">إضافة حدث جديد</h3>
        <form id="eventForm" class="space-y-4">
            <input type="text" name="title" placeholder="عنوان الحدث" required class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold">
            <div class="grid grid-cols-2 gap-3">
                <input type="date" name="event_date" required class="px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold">
                <input type="time" name="event_time" class="px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold">
            </div>
            <select name="type" class="w-full px-4 py-3 bg-gray-50 rounded-[1.5rem] outline-none focus:ring-2 focus:ring-mishkat-green-100 text-sm font-bold">
                <option value="class">حلقة</option><option value="exam">اختبار</option><option value="meeting">اجتماع</option>
            </select>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addEventModal').classList.remove('active')" class="flex-1 py-3 bg-gray-100 text-gray-600 rounded-[1.5rem] font-bold">إلغاء</button>
                <button type="submit" class="flex-1 py-3 bg-mishkat-green-700 text-white rounded-[1.5rem] font-bold hover:bg-mishkat-green-800 transition-all">إضافة</button>
            </div>
        </form>
    </div>
</div>

<script>
const events = <?php echo json_encode($eventsList); ?>;
let currentDate = new Date();

function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const today = new Date();
    
    document.getElementById('calendarTitle').innerText = currentDate.toLocaleDateString('ar-EG', { month:'long', year:'numeric' });
    
    let html = '';
    for(let i = 0; i < firstDay; i++) html += '<div class="luxury-card p-3 min-h-[60px]"></div>';
    
    for(let d = 1; d <= daysInMonth; d++) {
        const dateStr = `${year}-${String(month+1).padStart(2,'0')}-${String(d).padStart(2,'0')}`;
        const dayEvents = events.filter(e => e.event_date === dateStr);
        const isToday = today.getDate()===d && today.getMonth()===month && today.getFullYear()===year;
        
        html += `<div class="luxury-card p-2 min-h-[60px] hover:bg-gray-50 transition-all cursor-pointer ${isToday?'ring-2 ring-mishkat-green-500 ring-inset':''}">
            <span class="text-sm font-bold ${isToday?'text-mishkat-green-700':'text-gray-700'}">${d}</span>`;
        dayEvents.forEach(ev => {
            const tc = ev.type==='exam'?'blue':ev.type==='meeting'?'amber':'emerald';
            html += `<div class="mt-1 px-1 py-0.5 rounded text-[9px] font-bold bg-${tc}-50 text-${tc}-700 truncate">${ev.title}</div>`;
        });
        html += '</div>';
    }
    document.getElementById('calendarDays').innerHTML = html;
}

function changeMonth(dir) { currentDate.setMonth(currentDate.getMonth() + dir); renderCalendar(); }
renderCalendar();

document.getElementById('eventForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const fd = new FormData(this);
    fd.append('action', 'add_event');
    fetch('api.php', {method:'POST', body:fd}).then(r=>r.json()).then(res => {
        if(res.success) { showToast('تم إضافة الحدث'); setTimeout(()=>location.reload(), 500); }
        else showToast(res.message||'خطأ','error');
    });
});

function deleteEvent(id) {
    confirmDialog('هل تريد حذف هذا الحدث؟').then(ok => {
        if(ok) apiCall('delete_event', {event_id:id}).then(res => {
            if(res.success) { showToast('تم حذف الحدث'); setTimeout(()=>location.reload(), 500); }
        });
    });
}
</script>
