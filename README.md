# Mishkat Platform — Deployment Guide

## 🚀 نشر منصة مشكاة على Vercel

### المتطلبات قبل الرفع:
1. حساب على [Vercel](https://vercel.com)
2. حساب على [GitHub](https://github.com)
3. قاعدة بيانات سحابية — يُنصح بـ [Aiven](https://aiven.io) (مجانية)

---

## الخطوات:

### 1. إنشاء قاعدة بيانات Aiven (مجانية)
1. اذهب إلى https://aiven.io وسجّل حساباً
2. أنشئ **MySQL service** (Free tier)
3. من صفحة الـ Service احفظ:
   - `Host`
   - `Port`
   - `User`
   - `Password`
   - `Database name`

---

### 2. رفع الكود على GitHub
```bash
cd /home/ahmed-juda/Documents/Projects/mishka
git init
git add .
git commit -m "🚀 Initial commit — Mishkat Platform"
git branch -M main
git remote add origin https://github.com/YOUR_USERNAME/mishkat.git
git push -u origin main
```

---

### 3. ربط GitHub بـ Vercel
1. اذهب إلى https://vercel.com/new
2. اختر **"Import Git Repository"**
3. اختر الـ Repo الخاص بك
4. اضغط **Deploy** (سيقرأ الـ `vercel.json` تلقائياً)

---

### 4. إضافة متغيرات البيئة (Environment Variables) في Vercel
في صفحة المشروع على Vercel:
`Settings → Environment Variables` وأضف:

| Key | Value |
|-----|-------|
| `DB_HOST` | (Aiven host) |
| `DB_USER` | (Aiven user) |
| `DB_PASS` | (Aiven password) |
| `DB_NAME` | `mishkat_db` |
| `DB_PORT` | (Aiven port, عادةً 21699) |

---

### 5. تهيئة قاعدة البيانات
بعد إضافة المتغيرات، شغّل ملف الإعداد مرة واحدة:
```
https://your-project.vercel.app/database/db_setup.php
```

---

## ✅ بيانات الدخول الافتراضية:
| الدور | البريد | كلمة المرور |
|-------|--------|------------|
| مدير | admin@mishkat.com | 123456 |
| معلم | teacher@mishkat.com | 123456 |
| طالب | student@mishkat.com | 123456 |
| ولي أمر | parent@mishkat.com | 123456 |
