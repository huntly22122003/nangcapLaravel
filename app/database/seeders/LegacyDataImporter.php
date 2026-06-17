<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LegacyDataImporter extends Seeder
{
    public function run(): void
    {
        // === 1. Import Categories ===
        $oldCategories = DB::connection('mysql_legacy')->table('legacy_categories')->get();
        foreach ($oldCategories as $old) {
            DB::table('categories')->insert([
                'id' => $old->categoryID,
                'parent_id' => $old->categoryFold ?: null,
                'name' => $old->categoryname,
                'slug' => Str::slug($old->categoryname),
                'sort_order' => $old->categoryOrder ?? 0,
                'is_home' => false,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // === 2. Import Products ===
        $oldProducts = DB::connection('mysql_legacy')->table('legacy_products')->get();
        foreach ($oldProducts as $old) {
            DB::table('products')->insert([
                'id' => $old->productID,
                'category_id' => $old->categoryID ?: null,
                'name' => $old->procname ?? $old->productName,
                'extraname' => $old->extraname ?? null,
                'slug' => Str::slug($old->procname ?? $old->productName),
                'code' => $old->codeproc ?? null,
                'price' => $old->price,
                'brand' => $old->nhanhieu ?? null,
                'origin' => $old->xuatxu ?? null,
                'model_no' => $old->modelno ?? null,
                'summary' => $old->shortcontent ?? $old->summary,
                'description' => $old->content ?? $old->description,
                'technic_info' => $old->technicInfo ?? $old->technical_info ?? null,
                'thumbnail' => $old->picturepath ?? $old->image,
                'is_new' => $old->newproc ?? $old->is_new ?? false,
                'is_featured' => $old->banchay ?? $old->is_featured ?? false,
                'has_gallery' => $old->gallery ?? false,
                'sort_order' => $old->sothutu ?? 0,
                'is_active' => ($old->status == 1) ?? true,
                'created_at' => $old->date_added ?? now(),
                'updated_at' => $old->date_added ?? now(),
            ]);
        }

        // === 3. Import Posts ===
        $oldPosts = DB::connection('mysql_legacy')->table('legacy_posts')->get();
        foreach ($oldPosts as $old) {
            DB::table('posts')->insert([
                'id' => $old->newsID,
                'category_id' => $old->categoryID ?: null,
                'title' => $old->title,
                'slug' => Str::slug($old->title),
                'summary' => $old->summary,
                'content' => $old->content,
                'thumbnail' => $old->image,
                'published_at' => $old->published_date ?? now(),
                'is_active' => $old->status == 1,
                'created_at' => $old->published_date ?? now(),
                'updated_at' => $old->published_date ?? now(),
            ]);
        }

        // === 4. Import Pages (gioithieu) ===
        $oldPages = DB::connection('mysql_legacy')->table('legacy_pages')->get();
        foreach ($oldPages as $old) {
            DB::table('pages')->insert([
                'title' => $old->title ?? 'Giới thiệu',
                'slug' => Str::slug($old->title ?? 'gioi-thieu'),
                'summary' => null,
                'content' => $old->content,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // === 5. Import Galleries (thuvien) ===
        $oldGalleries = DB::connection('mysql_legacy')->table('legacy_galleries')->get();
        foreach ($oldGalleries as $old) {
            DB::table('galleries')->insert([
                'title' => $old->title ?? 'Hình ảnh',
                'image_path' => $old->image_path,
                'description' => $old->description,
                'sort_order' => $old->sort_order ?? 0,
                'is_active' => $old->status == 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // === 6. Import Customers (customers) ===
        $oldCustomers = DB::connection('mysql_legacy')->table('legacy_customers')->get();
        foreach ($oldCustomers as $old) {
            DB::table('customers')->insert([
                'id' => $old->cusID,
                'name' => $old->fullname ?? $old->cusname,
                'email' => $old->email,
                'phone' => $old->phone,
                'address' => $old->address,
                'created_at' => $old->reg_date ?? now(),
                'updated_at' => $old->reg_date ?? now(),
            ]);
        }

        // === 7. Import Orders (giohang) ===
        $oldOrders = DB::connection('mysql_legacy')->table('legacy_cart')->get();
        foreach ($oldOrders as $old) {
            $customerId = null;
            if ($old->customerID) {
                $customer = DB::table('customers')->where('id', $old->customerID)->first();
                $customerId = $customer->id ?? null;
            }

            $orderId = DB::table('orders')->insertGetId([
                'customer_id' => $customerId,
                'status' => 'completed',
                'total_amount' => $old->total ?? 0,
                'note' => null,
                'created_at' => $old->created_at ?? now(),
                'updated_at' => $old->created_at ?? now(),
            ]);

            DB::table('order_items')->insert([
                'order_id' => $orderId,
                'product_id' => $old->productID ?: null,
                'product_name' => $old->product_name ?? 'Sản phẩm',
                'quantity' => $old->quantity ?? 1,
                'price' => $old->price ?? 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // === 8. Import Banners (anhquangcao) ===
        $oldBanners = DB::connection('mysql_legacy')->table('legacy_banners')->get();
        foreach ($oldBanners as $old) {
            DB::table('banners')->insert([
                'title' => $old->title ?? null,
                'image_path' => $old->image,
                'link' => $old->link,
                'position' => $old->position ?? null,
                'sort_order' => $old->sort_order ?? 0,
                'is_active' => $old->status == 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // === 9. Import Menus (quantrimenu) ===
        $oldMenus = DB::connection('mysql_legacy')->table('legacy_menu')->get();
        foreach ($oldMenus as $old) {
            DB::table('menus')->insert([
                'name' => $old->menu_name,
                'link' => $old->link,
                'parent_id' => $old->parent_id ?: null,
                'sort_order' => $old->sort_order ?? 0,
                'position' => 'header',
                'is_active' => $old->status == 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // === 10. Import FAQs (hoidap) ===
        $oldFaqs = DB::connection('mysql_legacy')->table('legacy_faq')->get();
        foreach ($oldFaqs as $old) {
            DB::table('faqs')->insert([
                'question' => $old->question,
                'answer' => $old->answer,
                'sort_order' => 0,
                'is_active' => true,
                'created_at' => $old->created_at ?? now(),
                'updated_at' => $old->created_at ?? now(),
            ]);
        }

        // === 11. Import Contacts (lienhe) ===
        $oldContacts = DB::connection('mysql_legacy')->table('legacy_contacts')->get();
        foreach ($oldContacts as $old) {
            DB::table('contacts')->insert([
                'fullname' => $old->fullname,
                'email' => $old->email,
                'phone' => $old->phone,
                'subject' => $old->subject,
                'message' => $old->message,
                'is_read' => false,
                'created_at' => $old->created_at ?? now(),
                'updated_at' => $old->created_at ?? now(),
            ]);
        }

        // === 12. Import Registrations (dangky) ===
        $oldRegs = DB::connection('mysql_legacy')->table('legacy_registrations')->get();
        foreach ($oldRegs as $old) {
            DB::table('registrations')->insert([
                'email' => $old->email,
                'name' => $old->name,
                'phone' => $old->phone,
                'username' => $old->username ?? null,
                'session_id' => $old->session_id ?? null,
                'status' => $old->status ?? false,
                'created_at' => $old->reg_date ?? now(),
                'updated_at' => $old->reg_date ?? now(),
            ]);
        }

        // === 13. Import Members (thanhvien_tbl) ===
        // KHÔNG CÓ BẢNG legacy_members, BỎ QUA

        // === 14. Import Page Views (count + stats) ===
        // KHÔNG CÓ DỮ LIỆU, BỎ QUA

        // === Reset auto_increment cho tất cả bảng đã import ===
        $tables = [
            'categories', 'products', 'posts', 'pages', 'galleries',
            'customers', 'orders', 'order_items', 'banners', 'menus',
            'faqs', 'contacts', 'registrations'
        ];

        foreach ($tables as $table) {
            $maxId = DB::table($table)->max('id');
            if ($maxId) {
                DB::statement("ALTER TABLE {$table} AUTO_INCREMENT = " . ($maxId + 1));
            }
        }

        // Có thể reset members và page_views nếu muốn (nhưng chúng trống)
        // Nếu muốn reset, bỏ comment:
        // DB::statement('ALTER TABLE members AUTO_INCREMENT = 1');
        // DB::statement('ALTER TABLE page_views AUTO_INCREMENT = 1');
        // === Reset auto_increment (Cách 2: Các lệnh riêng lẻ - GIỮ NGUYÊN) ===
        DB::statement('ALTER TABLE members AUTO_INCREMENT = ' . (DB::table('members')->max('id') + 1));
        DB::statement('ALTER TABLE page_views AUTO_INCREMENT = ' . (DB::table('page_views')->max('id') + 1));

        DB::statement('ALTER TABLE categories AUTO_INCREMENT = ' . (DB::table('categories')->max('id') + 1));
        DB::statement('ALTER TABLE products AUTO_INCREMENT = ' . (DB::table('products')->max('id') + 1));
        DB::statement('ALTER TABLE posts AUTO_INCREMENT = ' . (DB::table('posts')->max('id') + 1));
        DB::statement('ALTER TABLE pages AUTO_INCREMENT = ' . (DB::table('pages')->max('id') + 1));
        DB::statement('ALTER TABLE galleries AUTO_INCREMENT = ' . (DB::table('galleries')->max('id') + 1));
        DB::statement('ALTER TABLE customers AUTO_INCREMENT = ' . (DB::table('customers')->max('id') + 1));
        DB::statement('ALTER TABLE orders AUTO_INCREMENT = ' . (DB::table('orders')->max('id') + 1));
        DB::statement('ALTER TABLE order_items AUTO_INCREMENT = ' . (DB::table('order_items')->max('id') + 1));
        DB::statement('ALTER TABLE banners AUTO_INCREMENT = ' . (DB::table('banners')->max('id') + 1));
        DB::statement('ALTER TABLE menus AUTO_INCREMENT = ' . (DB::table('menus')->max('id') + 1));
        DB::statement('ALTER TABLE faqs AUTO_INCREMENT = ' . (DB::table('faqs')->max('id') + 1));
        DB::statement('ALTER TABLE contacts AUTO_INCREMENT = ' . (DB::table('contacts')->max('id') + 1));
        DB::statement('ALTER TABLE registrations AUTO_INCREMENT = ' . (DB::table('registrations')->max('id') + 1));
    }
}