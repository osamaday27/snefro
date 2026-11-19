<?php

return [
    'required' => 'حقل :attribute مطلوب.',
    'email'    => 'من فضلك أدخل بريداً إلكترونياً صحيحاً.',
    'string'   => 'حقل :attribute يجب أن يكون نصاً.',
    'numeric'  => 'حقل :attribute يجب أن يكون رقماً.',
    'integer'  => 'حقل :attribute يجب أن يكون رقماً صحيحاً.',
    'image'    => 'حقل :attribute يجب أن يكون صورة.',
    'regex'    => 'صيغة :attribute غير صحيحة.',
    'exists'   => 'القيمة المختارة في :attribute غير صالحة.',
    'in'       => 'القيمة المختارة في :attribute غير صالحة.',
    'uploaded' => 'فشل رفع :attribute.',
    'min' => [
        'string'  => 'يجب ألا يقل :attribute عن :min أحرف.',
        'numeric' => 'يجب ألا تقل قيمة :attribute عن :min.',
        'array'   => 'يجب اختيار :min عناصر على الأقل في :attribute.',
        'file'    => 'يجب ألا يقل حجم :attribute عن :min كيلوبايت.',
    ],
    'max' => [
        'string'  => 'يجب ألا يزيد :attribute عن :max حرفاً.',
        'numeric' => 'يجب ألا تزيد قيمة :attribute عن :max.',
        'array'   => 'يجب ألا يزيد عدد عناصر :attribute عن :max.',
        'file'    => 'يجب ألا يزيد حجم :attribute عن :max كيلوبايت.',
    ],
    'lt' => ['numeric' => 'يجب أن يكون :attribute أقل من :value.'],
    'attributes' => [
        'customer_name' => 'الاسم', 'phone' => 'رقم الهاتف', 'email' => 'البريد الإلكتروني',
        'address' => 'العنوان', 'city' => 'المحافظة', 'notes' => 'الملاحظات', 'name' => 'الاسم',
        'name_en' => 'الاسم بالإنجليزية', 'price' => 'السعر', 'sale_price' => 'سعر الخصم', 'stock' => 'المخزون',
        'category_id' => 'القسم', 'photos.*' => 'الصورة', 'photo' => 'الصورة', 'password' => 'كلمة المرور',
        'age_range' => 'الفئة العمرية', 'material' => 'الخامة', 'gender' => 'النوع',
    ],
];
