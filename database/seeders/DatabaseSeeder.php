<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@snefro.test'],
            ['name' => 'مدير سنفرو', 'password' => 'password', 'is_admin' => true]
        );

        // slug => [الاسم, كلمات البحث عن الصورة]
        $catData = [
            'boys'        => ['ملابس أولادي', 'boy,kids,clothes'],
            'girls'       => ['ملابس بناتي', 'girl,kids,dress'],
            'baby'        => ['مستلزمات المواليد', 'baby,newborn'],
            'shoes'       => ['أحذية الأطفال', 'kids,shoes,sneakers'],
            'toys'        => ['ألعاب وهدايا', 'toys,colorful,blocks'],
            'accessories' => ['شنط وإكسسوارات', 'kids,backpack,school'],
        ];

        $cats = [];
        $n = 1;
        foreach ($catData as $slug => [$name, $kw]) {
            $cats[$slug] = Category::updateOrCreate(['slug' => $slug], [
                'name' => $name,
                'image' => "https://loremflickr.com/600/600/{$kw}?lock=".(100 + $n++),
            ]);
        }

        $clothes = ['2-3 سنوات', '4-5 سنوات', '6-7 سنوات', '8-9 سنوات'];
        $baby    = ['0-3 شهور', '3-6 شهور', '6-12 شهر'];
        $shoes   = ['26', '27', '28', '29', '30'];

        $cloth_features = ['قطن ناعم يحافظ على راحة بشرة الطفل', 'خياطة مقواة تتحمل اللعب والغسيل المتكرر', 'ألوان ثابتة لا تبهت', 'مريح ومرن في الحركة'];
        $cloth_care = "اغسل بالماء البارد على دورة لطيفة.\nلا تستخدم المبيضات.\nيُجفف في الظل ويُكوى على درجة حرارة منخفضة.";
        $toy_care = "امسح بقطعة قماش مبللة قليلاً.\nلا تغمر المنتج في الماء.\nيُحفظ بعيداً عن أشعة الشمس المباشرة.";

        $items = [
            ['boys', 'طقم تيشيرت وشورت قطن للأولاد', 'طقم صيفي مريح بألوان مبهجة للعب والخروج', 350, 290, '2 - 9 سنوات', 'boys', 'قطن 100%', $clothes, ['أزرق', 'أبيض', 'رمادي'], 1],
            ['boys', 'جاكيت جينز للأولاد', 'جاكيت جينز عصري بخامة ناعمة وبطانة داخلية', 520, null, '4 - 9 سنوات', 'boys', 'جينز قطني مرن', $clothes, ['أزرق', 'كحلي'], 0],
            ['boys', 'بنطلون جوجرز رياضي', 'بنطلون رياضي بخصر مطاطي مريح لكل الأنشطة', 280, null, '2 - 9 سنوات', 'boys', 'قطن وبوليستر', $clothes, ['رمادي', 'أسود', 'كحلي'], 0],
            ['girls', 'فستان صيفي مزهر للبنات', 'فستان خفيف بطبعة ورود وتصميم واسع مريح', 480, 399, '2 - 9 سنوات', 'girls', 'قطن 100%', $clothes, ['وردي', 'أبيض', 'سماوي'], 1],
            ['girls', 'طقم بلوزة وجيبة', 'طقم أنيق للمناسبات والخروجات اليومية', 430, null, '3 - 9 سنوات', 'girls', 'قطن مع تول ناعم', $clothes, ['وردي', 'بنفسجي'], 1],
            ['girls', 'جاكيت صوف وردي', 'جاكيت دافئ بزراير لامعة لأيام الشتاء', 560, null, '2 - 8 سنوات', 'girls', 'صوف ناعم', $clothes, ['وردي', 'بيج'], 0],
            ['baby', 'بودي قطن للمواليد (3 قطع)', 'ثلاث قطع بودي قطن 100% بأزرار سهلة الفتح', 260, null, '0 - 12 شهر', 'unisex', 'قطن عضوي', $baby, ['أبيض', 'سماوي', 'وردي'], 1],
            ['baby', 'بطانية ناعمة للمواليد', 'بطانية مزدوجة الطبقات دافئة وخفيفة', 340, null, '0 - 24 شهر', 'unisex', 'فليس ناعم', [], ['بيج', 'سماوي', 'وردي'], 0],
            ['shoes', 'حذاء رياضي خفيف للأطفال', 'حذاء بنعل مرن مانع للانزلاق وإغلاق سهل', 450, 380, '3 - 8 سنوات', 'unisex', 'شبك قماش ونعل مطاطي', $shoes, ['أبيض', 'أزرق', 'وردي'], 1],
            ['shoes', 'صندل صيفي مريح', 'صندل خفيف بحزام قابل للتعديل', 220, null, '2 - 8 سنوات', 'unisex', 'جلد صناعي ناعم', $shoes, ['بني', 'كحلي'], 0],
            ['toys', 'مكعبات تركيب ملونة (100 قطعة)', 'مكعبات تنمّي الخيال والمهارات الحركية', 320, 270, '3+ سنوات', 'unisex', 'بلاستيك آمن خالٍ من BPA', [], [], 1],
            ['toys', 'دمية دب ناعمة', 'دمية محشوة بخامة ناعمة آمنة للأطفال', 240, null, 'من سنة', 'unisex', 'قطيفة ناعمة', [], ['بيج', 'وردي'], 0],
            ['accessories', 'حقيبة مدرسية بطبعة كرتونية', 'حقيبة متعددة الجيوب بأحزمة مبطّنة للكتف', 390, null, '5 - 10 سنوات', 'unisex', 'قماش مقاوم للماء', [], ['أزرق', 'أحمر', 'وردي'], 0],
            ['accessories', 'كاب قطن بألوان مبهجة', 'كاب خفيف يحمي من الشمس بمقاس قابل للتعديل', 120, null, '3 - 10 سنوات', 'unisex', 'قطن 100%', [], ['أصفر', 'أزرق', 'أحمر'], 0],
        ];

        $kw = [
            'boys' => 'boy,kids,clothes', 'girls' => 'girl,kids,dress', 'baby' => 'baby,clothes',
            'shoes' => 'kids,shoes', 'toys' => 'toys,kids', 'accessories' => 'kids,bag',
        ];

        foreach ($items as $i => [$cat, $name, $short, $price, $sale, $age, $gender, $material, $sizes, $colors, $featured]) {
            $isCloth = in_array($cat, ['boys', 'girls', 'baby']);
            $slug = "item-".($i + 1);
            Product::updateOrCreate(['slug' => $slug], [
                'category_id' => $cats[$cat]->id,
                'name' => $name,
                'sku' => 'SNF-'.str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'short_description' => $short,
                'description' => "{$name} من سنفرو للأطفال. صُمم ليمنح طفلك الراحة والأمان طوال اليوم، مع اهتمام كبير بجودة الخامات والتفاصيل. مناسب للاستخدام اليومي ويصلح كهدية مميزة.",
                'price' => $price,
                'sale_price' => $sale,
                'stock' => rand(6, 40),
                'age_range' => $age,
                'gender' => $gender,
                'material' => $material,
                'features' => $isCloth ? $cloth_features : ['خامات آمنة ومناسبة للأطفال', 'جودة عالية وتصميم جذاب', 'سهل الاستخدام والتنظيف', 'هدية مثالية في كل المناسبات'],
                'care' => $isCloth ? $cloth_care : $toy_care,
                'sizes' => $sizes,
                'colors' => $colors,
                'images' => array_map(fn ($k) => "https://loremflickr.com/600/750/{$kw[$cat]}?lock=".(($i + 1) * 10 + $k), [1, 2, 3]),
                'is_active' => true,
                'is_featured' => (bool) $featured,
            ]);
        }
    }
}
