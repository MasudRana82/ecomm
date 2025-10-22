<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get category IDs
        $honeyCategory = Category::where('name', 'Honey')->first();
        $gheeCategory = Category::where('name', 'Ghee & Butters')->first();
        $oilCategory = Category::where('name', 'Oils')->first();
        $spiceCategory = Category::where('name', 'Spices')->first();
        $nutsCategory = Category::where('name', 'Nuts & Seeds')->first();
        $dryFruitsCategory = Category::where('name', 'Dry Fruits')->first();
        $sweetenersCategory = Category::where('name', 'Sweeteners')->first();

        $products = [
            // Honey Products
            [
                'name' => 'Pure Wildflower Honey',
                'description' => '100% pure wildflower honey, natural and unprocessed. Rich in antioxidants and enzymes.',
                'short_description' => 'Natural wildflower honey',
                'price' => 350.00,
                'compare_price' => 400.00,
                'sku' => 'HNY-001',
                'quantity' => 50,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $honeyCategory->id
            ],
            [
                'name' => 'Manuka Honey UMF 10+',
                'description' => 'Premium manuka honey with UMF 10+ rating. Known for its health benefits.',
                'short_description' => 'Premium manuka honey',
                'price' => 1200.00,
                'compare_price' => null,
                'sku' => 'HNY-002',
                'quantity' => 20,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $honeyCategory->id
            ],
            [
                'name' => 'Acacia Honey',
                'description' => 'Light and delicate acacia honey with a subtle flavor. Perfect for daily use.',
                'short_description' => 'Light acacia honey',
                'price' => 450.00,
                'compare_price' => 500.00,
                'sku' => 'HNY-003',
                'quantity' => 30,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $honeyCategory->id
            ],
            
            // Ghee & Butters
            [
                'name' => 'Organic Cow Ghee',
                'description' => 'Pure organic ghee made from grass-fed cow milk. Rich in healthy fats and vitamins.',
                'short_description' => 'Pure organic cow ghee',
                'price' => 650.00,
                'compare_price' => null,
                'sku' => 'GGH-001',
                'quantity' => 40,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $gheeCategory->id
            ],
            [
                'name' => 'Desi Ghee (100% Pure)',
                'description' => 'Traditional desi ghee made using the ancient butter-churning method.',
                'short_description' => 'Traditional desi ghee',
                'price' => 750.00,
                'compare_price' => 800.00,
                'sku' => 'GGH-002',
                'quantity' => 35,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $gheeCategory->id
            ],
            
            // Oils
            [
                'name' => 'Cold-Pressed Mustard Oil',
                'description' => 'Pure cold-pressed mustard oil, unrefined and organic. Perfect for cooking.',
                'short_description' => 'Cold-pressed mustard oil',
                'price' => 220.00,
                'compare_price' => 250.00,
                'sku' => 'OIL-001',
                'quantity' => 100,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $oilCategory->id
            ],
            [
                'name' => 'Extra Virgin Olive Oil',
                'description' => 'Premium extra virgin olive oil, cold-pressed and organic. Rich in antioxidants.',
                'short_description' => 'Extra virgin olive oil',
                'price' => 1200.00,
                'compare_price' => null,
                'sku' => 'OIL-002',
                'quantity' => 25,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $oilCategory->id
            ],
            [
                'name' => 'Coconut Oil (Cold-Pressed)',
                'description' => 'Organic cold-pressed coconut oil, unrefined and virgin. Great for cooking and skin care.',
                'short_description' => 'Cold-pressed coconut oil',
                'price' => 280.00,
                'compare_price' => 320.00,
                'sku' => 'OIL-003',
                'quantity' => 60,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $oilCategory->id
            ],
            
            // Spices
            [
                'name' => 'Premium Turmeric Powder',
                'description' => 'Pure organic turmeric powder, rich in curcumin. Anti-inflammatory properties.',
                'short_description' => 'Pure turmeric powder',
                'price' => 150.00,
                'compare_price' => 180.00,
                'sku' => 'SPC-001',
                'quantity' => 80,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $spiceCategory->id
            ],
            [
                'name' => 'Ceylon Cinnamon Sticks',
                'description' => 'Premium Ceylon cinnamon sticks, known for their sweet and delicate flavor.',
                'short_description' => 'Ceylon cinnamon sticks',
                'price' => 350.00,
                'compare_price' => null,
                'sku' => 'SPC-002',
                'quantity' => 45,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $spiceCategory->id
            ],
            [
                'name' => 'Kashmiri Red Chilli Powder',
                'description' => 'Premium Kashmiri red chilli powder, vibrant red color with mild heat.',
                'short_description' => 'Kashmiri chilli powder',
                'price' => 200.00,
                'compare_price' => 240.00,
                'sku' => 'SPC-003',
                'quantity' => 55,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $spiceCategory->id
            ],
            
            // Nuts & Seeds
            [
                'name' => 'Premium California Almonds',
                'description' => 'Premium California almonds, rich in vitamin E and healthy fats.',
                'short_description' => 'California almonds',
                'price' => 750.00,
                'compare_price' => 800.00,
                'sku' => 'NTS-001',
                'quantity' => 70,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $nutsCategory->id
            ],
            [
                'name' => 'Premium Cashew Nuts',
                'description' => 'Premium cashew nuts, rich and buttery flavor. Great for snacking.',
                'short_description' => 'Premium cashews',
                'price' => 900.00,
                'compare_price' => null,
                'sku' => 'NTS-002',
                'quantity' => 40,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $nutsCategory->id
            ],
            [
                'name' => 'Organic Pumpkin Seeds',
                'description' => 'Organic pumpkin seeds, rich in zinc and magnesium.',
                'short_description' => 'Organic pumpkin seeds',
                'price' => 320.00,
                'compare_price' => 350.00,
                'sku' => 'NTS-003',
                'quantity' => 30,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $nutsCategory->id
            ],
            
            // Dry Fruits
            [
                'name' => 'Premium Iranian Dates',
                'description' => 'Premium Iranian dates, naturally sweet and rich in nutrients.',
                'short_description' => 'Iranian dates',
                'price' => 500.00,
                'compare_price' => 550.00,
                'sku' => 'DFR-001',
                'quantity' => 35,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $dryFruitsCategory->id
            ],
            [
                'name' => 'Premium Dried Figs',
                'description' => 'Premium dried figs, naturally sweet and rich in fiber.',
                'short_description' => 'Dried figs',
                'price' => 800.00,
                'compare_price' => null,
                'sku' => 'DFR-002',
                'quantity' => 20,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $dryFruitsCategory->id
            ],
            
            // Sweeteners
            [
                'name' => 'Organic Jaggery',
                'description' => 'Organic jaggery, unrefined sugar with minerals. Healthier alternative to white sugar.',
                'short_description' => 'Organic jaggery',
                'price' => 200.00,
                'compare_price' => 230.00,
                'sku' => 'SWG-001',
                'quantity' => 90,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $sweetenersCategory->id
            ]
        ];

        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'short_description' => $productData['short_description'],
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'sku' => $productData['sku'],
                'quantity' => $productData['quantity'],
                'is_active' => $productData['is_active'],
                'is_featured' => $productData['is_featured'],
                'category_id' => $productData['category_id'],
            ]);
        }
        
        // Create some additional demo products with images
        $demoProducts = [
            [
                'name' => 'Premium Raw Honey',
                'description' => '100% pure raw honey, unfiltered and unpasteurized preserving all natural enzymes and nutrients.',
                'short_description' => 'Raw and unprocessed honey',
                'price' => 400.00,
                'compare_price' => 450.00,
                'sku' => 'HNY-004',
                'quantity' => 25,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $honeyCategory->id
            ],
            [
                'name' => 'Organic Cold-Pressed Coconut Oil',
                'description' => 'Premium organic coconut oil, cold-pressed and unrefined. Perfect for cooking and skin care.',
                'short_description' => 'Organic coconut oil',
                'price' => 320.00,
                'compare_price' => null,
                'sku' => 'OIL-004',
                'quantity' => 40,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $oilCategory->id
            ],
            [
                'name' => 'Premium Kashmiri Saffron',
                'description' => 'The finest Kashmiri saffron threads, known for their rich color and aromatic flavor.',
                'short_description' => 'Premium saffron',
                'price' => 2500.00,
                'compare_price' => null,
                'sku' => 'SPC-004',
                'quantity' => 15,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $spiceCategory->id
            ],
            [
                'name' => 'Premium Walnuts (California)',
                'description' => 'Premium California walnuts, rich in omega-3 fatty acids and antioxidants.',
                'short_description' => 'California walnuts',
                'price' => 600.00,
                'compare_price' => 650.00,
                'sku' => 'NTS-004',
                'quantity' => 30,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $nutsCategory->id
            ],
            [
                'name' => 'Premium Iranian Raisins',
                'description' => 'Premium quality Iranian raisins, naturally sweet and plump.',
                'short_description' => 'Iranian raisins',
                'price' => 250.00,
                'compare_price' => 280.00,
                'sku' => 'DFR-003',
                'quantity' => 35,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $dryFruitsCategory->id
            ]
        ];
        
        foreach ($demoProducts as $productData) {
            Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'short_description' => $productData['short_description'],
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'sku' => $productData['sku'],
                'quantity' => $productData['quantity'],
                'is_active' => $productData['is_active'],
                'is_featured' => $productData['is_featured'],
                'category_id' => $productData['category_id']
            ]);
        }
        
        // Additional demo products for frontend display
        $additionalProducts = [
            [
                'name' => 'Organic Maple Syrup',
                'description' => 'Pure organic maple syrup from Canadian maple trees, rich and natural flavor.',
                'short_description' => 'Pure organic maple syrup',
                'price' => 850.00,
                'compare_price' => 950.00,
                'sku' => 'SWG-002',
                'quantity' => 25,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $sweetenersCategory->id
            ],
            [
                'name' => 'Premium Turmeric & Ginger Powder',
                'description' => 'Organic blend of turmeric and ginger powder with anti-inflammatory properties.',
                'short_description' => 'Turmeric & ginger blend',
                'price' => 280.00,
                'compare_price' => null,
                'sku' => 'SPC-005',
                'quantity' => 60,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $spiceCategory->id
            ],
            [
                'name' => 'Raw Almond Butter',
                'description' => 'Creamy raw almond butter made from premium California almonds, no added sugar.',
                'short_description' => 'Raw almond butter',
                'price' => 420.00,
                'compare_price' => 480.00,
                'sku' => 'NTS-005',
                'quantity' => 45,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $nutsCategory->id
            ],
            [
                'name' => 'Premium Mixed Dry Fruits',
                'description' => 'Assorted premium dry fruits including almonds, cashews, pistachios, and raisins.',
                'short_description' => 'Mixed dry fruits pack',
                'price' => 1200.00,
                'compare_price' => 1350.00,
                'sku' => 'DFR-004',
                'quantity' => 40,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $dryFruitsCategory->id
            ],
            [
                'name' => 'Cold-Pressed Sesame Oil',
                'description' => 'Organic cold-pressed sesame oil with rich, nutty flavor perfect for cooking.',
                'short_description' => 'Cold-pressed sesame oil',
                'price' => 300.00,
                'compare_price' => 350.00,
                'sku' => 'OIL-005',
                'quantity' => 35,
                'is_active' => true,
                'is_featured' => false,
                'category_id' => $oilCategory->id
            ],
            [
                'name' => 'Premium Matcha Green Tea',
                'description' => 'Highest quality ceremonial grade matcha green tea powder from Japan.',
                'short_description' => 'Ceremonial grade matcha',
                'price' => 1800.00,
                'compare_price' => null,
                'sku' => 'SPC-006',
                'quantity' => 20,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $spiceCategory->id
            ],
            [
                'name' => 'Organic Virgin Olive Oil',
                'description' => 'Premium organic extra virgin olive oil from Mediterranean olives.',
                'short_description' => 'Organic extra virgin olive oil',
                'price' => 950.00,
                'compare_price' => 1100.00,
                'sku' => 'OIL-006',
                'quantity' => 30,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $oilCategory->id
            ],
            [
                'name' => 'Premium Brazilian Coffee Beans',
                'description' => 'Premium quality Arabica coffee beans from Brazil with rich aroma and flavor.',
                'short_description' => 'Premium coffee beans',
                'price' => 750.00,
                'compare_price' => 850.00,
                'sku' => 'SPC-007',
                'quantity' => 25,
                'is_active' => true,
                'is_featured' => true,
                'category_id' => $spiceCategory->id
            ]
        ];
        
        foreach ($additionalProducts as $productData) {
            Product::create([
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => $productData['description'],
                'short_description' => $productData['short_description'],
                'price' => $productData['price'],
                'compare_price' => $productData['compare_price'],
                'sku' => $productData['sku'],
                'quantity' => $productData['quantity'],
                'is_active' => $productData['is_active'],
                'is_featured' => $productData['is_featured'],
                'category_id' => $productData['category_id']
            ]);
        }
    }
}
