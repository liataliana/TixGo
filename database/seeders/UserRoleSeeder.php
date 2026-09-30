<?php
// [Magfi Adi Radza Putra] - Seeder untuk User, Category, dan Ticket
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\TixgoTicket;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        User::updateOrCreate(
            ['email' => 'admin@tixgo.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'role' => 'super_admin']
        );
        User::updateOrCreate(
            ['email' => 'manager@tixgo.com'],
            ['name' => 'Manager TixGo', 'password' => Hash::make('password'), 'role' => 'manager']
        );
        User::updateOrCreate(
            ['email' => 'user@tixgo.com'],
            ['name' => 'User Biasa', 'password' => Hash::make('password'), 'role' => 'user']
        );

        // Categories
        $categories = [
            ['name' => 'Penerbangan', 'icon' => 'fa-plane', 'description' => 'Tiket pesawat domestik & internasional'],
            ['name' => 'Kereta Api', 'icon' => 'fa-train', 'description' => 'Tiket kereta api seluruh Indonesia'],
            ['name' => 'Bus & Travel', 'icon' => 'fa-bus', 'description' => 'Tiket bus dan travel antar kota'],
            ['name' => 'Hotel', 'icon' => 'fa-hotel', 'description' => 'Reservasi hotel dan penginapan'],
            ['name' => 'Event & Konser', 'icon' => 'fa-music', 'description' => 'Tiket konser dan event spesial'],
        ];
        foreach ($categories as $cat) {
            Category::updateOrCreate(['name' => $cat['name']], $cat);
        }

        // Sample Tickets
        $tickets = [
            ['category' => 'Penerbangan', 'ticket_code' => 'TIX-FLY-001', 'name' => 'Jakarta → Bali (Garuda)', 'price' => 1500000, 'stock' => 50, 'location' => 'Bandara Soekarno-Hatta'],
            ['category' => 'Penerbangan', 'ticket_code' => 'TIX-FLY-002', 'name' => 'Jakarta → Surabaya (Lion Air)', 'price' => 850000, 'stock' => 80, 'location' => 'Bandara Soekarno-Hatta'],
            ['category' => 'Kereta Api', 'ticket_code' => 'TIX-TRN-001', 'name' => 'Argo Parahyangan (Bandung-Jakarta)', 'price' => 120000, 'stock' => 200, 'location' => 'Stasiun Bandung'],
            ['category' => 'Bus & Travel', 'ticket_code' => 'TIX-BUS-001', 'name' => 'Jakarta → Semarang (Pahala Kencana)', 'price' => 250000, 'stock' => 40, 'location' => 'Terminal Pulogebang'],
            ['category' => 'Event & Konser', 'ticket_code' => 'TIX-EVT-001', 'name' => 'Konser Coldplay Jakarta 2026', 'price' => 2500000, 'stock' => 500, 'location' => 'GBK Senayan Jakarta'],
        ];
        foreach ($tickets as $t) {
            $cat = Category::where('name', $t['category'])->first();
            if ($cat) {
                TixgoTicket::updateOrCreate(
                    ['ticket_code' => $t['ticket_code']],
                    [
                        'category_id' => $cat->id,
                        'name' => $t['name'],
                        'price' => $t['price'],
                        'stock' => $t['stock'],
                        'location' => $t['location'],
                        'is_active' => true,
                    ]
                );
            }
        }
    }
}