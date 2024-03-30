<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateProductSalesSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        DB::statement('update products
        left join (select sum(order_items.quantity) as sales, product_id from order_items
        left join orders on orders.id = order_items.order_id and orders.order_status = 5
        group by product_id) as ps on ps.product_id = products.id
        set products.sales = ps.sales');
    }
}
