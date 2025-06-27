# 🛒 نظام إدارة الطلبات - Laravel Orders Management System

نظام متكامل لإدارة **العملاء، المنتجات، والطلبات** مبني باستخدام **Laravel 12**. يحتوي على واجهة API قوية تشمل عمليات CRUD (إنشاء، قراءة، تعديل، حذف)، بالإضافة إلى صفحات واجهة أمامية تفاعلية لإدارة البيانات، دعم التوثيق باستخدام Sanctum، وإمكانية تصدير البيانات إلى CSV/Excel.

---

## 📋 المتطلبات

- PHP 8.1 أو أحدث
- Composer
- Laravel 12
- MySQL أو SQLite
- Node.js (اختياري للواجهات)
- Postman (لتجربة API)

---

## 🛠️ الأدوات والتقنيات المستخدمة

| أداة | الوصف |
|------|--------|
| **Laravel Framework 12** | الإطار الرئيسي |
| **Laravel Sanctum** | توثيق API للمستخدمين |
| **Maatwebsite Excel** | لتصدير واستيراد ملفات Excel/CSV |
| **Blade Templates** | لعرض صفحات الويب |
| **Fetch API (JS)** | لجلب البيانات من API |
| **RESTful API** | إدارة الموارد عبر HTTP |

---



## 🛠️ الأدوات والمكتبات المستخدمة

- **Laravel Framework 12**  
  إطار العمل الأساسي لبناء التطبيق.

- **Laravel Sanctum**  
  مكتبة توثيق API خفيفة وسهلة الاستخدام لحماية المسارات التي تحتاج تسجيل دخول.

- **Maatwebsite Excel**  
  مكتبة لتصدير واستيراد ملفات Excel و CSV بسهولة داخل Laravel.  
  رابط المكتبة: [https://laravel-excel.com/](https://laravel-excel.com/)

- **Composer**  
  مدير الحزم الخاص بـ PHP لتثبيت مكتبات Laravel وجميع الإضافات.

- **Fetch API (JavaScript)**  
  لاستخدام الطلبات AJAX من واجهات الويب للتفاعل مع API الخلفي.

- **Blade Templates**  
  نظام القوالب الخاص بـ Laravel لبناء صفحات HTML ديناميكية.

---

## 🚀 خطوات تثبيت وتشغيل المشروع

1. استنساخ المشروع:

   ```bash
   git clone https://github.com/Anashani867/MSTRAT-Hiring-task.git
   cd mstart-task

2. تنزيل المكتبات باستخدام Composer:

composer install

3. نسخ ملف البيئة .env وتوليد المفتاح:

. Linux/macOS:

cp .env.example .env

. Windows CMD:

copy .env.example .env

ثم :

php artisan key:generate

4. تعديل ملف .env لإعدادات قاعدة البيانات.

5. شغيل الهجرات والبذور:

php artisan migrate 

6. تشغيل السيرفر المحلي:

php artisan serve

7. 🔐 التوثيق (اختياري)

تم استخدام Laravel Sanctum لحماية بعض مسارات API.

يمكن تسجيل الدخول واستعمال التوكن للتحقق من هوية المستخدم.

---

## 🔐 إعداد Laravel Sanctum (توثيق المستخدم)

### 1. تثبيت Sanctum

composer require laravel/sanctum

2. نشر ملفات الإعدادات

php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"

3. تنفيذ الهجرة

php artisan migrate





8. 💾 تصدير البيانات

تم استخدام مكتبة Maatwebsite Excel لتصدير المنتجات إلى ملفات CSV و Excel.

لتثبيتها:

composer require maatwebsite/excel

استخدم المسارات التالية لتصدير:
CSV:


GET /api/products/export/csv

Excel:

GET /api/products/export/excel



9. تفعيل Sanctum في app/Http/Kernel.php
php

'api' => [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],

10. استخدام Trait في موديل User

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}


11.  استخدام Postman لتجربة API
🔑 تسجيل مستخدم جديد

POST /api/register
Content-Type: application/json

{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password",
    "password_confirmation": "password"
}

12. 🔐 تسجيل دخول

POST /api/login
Content-Type: application/json

{
    "email": "test@example.com",
    "password": "password"
}
