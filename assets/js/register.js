

const roles = {
    student: { title: 'حساب طالب', desc: 'سيتم توفير أدوات ومميزات مخصصة لخدمة احتياجاتك كطالب في المنصة.', icon: 'school' },
    teacher: { title: 'حساب معلم', desc: 'إدارة حلقاتك التعليمية، متابعة الطلاب، وتقييم أدائهم بكل سهولة.', icon: 'person' },
    parent: { title: 'حساب ولي أمر', desc: 'متابعة مستوى أبنائك، تقارير الحفظ، والتواصل المباشر مع المعلمين.', icon: 'group' }
};

function selectRole(role) {
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('active'));
    document.getElementById('role_' + role).classList.add('active');
    
    document.getElementById('roleInput').value = role;
    
    document.getElementById('roleTitle').innerText = roles[role].title;
    document.getElementById('roleDesc').innerText = roles[role].desc;
    document.getElementById('roleIcon').innerText = roles[role].icon;
}

function nextStep() {
    const role = document.getElementById('roleInput').value;
    const teacherFields = document.getElementById('teacherFields');
    const parentFields = document.getElementById('parentFields');
    
    if (role === 'teacher') {
        teacherFields.classList.remove('hidden');
        teacherFields.classList.add('md:contents');
        parentFields.classList.add('hidden');
        parentFields.classList.remove('md:contents');
    } 
    else if (role === 'parent') {
        parentFields.classList.remove('hidden');
        parentFields.classList.add('md:contents');
        teacherFields.classList.add('hidden');
        teacherFields.classList.remove('md:contents');
    } 
    else {
        teacherFields.classList.add('hidden');
        teacherFields.classList.remove('md:contents');
        parentFields.classList.add('hidden');
        parentFields.classList.remove('md:contents');
    }

    document.getElementById('step1').classList.add('hidden');
    document.getElementById('step2').classList.remove('hidden');
    setTimeout(() => {
        document.getElementById('step2').classList.remove('translate-x-12', 'opacity-0');
    }, 10);
}

function prevStep() {
    document.getElementById('step2').classList.add('translate-x-12', 'opacity-0');
    setTimeout(() => {
        document.getElementById('step2').classList.add('hidden');
        document.getElementById('step1').classList.remove('hidden');
    }, 500);
}
