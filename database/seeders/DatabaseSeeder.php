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

        // slug => [عربي, English, كلمات الصورة]
        $catData = [
            'boys'        => ['ملابس أولادي', 'Boys Clothing', 'boy,kids,clothes'],
            'girls'       => ['ملابس بناتي', 'Girls Clothing', 'girl,kids,dress'],
            'baby'        => ['مستلزمات المواليد', 'Newborn Essentials', 'baby,newborn'],
            'shoes'       => ['أحذية الأطفال', 'Kids Shoes', 'kids,shoes,sneakers'],
            'toys'        => ['ألعاب وهدايا', 'Toys & Gifts', 'toys,blocks'],
            'accessories' => ['شنط وإكسسوارات', 'Bags & Accessories', 'kids,backpack,school'],
        ];

        $cats = [];
        $n = 1;
        foreach ($catData as $slug => [$ar, $en, $kw]) {
            $cats[$slug] = Category::updateOrCreate(['slug' => $slug], [
                'name' => $ar, 'name_en' => $en,
                'image' => "https://loremflickr.com/600/750/{$kw}?lock=".(100 + $n++),
            ]);
        }

        $clothes = ['2-3Y', '4-5Y', '6-7Y', '8-9Y'];
        $baby    = ['0-3M', '3-6M', '6-12M'];
        $shoes   = ['26', '27', '28', '29', '30'];

        $feat = [
            'cloth' => [
                'ar' => ['قطن ناعم يحافظ على راحة بشرة الطفل', 'خياطة مقواة تتحمل اللعب والغسيل المتكرر', 'ألوان ثابتة لا تبهت', 'مريح ومرن في الحركة'],
                'en' => ['Soft cotton that is gentle on skin', 'Reinforced stitching for play and frequent washing', 'Fade-resistant colors', 'Comfortable and flexible fit'],
                'care_ar' => "اغسل بالماء البارد على دورة لطيفة.\nلا تستخدم المبيضات.\nيُجفف في الظل ويُكوى على درجة حرارة منخفضة.",
                'care_en' => "Wash cold on a gentle cycle.\nDo not use bleach.\nDry in the shade and iron on low heat.",
            ],
            'other' => [
                'ar' => ['خامات آمنة ومناسبة للأطفال', 'جودة عالية وتصميم جذاب', 'سهل الاستخدام والتنظيف', 'هدية مثالية في كل المناسبات'],
                'en' => ['Safe materials made for kids', 'High quality and a lovely design', 'Easy to use and clean', 'A perfect gift for any occasion'],
                'care_ar' => "امسح بقطعة قماش مبللة قليلاً.\nلا تغمر المنتج في الماء.\nيُحفظ بعيداً عن أشعة الشمس المباشرة.",
                'care_en' => "Wipe with a slightly damp cloth.\nDo not submerge in water.\nKeep away from direct sunlight.",
            ],
        ];

        // cat, اسم ar, name en, وصف ar, short en, price, sale, age, gender, خامة ar, material en, sizes, colors, featured
        $items = [
            ['boys', 'طقم تيشيرت وشورت قطن للأولاد', 'Boys Cotton T-Shirt & Shorts Set', 'طقم صيفي مريح للعب والخروج', 'A comfortable summer set for play and outings', 350, 290, '2-9Y', 'boys', 'قطن 100%', '100% Cotton', $clothes, ['blue', 'white', 'gray'], 1],
            ['boys', 'جاكيت جينز للأولاد', 'Boys Denim Jacket', 'جاكيت جينز عصري ببطانة ناعمة', 'A modern denim jacket with a soft lining', 520, null, '4-9Y', 'boys', 'جينز قطني مرن', 'Stretch cotton denim', $clothes, ['blue', 'navy'], 0],
            ['boys', 'بنطلون جوجرز رياضي', 'Sport Joggers', 'بنطلون رياضي بخصر مطاطي مريح', 'Sport joggers with a comfy elastic waist', 280, null, '2-9Y', 'boys', 'قطن وبوليستر', 'Cotton & polyester', $clothes, ['gray', 'black', 'navy'], 0],
            ['girls', 'فستان صيفي مزهر للبنات', 'Girls Floral Summer Dress', 'فستان خفيف بطبعة ورود', 'A light dress with a floral print', 480, 399, '2-9Y', 'girls', 'قطن 100%', '100% Cotton', $clothes, ['pink', 'white', 'sky'], 1],
            ['girls', 'طقم بلوزة وجيبة', 'Blouse & Skirt Set', 'طقم أنيق للمناسبات والخروجات', 'An elegant set for occasions and outings', 430, null, '3-9Y', 'girls', 'قطن مع تول ناعم', 'Cotton with soft tulle', $clothes, ['pink', 'purple'], 1],
            ['girls', 'جاكيت صوف وردي', 'Pink Wool Jacket', 'جاكيت دافئ لأيام الشتاء', 'A warm jacket for winter days', 560, null, '2-8Y', 'girls', 'صوف ناعم', 'Soft wool', $clothes, ['pink', 'beige'], 0],
            ['baby', 'بودي قطن للمواليد (3 قطع)', 'Newborn Cotton Bodysuits (3 pcs)', 'ثلاث قطع بودي قطن بأزرار سهلة', 'Three cotton bodysuits with easy snaps', 260, null, '0-12M', 'unisex', 'قطن عضوي', 'Organic cotton', $baby, ['white', 'sky', 'pink'], 1],
            ['baby', 'بطانية ناعمة للمواليد', 'Soft Newborn Blanket', 'بطانية دافئة وخفيفة', 'A warm and lightweight blanket', 340, null, '0-24M', 'unisex', 'فليس ناعم', 'Soft fleece', [], ['beige', 'sky', 'pink'], 0],
            ['shoes', 'حذاء رياضي خفيف للأطفال', 'Lightweight Kids Sneakers', 'حذاء بنعل مرن مانع للانزلاق', 'Sneakers with a flexible anti-slip sole', 450, 380, '3-8Y', 'unisex', 'شبك قماش ونعل مطاطي', 'Mesh with rubber sole', $shoes, ['white', 'blue', 'pink'], 1],
            ['shoes', 'صندل صيفي مريح', 'Comfy Summer Sandals', 'صندل خفيف بحزام قابل للتعديل', 'Light sandals with an adjustable strap', 220, null, '2-8Y', 'unisex', 'جلد صناعي ناعم', 'Soft faux leather', $shoes, ['brown', 'navy'], 0],
            ['toys', 'مكعبات تركيب ملونة (100 قطعة)', 'Colorful Building Blocks (100 pcs)', 'مكعبات تنمّي الخيال والمهارات', 'Blocks that build imagination and skills', 320, 270, '3+Y', 'unisex', 'بلاستيك آمن خالٍ من BPA', 'Safe BPA-free plastic', [], [], 1],
            ['toys', 'دمية دب ناعمة', 'Soft Teddy Bear', 'دمية محشوة بخامة ناعمة وآمنة', 'A plush toy in a soft, safe fabric', 240, null, '1+Y', 'unisex', 'قطيفة ناعمة', 'Soft plush', [], ['beige', 'pink'], 0],
            ['accessories', 'حقيبة مدرسية بطبعة كرتونية', 'Cartoon Print School Backpack', 'حقيبة متعددة الجيوب بأحزمة مبطّنة', 'A multi-pocket bag with padded straps', 390, null, '5-10Y', 'unisex', 'قماش مقاوم للماء', 'Water-resistant fabric', [], ['blue', 'red', 'pink'], 0],
            ['accessories', 'كاب قطن بألوان مبهجة', 'Cheerful Cotton Cap', 'كاب خفيف يحمي من الشمس', 'A light cap that shields from the sun', 120, null, '3-10Y', 'unisex', 'قطن 100%', '100% Cotton', [], ['yellow', 'blue', 'red'], 0],
        ];

        $kw = ['boys' => 'boy,kids,clothes', 'girls' => 'girl,kids,dress', 'baby' => 'baby,clothes',
               'shoes' => 'kids,shoes', 'toys' => 'toys,kids', 'accessories' => 'kids,bag'];

        foreach ($items as $i => [$cat, $ar, $en, $sar, $sen, $price, $sale, $age, $gender, $mar, $men, $sizes, $colors, $featured]) {
            $f = in_array($cat, ['boys', 'girls', 'baby']) ? $feat['cloth'] : $feat['other'];
            Product::updateOrCreate(['slug' => 'item-'.($i + 1)], [
                'category_id' => $cats[$cat]->id,
                'name' => $ar, 'name_en' => $en,
                'sku' => 'SNF-'.str_pad((string) ($i + 1), 4, '0', STR_PAD_LEFT),
                'short_description' => $sar, 'short_description_en' => $sen,
                'description' => "{$ar} من سنفرو للأطفال. صُمم ليمنح طفلك الراحة والأمان طوال اليوم، مع اهتمام كبير بجودة الخامات والتفاصيل. مناسب للاستخدام اليومي ويصلح كهدية مميزة.",
                'description_en' => "{$en} by Snefro for Kids. Designed to keep your child comfortable and safe all day, with great care for materials and details. Perfect for everyday wear and a lovely gift.",
                'price' => $price, 'sale_price' => $sale, 'stock' => rand(6, 40),
                'age_range' => $age, 'gender' => $gender,
                'material' => $mar, 'material_en' => $men,
                'features' => $f['ar'], 'features_en' => $f['en'],
                'care' => $f['care_ar'], 'care_en' => $f['care_en'],
                'sizes' => $sizes, 'colors' => $colors,
                'images' => array_map(fn ($k) => "https://loremflickr.com/600/750/{$kw[$cat]}?lock=".(($i + 1) * 10 + $k), [1, 2, 3]),
                'is_active' => true, 'is_featured' => (bool) $featured,
            ]);
        }
    }
}
