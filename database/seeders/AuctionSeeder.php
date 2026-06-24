<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Bid;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AuctionSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Watches & Jewelry', 'slug' => 'watches-jewelry', 'icon' => '⌚', 'color' => 'amber'],
            ['name' => 'Art & Collectibles', 'slug' => 'art-collectibles', 'icon' => '🎨', 'color' => 'violet'],
            ['name' => 'Electronics', 'slug' => 'electronics', 'icon' => '💻', 'color' => 'cyan'],
            ['name' => 'Vehicles', 'slug' => 'vehicles', 'icon' => '🚗', 'color' => 'emerald'],
            ['name' => 'Real Estate', 'slug' => 'real-estate', 'icon' => '🏠', 'color' => 'rose'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => '👗', 'color' => 'pink'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }

        $auctions = [
            [
                'category' => 'watches-jewelry',
                'title' => 'Rolex Submariner Date — 2021',
                'description' => 'Authentic Rolex Submariner Date in stainless steel with black ceramic bezel. Complete with box, papers, and warranty card. Immaculate condition with minimal wear.',
                'image' => 'https://images.unsplash.com/photo-1523170335258-f5ed11844a49?w=800&q=80',
                'starting_price' => 8500,
                'current_price' => 12400,
                'bid_increment' => 200,
                'bid_count' => 47,
                'watchers' => 312,
                'featured' => true,
                'ends_at' => now()->addDays(2)->addHours(14),
            ],
            [
                'category' => 'art-collectibles',
                'title' => 'Original Abstract Canvas — Limited Edition',
                'description' => 'Stunning 48×36 inch original abstract painting by emerging artist. Signed and numbered 12/50. Certificate of authenticity included.',
                'image' => 'https://images.unsplash.com/photo-1541961017774-22349e4a1262?w=800&q=80',
                'starting_price' => 1200,
                'current_price' => 3850,
                'bid_increment' => 100,
                'bid_count' => 23,
                'watchers' => 156,
                'featured' => true,
                'ends_at' => now()->addDays(1)->addHours(8),
            ],
            [
                'category' => 'electronics',
                'title' => 'MacBook Pro 16" M3 Max — Sealed',
                'description' => 'Brand new, factory sealed MacBook Pro 16-inch with M3 Max chip, 48GB RAM, 1TB SSD. Space Black. Full Apple warranty.',
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&q=80',
                'starting_price' => 2800,
                'current_price' => 3450,
                'bid_increment' => 50,
                'bid_count' => 31,
                'watchers' => 289,
                'featured' => true,
                'ends_at' => now()->addHours(18),
            ],
            [
                'category' => 'vehicles',
                'title' => '2023 Porsche 911 Carrera S',
                'description' => 'Low mileage Porsche 911 Carrera S in Guards Red. Sport Chrono Package, PASM, premium sound. Full service history. One owner.',
                'image' => 'https://images.unsplash.com/photo-1503376780353-7e6692767b70?w=800&q=80',
                'starting_price' => 95000,
                'current_price' => 112500,
                'bid_increment' => 1000,
                'bid_count' => 18,
                'watchers' => 445,
                'featured' => false,
                'ends_at' => now()->addDays(5),
            ],
            [
                'category' => 'real-estate',
                'title' => 'Luxury Penthouse — Downtown Dubai',
                'description' => '3-bedroom penthouse with panoramic city views. 2,800 sq ft, private terrace, smart home system. Prime location near Burj Khalifa.',
                'image' => 'https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=800&q=80',
                'starting_price' => 850000,
                'current_price' => 920000,
                'bid_increment' => 5000,
                'bid_count' => 12,
                'watchers' => 678,
                'featured' => false,
                'ends_at' => now()->addDays(7),
            ],
            [
                'category' => 'fashion',
                'title' => 'Hermès Birkin 30 — Togo Leather',
                'description' => 'Authentic Hermès Birkin 30 in Etoupe Togo leather with palladium hardware. Includes dust bag, box, and receipt from boutique.',
                'image' => 'https://images.unsplash.com/photo-1584917865442-de89df76a062?w=800&q=80',
                'starting_price' => 12000,
                'current_price' => 18750,
                'bid_increment' => 250,
                'bid_count' => 39,
                'watchers' => 521,
                'featured' => false,
                'ends_at' => now()->addDays(3),
            ],
            [
                'category' => 'watches-jewelry',
                'title' => 'Cartier Love Bracelet — 18K Gold',
                'description' => 'Iconic Cartier Love bracelet in 18K yellow gold, size 17. Comes with screwdriver and original red box. Excellent condition.',
                'image' => 'https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=800&q=80',
                'starting_price' => 4500,
                'current_price' => 6200,
                'bid_increment' => 100,
                'bid_count' => 28,
                'watchers' => 198,
                'featured' => false,
                'ends_at' => now()->addHours(6),
            ],
            [
                'category' => 'electronics',
                'title' => 'Sony A7R V Camera Kit + Lenses',
                'description' => 'Professional mirrorless camera kit: Sony A7R V body, 24-70mm f/2.8 GM II, 70-200mm f/2.8 GM II. Like new, under 500 shutter count.',
                'image' => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc7c?w=800&q=80',
                'starting_price' => 5500,
                'current_price' => 7100,
                'bid_increment' => 100,
                'bid_count' => 15,
                'watchers' => 134,
                'featured' => false,
                'ends_at' => now()->addDays(4),
            ],
            [
                'category' => 'art-collectibles',
                'title' => 'Vintage Persian Rug — Hand-Knotted',
                'description' => 'Authentic 19th-century Persian Tabriz rug, 9×12 feet. Natural dyes, intricate floral pattern. Professionally cleaned and appraised.',
                'image' => 'https://images.unsplash.com/photo-1600166898405-da9535204843?w=800&q=80',
                'starting_price' => 8000,
                'current_price' => 11500,
                'bid_increment' => 200,
                'bid_count' => 9,
                'watchers' => 87,
                'featured' => false,
                'ends_at' => now()->addDays(6),
            ],
            [
                'category' => 'vehicles',
                'title' => 'Tesla Model S Plaid — 2024',
                'description' => '2024 Tesla Model S Plaid in Pearl White. Full self-driving, 21" Arachnid wheels. Only 3,200 miles. Transferable warranty.',
                'image' => 'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=800&q=80',
                'starting_price' => 72000,
                'current_price' => 78500,
                'bid_increment' => 500,
                'bid_count' => 22,
                'watchers' => 367,
                'featured' => false,
                'ends_at' => now()->addDays(2),
            ],
        ];

        foreach ($auctions as $data) {
            $category = Category::where('slug', $data['category'])->first();
            unset($data['category']);

            $auction = Auction::create([
                ...$data,
                'category_id' => $category->id,
                'slug' => Str::slug($data['title']),
                'status' => 'live',
            ]);

            $bidders = ['Ahmed K.', 'Sarah M.', 'James L.', 'Fatima R.', 'Omar H.'];
            for ($i = 0; $i < min(5, $auction->bid_count); $i++) {
                Bid::create([
                    'auction_id' => $auction->id,
                    'bidder_name' => $bidders[$i % count($bidders)],
                    'bidder_email' => 'bidder'.($i + 1).'@example.com',
                    'amount' => $auction->starting_price + ($auction->bid_increment * ($i + 1)),
                    'is_winning' => $i === min(4, $auction->bid_count - 1),
                ]);
            }
        }
    }
}
