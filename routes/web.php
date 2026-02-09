<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

function setData(): void
{
    $data = [
        [
            'id' => 1,
            'type' => 'task_created',
            'actor' => 'محسن',
            'target' => 'ایجاد تسک ثبت‌نام',
            'timestamp' => '2025-01-01 09:00:00',
            'metadata' => json_encode(['اولویت' => 'بالا']),
        ],
        [
            'id' => 2,
            'type' => 'comment_added',
            'actor' => 'علی',
            'target' => 'تسک ثبت‌نام',
            'timestamp' => '2025-01-01 09:10:00',
            'metadata' => json_encode(['نظر' => 'بررسی شد']),
        ],
        [
            'id' => 3,
            'type' => 'task_created',
            'actor' => 'سارا',
            'target' => 'ایجاد تسک پرداخت',
            'timestamp' => '2025-01-02 10:00:00',
            'metadata' => json_encode(['اولویت' => 'متوسط']),
        ],
        [
            'id' => 4,
            'type' => 'comment_added',
            'actor' => 'رضا',
            'target' => 'تسک پرداخت',
            'timestamp' => '2025-01-02 10:15:00',
            'metadata' => json_encode(['نظر' => 'نیاز به اصلاح']),
        ],
        [
            'id' => 5,
            'type' => 'task_created',
            'actor' => 'نگار',
            'target' => 'ایجاد گزارش مالی',
            'timestamp' => '2025-01-03 11:00:00',
            'metadata' => json_encode(['بخش' => 'حسابداری']),
        ],
        [
            'id' => 6,
            'type' => 'comment_added',
            'actor' => 'محسن',
            'target' => 'گزارش مالی',
            'timestamp' => '2025-01-03 11:20:00',
            'metadata' => json_encode(['نظر' => 'اوکی شد']),
        ],
        [
            'id' => 7,
            'type' => 'task_created',
            'actor' => 'مریم',
            'target' => 'ایجاد کاربر جدید',
            'timestamp' => '2025-01-04 08:30:00',
            'metadata' => json_encode(['نقش' => 'اپراتور']),
        ],
        [
            'id' => 8,
            'type' => 'comment_added',
            'actor' => 'علی',
            'target' => 'کاربر جدید',
            'timestamp' => '2025-01-04 08:45:00',
            'metadata' => json_encode(['نظر' => 'دسترسی‌ها چک شود']),
        ],
        [
            'id' => 9,
            'type' => 'task_created',
            'actor' => 'رضا',
            'target' => 'تنظیمات صندوق',
            'timestamp' => '2025-01-05 12:00:00',
            'metadata' => json_encode(['ماژول' => 'POS']),
        ],
        [
            'id' => 10,
            'type' => 'comment_added',
            'actor' => 'سارا',
            'target' => 'تنظیمات صندوق',
            'timestamp' => '2025-01-05 12:10:00',
            'metadata' => json_encode(['نظر' => 'تست انجام شد']),
        ],

        // 11 → 25
        [
            'id' => 11,
            'type' => 'task_created',
            'actor' => 'محسن',
            'target' => 'ایجاد منوی رستوران',
            'timestamp' => '2025-01-06 09:00:00',
            'metadata' => json_encode(['وضعیت' => 'پیش‌نویس']),
        ],
        [
            'id' => 12,
            'type' => 'comment_added',
            'actor' => 'نگار',
            'target' => 'منوی رستوران',
            'timestamp' => '2025-01-06 09:20:00',
            'metadata' => json_encode(['نظر' => 'عالیه']),
        ],
        [
            'id' => 13,
            'type' => 'task_created',
            'actor' => 'علی',
            'target' => 'ثبت سفارش',
            'timestamp' => '2025-01-07 13:00:00',
            'metadata' => json_encode(['میز' => 4]),
        ],
        [
            'id' => 14,
            'type' => 'comment_added',
            'actor' => 'رضا',
            'target' => 'سفارش میز ۴',
            'timestamp' => '2025-01-07 13:05:00',
            'metadata' => json_encode(['نظر' => 'ارسال به آشپزخانه']),
        ],
        [
            'id' => 15,
            'type' => 'task_created',
            'actor' => 'مریم',
            'target' => 'تسویه حساب',
            'timestamp' => '2025-01-08 14:00:00',
            'metadata' => json_encode(['روش' => 'نقدی']),
        ],
        [
            'id' => 16,
            'type' => 'comment_added',
            'actor' => 'محسن',
            'target' => 'تسویه حساب',
            'timestamp' => '2025-01-08 14:10:00',
            'metadata' => json_encode(['نظر' => 'ثبت شد']),
        ],
        [
            'id' => 17,
            'type' => 'task_created',
            'actor' => 'سارا',
            'target' => 'گزارش فروش',
            'timestamp' => '2025-01-09 16:00:00',
            'metadata' => json_encode(['بازه' => 'روزانه']),
        ],
        [
            'id' => 18,
            'type' => 'comment_added',
            'actor' => 'علی',
            'target' => 'گزارش فروش',
            'timestamp' => '2025-01-09 16:15:00',
            'metadata' => json_encode(['نظر' => 'اعداد درست است']),
        ],
        [
            'id' => 19,
            'type' => 'task_created',
            'actor' => 'نگار',
            'target' => 'مدیریت انبار',
            'timestamp' => '2025-01-10 11:00:00',
            'metadata' => json_encode(['کالا' => 'برنج']),
        ],
        [
            'id' => 20,
            'type' => 'comment_added',
            'actor' => 'رضا',
            'target' => 'مدیریت انبار',
            'timestamp' => '2025-01-10 11:10:00',
            'metadata' => json_encode(['نظر' => 'موجودی کم است']),
        ],
        [
            'id' => 21,
            'type' => 'task_created',
            'actor' => 'محسن',
            'target' => 'تعریف تخفیف',
            'timestamp' => '2025-01-11 10:00:00',
            'metadata' => json_encode(['درصد' => 10]),
        ],
        [
            'id' => 22,
            'type' => 'comment_added',
            'actor' => 'سارا',
            'target' => 'تعریف تخفیف',
            'timestamp' => '2025-01-11 10:05:00',
            'metadata' => json_encode(['نظر' => 'فعال شد']),
        ],
        [
            'id' => 23,
            'type' => 'task_created',
            'actor' => 'علی',
            'target' => 'بستن شیفت',
            'timestamp' => '2025-01-12 23:00:00',
            'metadata' => json_encode(['شیفت' => 'شب']),
        ],
        [
            'id' => 24,
            'type' => 'comment_added',
            'actor' => 'محسن',
            'target' => 'بستن شیفت',
            'timestamp' => '2025-01-12 23:10:00',
            'metadata' => json_encode(['نظر' => 'ثبت نهایی']),
        ],
        [
            'id' => 25,
            'type' => 'task_created',
            'actor' => 'رضا',
            'target' => 'پشتیبان‌گیری',
            'timestamp' => '2025-01-13 02:00:00',
            'metadata' => json_encode(['وضعیت' => 'موفق']),
        ],
    ];

    foreach ($data as $row) {
        DB::table('activities')->updateOrInsert(
            ['id' => $row['id']],
            $row
        );
    }
}

//setData();

Route::get('/{any}', function () {
    return view('index');
})->where('any', '^(?!api/).*');

Route::prefix('api')->middleware('throttle:60,1')->group(base_path('routes/api.php'));
# require __DIR__.'/settings.php';

# Set-ExecutionPolicy RemoteSigned -Scope CurrentUser
