<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CustomerAddress;
use App\Models\Subscription;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\PickupSchedule;
use App\Models\PickupRecord;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\CarbonImmutable;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // =====================================
        // 1. AKUN ADMIN, PELANGGAN, DAN PETUGAS
        // =====================================

        $admin = $this->saveUser(
            'Admin Bank Sampah',
            'admin@banksampah.test',
            '081234567801',
            'admin'
        );

        $pelanggan1 = $this->saveUser(
            'Budi Santoso',
            'budi@example.test',
            '081234567802',
            'user'
        );

        $pelanggan2 = $this->saveUser(
            'Siti Aminah',
            'siti@example.test',
            '081234567803',
            'user'
        );

        $petugas1 = $this->saveUser(
            'Andi Petugas',
            'andi@example.test',
            '081234567804',
            'petugas'
        );

        $petugas2 = $this->saveUser(
            'Rina Petugas',
            'rina@example.test',
            '081234567805',
            'petugas'
        );

        // =====================================
        // 2. ALAMAT PELANGGAN
        // =====================================

        $alamatBudi = CustomerAddress::updateOrCreate(
            [
                'user_id' => $pelanggan1->id,
                'label' => 'Rumah',
            ],
            [
                'recipient_name' => 'Budi Santoso',
                'phone' => '081234567802',
                'address' => 'Jl. Melati No. 10',
                'village' => 'Sukamaju',
                'district' => 'Weleri',
                'city' => 'Kendal',
                'province' => 'Jawa Tengah',
                'postal_code' => '51355',
                'latitude' => -6.9700000,
                'longitude' => 110.0660000,
                'is_primary' => true,
                'notes' => 'Rumah dengan pagar hitam',
            ]
        );

        $alamatSiti = CustomerAddress::updateOrCreate(
            [
                'user_id' => $pelanggan2->id,
                'label' => 'Rumah',
            ],
            [
                'recipient_name' => 'Siti Aminah',
                'phone' => '081234567803',
                'address' => 'Jl. Kenanga No. 5',
                'village' => 'Karangdowo',
                'district' => 'Weleri',
                'city' => 'Kendal',
                'province' => 'Jawa Tengah',
                'postal_code' => '51355',
                'latitude' => -6.9710000,
                'longitude' => 110.0670000,
                'is_primary' => true,
                'notes' => 'Hubungi sebelum penjemputan',
            ]
        );

        // =====================================
        // 3. LANGGANAN
        // =====================================

        $periodStart = CarbonImmutable::now()->startOfMonth();
        $periodEnd = $periodStart->addMonth();

        $subscriptionBudi = Subscription::updateOrCreate(
            ['user_id' => $pelanggan1->id],
            [
                'monthly_fee' => 25000,
                'status' => 'active',
                'started_at' => $periodStart,
                'current_period_start' => $periodStart,
                'current_period_end' => $periodEnd,
                'grace_until' => null,
                'suspended_at' => null,
                'cancelled_at' => null,
            ]
        );

        $subscriptionSiti = Subscription::updateOrCreate(
            ['user_id' => $pelanggan2->id],
            [
                'monthly_fee' => 25000,
                'status' => 'active',
                'started_at' => $periodStart,
                'current_period_start' => $periodStart,
                'current_period_end' => $periodEnd,
                'grace_until' => null,
                'suspended_at' => null,
                'cancelled_at' => null,
            ]
        );

        // =====================================
        // 4. TAGIHAN BULANAN
        // =====================================

        $invoiceBudi = Invoice::updateOrCreate(
            [
                'subscription_id' => $subscriptionBudi->id,
                'period_start' => $periodStart,
            ],
            [
                'invoice_number' => 'INV-BUDI-' . $periodStart->format('Ym'),
                'amount' => 25000,
                'period_end' => $periodEnd,
                'due_at' => $periodStart->addDays(7),
                'grace_until' => null,
                'status' => 'paid',
                'paid_at' => $periodStart->addDays(1),
            ]
        );

        $invoiceSiti = Invoice::updateOrCreate(
            [
                'subscription_id' => $subscriptionSiti->id,
                'period_start' => $periodStart,
            ],
            [
                'invoice_number' => 'INV-SITI-' . $periodStart->format('Ym'),
                'amount' => 25000,
                'period_end' => $periodEnd,
                'due_at' => $periodStart->addDays(7),
                'grace_until' => null,
                'status' => 'unpaid',
                'paid_at' => null,
            ]
        );

        // =====================================
        // 5. PEMBAYARAN MIDTRANS DUMMY
        // =====================================

        Payment::updateOrCreate(
            ['order_id' => 'ORDER-BUDI-' . $periodStart->format('Ym')],
            [
                'invoice_id' => $invoiceBudi->id,
                'transaction_id' => 'TRX-BUDI-' . $periodStart->format('Ym'),
                'payment_type' => 'bank_transfer',
                'transaction_status' => 'settlement',
                'fraud_status' => 'accept',
                'gross_amount' => 25000,
                'transaction_time' => $periodStart->addDays(1),
                'paid_at' => $periodStart->addDays(1),
                'notification_payload' => [
                    'demo' => true,
                    'status' => 'settlement',
                    'message' => 'Data simulasi, bukan transaksi Midtrans asli',
                ],
            ]
        );

        Payment::updateOrCreate(
            ['order_id' => 'ORDER-SITI-' . $periodStart->format('Ym')],
            [
                'invoice_id' => $invoiceSiti->id,
                'transaction_id' => null,
                'payment_type' => 'bank_transfer',
                'transaction_status' => 'pending',
                'fraud_status' => null,
                'gross_amount' => 25000,
                'transaction_time' => null,
                'paid_at' => null,
                'notification_payload' => [
                    'demo' => true,
                    'status' => 'pending',
                    'message' => 'Data simulasi pembayaran tertunda',
                ],
            ]
        );

        // =====================================
        // 6. JADWAL PENJEMPUTAN
        // =====================================

        $jadwalBudi = PickupSchedule::updateOrCreate(
            [
                'subscription_id' => $subscriptionBudi->id,
                'scheduled_for' => CarbonImmutable::now()
                    ->startOfDay()
                    ->addDays(2)
                    ->setTime(9, 0),
            ],
            [
                'address_id' => $alamatBudi->id,
                'assigned_to' => $petugas1->id,
                'status' => 'scheduled',
                'assigned_at' => CarbonImmutable::now(),
                'started_at' => null,
                'completed_at' => null,
                'notes' => 'Jemput sampah sesuai jadwal',
            ]
        );

        $jadwalSiti = PickupSchedule::updateOrCreate(
            [
                'subscription_id' => $subscriptionSiti->id,
                'scheduled_for' => CarbonImmutable::now()
                    ->startOfDay()
                    ->addDays()
                    ->setTime(10, 0),
            ],
            [
                'address_id' => $alamatSiti->id,
                'assigned_to' => $petugas2->id,
                'status' => 'completed',
                'assigned_at' => CarbonImmutable::now()->subDays(1),
                'started_at' => CarbonImmutable::now()->subDays(1),
                'completed_at' => CarbonImmutable::now()->subDays(1),
                'notes' => 'Penjemputan selesai',
            ]
        );

        // =====================================
        // 7. CATATAN HASIL PENJEMPUTAN
        // =====================================

        PickupRecord::updateOrCreate(
            ['pickup_schedule_id' => $jadwalSiti->id],
            [
                'organic_weight_kg' => 3.50,
                'inorganic_weight_kg' => 5.25,
                'photo_path' => null,
                'collected_at' => CarbonImmutable::now()->subDays(1),
                'notes' => 'Sampah ditimbang oleh petugas',
            ]
        );

        $this->command->info(
            'Seeder Bank Sampah Berlangganan berhasil dijalankan.'
        );

        $this->command->info(
            'Admin: admin@banksampah.test'
        );
        $this->command->info(
            'Pelanggan: budi@example.test, siti@example.test'
        );
        $this->command->info(
            'Petugas: andi@example.test, rina@example.test'
        );
        $this->command->info(
            'Password semua akun: password123'
        );
    }

    private function saveUser(
        string $name,
        string $email,
        string $phone,
        string $role
    ): User {
        $user = User::firstOrNew(['email' => $email]);

        $user->forceFill([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'password' => Hash::make('password123'),
            'role' => $role,
            'email_verified_at' => CarbonImmutable::now(),
        ])->save();

        return $user;
    }
}
