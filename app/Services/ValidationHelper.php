<?php

namespace App\Services;

use Illuminate\Validation\Rule;

class ValidationHelper
{
    /**
     * Get validation rules for user registration.
     */
    public static function getUserRegistrationRules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:admin,researcher,visitor,lab_manager',
            'orcid' => [
                'nullable',
                'regex:/^0000-\d{4}-\d{4}-\d{3}[X\d]$/',
                'unique:users,orcid'
            ],
            'phone' => [
                'nullable',
                'regex:/^\+[1-9]\d{1,14}$/',
                'max:20'
            ],
        ];
    }

    /**
     * Get validation rules for researcher profile.
     */
    public static function getResearcherRules(): array
    {
        return [
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'research_domain' => 'required|string|max:500',
            'google_scholar_url' => 'nullable|url|max:500',
            'bio_ar' => 'nullable|string|max:2000',
            'bio_fr' => 'nullable|string|max:2000',
            'bio_en' => 'nullable|string|max:2000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cv_file' => 'nullable|file|mimes:pdf|max:5120',
        ];
    }

    /**
     * Get validation rules for project creation.
     */
    public static function getProjectRules(): array
    {
        return [
            'title_ar' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string|max:2000',
            'description_fr' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'budget' => 'required|numeric|min:0|max:999999999.99',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after:start_date',
            'member_ids' => 'nullable|array',
            'member_ids.*' => 'exists:researchers,id',
        ];
    }

    /**
     * Get validation rules for publication.
     */
    public static function getPublicationRules(): array
    {
        return [
            'title' => 'required|string|max:500',
            'authors' => 'required|string|max:1000',
            'journal' => 'nullable|string|max:255',
            'conference' => 'nullable|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'doi' => [
                'nullable',
                'regex:/^10\.\d{4,}\/[-._;()\/:A-Za-z0-9]+$/',
                'unique:publications,doi'
            ],
            'publication_year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'volume' => 'nullable|string|max:50',
            'issue' => 'nullable|string|max:50',
            'pages' => 'nullable|string|max:50',
            'type' => 'required|in:article,conference,patent,book,poster',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'author_researchers' => 'nullable|array',
            'author_researchers.*.researcher_id' => 'required|exists:researchers,id',
            'author_researchers.*.author_order' => 'required|integer|min:1',
            'author_researchers.*.is_corresponding_author' => 'boolean',
        ];
    }

    /**
     * Get validation rules for equipment.
     */
    public static function getEquipmentRules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string|max:2000',
            'description_fr' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'serial_number' => [
                'nullable',
                'string',
                'max:100',
                'unique:equipment,serial_number'
            ],
            'category' => 'required|string|max:100',
            'location' => 'nullable|string|max:255',
            'purchase_date' => 'nullable|date|before_or_equal:today',
            'warranty_expiry' => 'nullable|date|after:purchase_date',
            'maintenance_schedule' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get validation rules for equipment reservation.
     */
    public static function getEquipmentReservationRules(): array
    {
        return [
            'equipment_id' => 'required|exists:equipment,id',
            'project_id' => 'nullable|exists:projects,id',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'purpose_ar' => 'nullable|string|max:500',
            'purpose_fr' => 'nullable|string|max:500',
            'purpose_en' => 'nullable|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get validation rules for event creation.
     */
    public static function getEventRules(): array
    {
        return [
            'title_ar' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'description_ar' => 'nullable|string|max:2000',
            'description_fr' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'type' => 'required|in:seminar,workshop,conference,summer_school,meeting,other',
            'start_date' => 'required|date|after:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'location_ar' => 'nullable|string|max:255',
            'location_fr' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'max_participants' => 'nullable|integer|min:1|max:10000',
            'registration_deadline' => 'nullable|date|before:start_date',
        ];
    }

    /**
     * Get validation rules for collaboration.
     */
    public static function getCollaborationRules(): array
    {
        return [
            'title_ar' => 'required|string|max:255',
            'title_fr' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'institution_name' => 'required|string|max:255',
            'country' => 'required|string|max:100',
            'contact_person' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'nullable|date|after:start_date',
            'type' => 'required|in:academic,industrial,governmental,international,other',
            'description_ar' => 'nullable|string|max:2000',
            'description_fr' => 'nullable|string|max:2000',
            'description_en' => 'nullable|string|max:2000',
            'coordinator_id' => 'required|exists:researchers,id',
        ];
    }

    /**
     * Get validation rules for funding source.
     */
    public static function getFundingSourceRules(): array
    {
        return [
            'name_ar' => 'required|string|max:255',
            'name_fr' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'type' => 'required|in:government,private,international,university,other',
            'contact_info' => 'nullable|string|max:1000',
            'website' => 'nullable|url|max:500',
        ];
    }

    /**
     * Get validation rules for project funding.
     */
    public static function getProjectFundingRules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'funding_source_id' => 'required|exists:funding_sources,id',
            'amount' => 'required|numeric|min:0|max:999999999.99',
            'currency' => 'required|string|size:3|in:DZD,USD,EUR,GBP',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'grant_number' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Validate DOI format.
     */
    public static function validateDOI(string $doi): bool
    {
        return preg_match('/^10\.\d{4,}\/[-._;()\/:A-Za-z0-9]+$/', $doi) === 1;
    }

    /**
     * Validate ORCID format.
     */
    public static function validateORCID(string $orcid): bool
    {
        return preg_match('/^0000-\d{4}-\d{4}-\d{3}[X\d]$/', $orcid) === 1;
    }

    /**
     * Validate international phone number format.
     */
    public static function validatePhoneNumber(string $phone): bool
    {
        return preg_match('/^\+[1-9]\d{1,14}$/', $phone) === 1;
    }

    /**
     * Get custom validation messages in Arabic.
     */
    public static function getCustomMessages(): array
    {
        return [
            'required' => 'الحقل :attribute مطلوب.',
            'string' => 'الحقل :attribute يجب أن يكون نص.',
            'max' => 'الحقل :attribute لا يجب أن يتجاوز :max حرف.',
            'min' => 'الحقل :attribute يجب أن يكون على الأقل :min حرف.',
            'email' => 'الحقل :attribute يجب أن يكون بريد إلكتروني صالح.',
            'unique' => 'الحقل :attribute مستخدم من قبل.',
            'confirmed' => 'تأكيد الحقل :attribute غير متطابق.',
            'date' => 'الحقل :attribute يجب أن يكون تاريخ صالح.',
            'after' => 'الحقل :attribute يجب أن يكون بعد :date.',
            'before' => 'الحقل :attribute يجب أن يكون قبل :date.',
            'numeric' => 'الحقل :attribute يجب أن يكون رقم.',
            'integer' => 'الحقل :attribute يجب أن يكون رقم صحيح.',
            'image' => 'الحقل :attribute يجب أن يكون صورة.',
            'mimes' => 'الحقل :attribute يجب أن يكون من نوع: :values.',
            'url' => 'الحقل :attribute يجب أن يكون رابط صالح.',
            'array' => 'الحقل :attribute يجب أن يكون مصفوفة.',
            'exists' => 'الحقل المحدد :attribute غير صالح.',
            'in' => 'الحقل المحدد :attribute غير صالح.',
            'boolean' => 'الحقل :attribute يجب أن يكون صحيح أو خطأ.',
            'size' => 'الحقل :attribute يجب أن يكون :size.',
            'regex' => 'تنسيق الحقل :attribute غير صالح.',
        ];
    }

    /**
     * Get custom attribute names in Arabic.
     */
    public static function getCustomAttributes(): array
    {
        return [
            'name' => 'الاسم',
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة المرور',
            'password_confirmation' => 'تأكيد كلمة المرور',
            'role' => 'الدور',
            'orcid' => 'ORCID',
            'phone' => 'رقم الهاتف',
            'first_name' => 'الاسم الأول',
            'last_name' => 'اسم العائلة',
            'research_domain' => 'مجال البحث',
            'google_scholar_url' => 'رابط Google Scholar',
            'bio_ar' => 'السيرة الذاتية (عربي)',
            'bio_fr' => 'السيرة الذاتية (فرنسي)',
            'bio_en' => 'السيرة الذاتية (إنجليزي)',
            'title_ar' => 'العنوان (عربي)',
            'title_fr' => 'العنوان (فرنسي)',
            'title_en' => 'العنوان (إنجليزي)',
            'description_ar' => 'الوصف (عربي)',
            'description_fr' => 'الوصف (فرنسي)',
            'description_en' => 'الوصف (إنجليزي)',
            'budget' => 'الميزانية',
            'start_date' => 'تاريخ البداية',
            'end_date' => 'تاريخ الانتهاء',
            'title' => 'العنوان',
            'authors' => 'المؤلفون',
            'journal' => 'المجلة',
            'conference' => 'المؤتمر',
            'publisher' => 'الناشر',
            'doi' => 'DOI',
            'publication_year' => 'سنة النشر',
            'type' => 'النوع',
            'equipment_id' => 'المعدة',
            'project_id' => 'المشروع',
            'start_datetime' => 'وقت البداية',
            'end_datetime' => 'وقت الانتهاء',
            'purpose_ar' => 'الغرض (عربي)',
            'purpose_fr' => 'الغرض (فرنسي)',
            'purpose_en' => 'الغرض (إنجليزي)',
            'notes' => 'ملاحظات',
            'location_ar' => 'الموقع (عربي)',
            'location_fr' => 'الموقع (فرنسي)',
            'location_en' => 'الموقع (إنجليزي)',
            'max_participants' => 'الحد الأقصى للمشاركين',
            'registration_deadline' => 'موعد انتهاء التسجيل',
            'institution_name' => 'اسم المؤسسة',
            'country' => 'البلد',
            'contact_person' => 'الشخص المسؤول',
            'contact_email' => 'البريد الإلكتروني للمسؤول',
            'coordinator_id' => 'المنسق',
            'amount' => 'المبلغ',
            'currency' => 'العملة',
            'grant_number' => 'رقم المنحة',
        ];
    }

    /**
     * Validate multilingual field (at least one language required).
     */
    public static function validateMultilingualField(array $data, string $fieldName): bool
    {
        $languages = ['ar', 'fr', 'en'];

        foreach ($languages as $lang) {
            $key = $fieldName . '_' . $lang;
            if (!empty($data[$key])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get multilingual validation rule.
     */
    public static function getMultilingualRule(string $fieldName, bool $required = true): array
    {
        $rules = [];
        $languages = ['ar', 'fr', 'en'];

        foreach ($languages as $lang) {
            $key = $fieldName . '_' . $lang;
            $rules[$key] = $required && $lang === 'ar' ? 'required|string|max:255' : 'nullable|string|max:255';
        }

        return $rules;
    }
}