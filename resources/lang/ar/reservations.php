<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Reservations Module Language Lines
    |--------------------------------------------------------------------------
    */

    // General
    'reservations' => 'الحجوزات',
    'reservation' => 'حجز',
    'create_reservation' => 'إنشاء حجز',
    'edit_reservation' => 'تعديل الحجز',
    'view_reservation' => 'عرض الحجز',
    'delete_reservation' => 'حذف الحجز',
    'reservation_details' => 'تفاصيل الحجز',
    'my_reservations' => 'حجوزاتي',
    'all_reservations' => 'جميع الحجوزات',

    // Fields
    'material' => 'المادة',
    'user' => 'المستخدم',
    'start_date' => 'تاريخ البدء',
    'end_date' => 'تاريخ الانتهاء',
    'period' => 'الفترة',
    'duration' => 'المدة',
    'quantity' => 'الكمية',
    'purpose' => 'الغرض',
    'notes' => 'ملاحظات',
    'status' => 'الحالة',

    // Status
    'pending' => 'قيد الانتظار',
    'approved' => 'موافق عليه',
    'rejected' => 'مرفوض',
    'completed' => 'مكتمل',
    'cancelled' => 'ملغى',

    // Messages
    'no_reservations' => 'لم يتم العثور على حجوزات.',
    'reservation_created' => 'تم إنشاء الحجز بنجاح!',
    'reservation_updated' => 'تم تحديث الحجز بنجاح!',
    'reservation_deleted' => 'تم حذف الحجز بنجاح!',
    'confirm_delete_reservation' => 'هل أنت متأكد من حذف هذا الحجز؟',

    // Actions
    'approve_reservation' => 'الموافقة على الحجز',
    'reject_reservation' => 'رفض الحجز',
    'cancel_reservation' => 'إلغاء الحجز',

    // Index Page
    'manage_reservations' => 'إدارة حجوزات المعدات',
    'filter_reservations' => 'تصفية الحجوزات',
    'search_reservations' => 'البحث بالمادة أو المستخدم أو الغرض...',
    'all_statuses' => 'جميع الحالات',
    'my_reservations_only' => 'حجوزاتي فقط',
    'apply_filters' => 'تطبيق الفلاتر',
    'clear_filters' => 'مسح الفلاتر',
    'clear_all_filters' => 'مسح جميع الفلاتر',
    'no_reservations_found' => 'لم يتم العثور على حجوزات',
    'no_reservations_status' => 'لا توجد حجوزات بهذه الحالة.',
    'no_reservations_yet' => 'لم تقم بأي حجوزات بعد.',
    'make_first_reservation' => 'احجز أول مرة',
    'active_reservations' => 'لديك :count حجوزات نشطة من أصل :limit كحد أقصى.',
    'showing' => 'عرض',
    'to' => 'إلى',
    'of' => 'من',

    // Calendar Page
    'reservations_calendar' => 'تقويم الحجوزات',
    'view_calendar_format' => 'عرض جميع الحجوزات بتنسيق التقويم',
    'list_view' => 'عرض القائمة',
    'calendar_view' => 'عرض التقويم',
    'today' => 'اليوم',
    'month' => 'الشهر',
    'week' => 'الأسبوع',
    'list' => 'قائمة',
    'rejected_cancelled' => 'مرفوض/ملغى',

    // Show Page
    'reserved_material' => 'المادة المحجوزة',
    'uncategorized' => 'غير مصنف',
    'view_material_details' => 'عرض تفاصيل المادة',
    'reservation_information' => 'معلومات الحجز',
    'days' => 'أيام',
    'created_at' => 'تاريخ الإنشاء',
    'additional_notes' => 'ملاحظات إضافية',
    'rejection_reason' => 'سبب الرفض',
    'rejection_optional' => 'سبب الرفض (اختياري)',
    'timeline' => 'الجدول الزمني',
    'reservation_created_label' => 'تم إنشاء الحجز',
    'reserved_by' => 'محجوز بواسطة',
    'unknown_user' => 'مستخدم غير معروف',
    'actions' => 'الإجراءات',
    'manager_actions' => 'إجراءات المدير',
    'admin' => 'مدير',
    'by' => 'بواسطة',

    // Create Page
    'create_new_reservation' => 'إنشاء حجز جديد',
    'create_for_user' => 'إنشاء حجز لأي مستخدم في النظام',
    'reserve_equipment' => 'حجز معدات المختبر لأبحاثك',
    'user_selection' => 'اختيار المستخدم',
    'select_user' => 'اختر المستخدم',
    'select_a_user' => 'اختر مستخدماً',
    'admin_note' => 'كمدير، يمكنك إنشاء حجوزات لأي مستخدم في النظام.',
    'equipment_selection' => 'اختيار المعدات',
    'material_equipment' => 'المادة / المعدات',
    'select_material' => 'اختر مادة',
    'available' => 'متوفر',
    'available_quantity' => 'الكمية المتوفرة',
    'select_dates' => 'اختر التواريخ',
    'start_time' => 'وقت البدء',
    'end_time' => 'وقت الانتهاء',
    'select_purpose' => 'اختر الغرض',
    'research' => 'بحث',
    'teaching' => 'تدريس',
    'personal' => 'شخصي',
    'other' => 'أخرى',
    'additional_details' => 'تفاصيل إضافية',
    'notes_placeholder' => 'أضف أي ملاحظات أو متطلبات إضافية...',
    'guidelines' => 'إرشادات',
    'check_availability' => 'تحقق من توفر المعدات قبل الحجز',
    'cancel_before_deadline' => 'يمكنك الإلغاء حتى 24 ساعة قبل وقت البدء',
    'follow_lab_rules' => 'اتبع جميع قواعد سلامة واستخدام المختبر',
    'reserve_responsible' => 'احجز المعدات بشكل مسؤول للسماح للآخرين باستخدامها',
    'cancel' => 'إلغاء',
    'create_reservation_btn' => 'إنشاء الحجز',
];
