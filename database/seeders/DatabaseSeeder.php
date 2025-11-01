<?php

namespace Database\Seeders;

use App\Models\InnovacionView;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            /*
            DashboardTableSeeder::class,
            AnalyticsTableSeeder::class,
            FintechTableSeeder::class,
            CustomerSeeder::class,
            OrderSeeder::class,
            InvoiceSeeder::class,
            MemberSeeder::class,
            TransactionSeeder::class,
            JobSeeder::class,
            CampaignSeeder::class,
            MarketerSeeder::class,
            CampaignMarketerSeeder::class,
            */
            RoleSeeder::class,
            UsersSeeder::class,
            MessageSeeder::class,
            GeneralSeeder::class,
            CategorySeeder::class,
            StatusOrdensSeeder::class,
            AtributosSeeder::class,
            HomeViewSeeder::class,
            ProductosViewSeeder::class,
            InnovacionViewSeeder::class,
            NosotrosViewSeeder::class,
            ContactoViewSeeder::class,
            ServicesAndSubServicesSeeder::class

            //ServiceSeeder::class,
        ]);
    }
}
