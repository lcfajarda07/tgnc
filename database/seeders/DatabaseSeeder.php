<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Attendance;
use App\Models\AuditLog;
use App\Models\Branch;
use App\Models\ChurchDocument;
use App\Models\ChurchEvent;
use App\Models\EventRegistration;
use App\Models\Family;
use App\Models\FinanceRecord;
use App\Models\GalleryItem;
use App\Models\LifeGroup;
use App\Models\Member;
use App\Models\Ministry;
use App\Models\PrayerRequest;
use App\Models\Sermon;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $branches = collect(config('tgnc.branches'))->mapWithKeys(function (array $branch) {
            return [$branch['code'] => Branch::create($branch + [
                'phone' => '+63 900 000 0000',
                'email' => strtolower($branch['code']).'@tgnc.local',
                'photo_url' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80',
            ])];
        });

        $modules = array_keys(config('tgnc.modules'));
        $actions = ['view', 'create', 'update', 'delete', 'restore', 'force-delete', 'export', 'print'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::firstOrCreate(['name' => "{$module}.{$action}", 'guard_name' => 'web']);
            }
        }

        collect(config('tgnc.roles'))->each(fn (string $role) => Role::firstOrCreate(['name' => $role, 'guard_name' => 'web']));

        Role::findByName('Super Admin')->syncPermissions(Permission::all());
        Role::findByName('Branch Admin')->syncPermissions(Permission::whereNotIn('name', ['branches.force-delete'])->get());
        Role::findByName('Member')->syncPermissions(Permission::whereIn('name', ['events.view', 'sermons.view', 'gallery.view'])->get());

        $superAdmin = User::create([
            'name' => 'TGNC Super Admin',
            'email' => 'admin@tgnc.local',
            'phone' => '+63 900 111 0000',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);
        $superAdmin->assignRole('Super Admin');

        foreach ($branches as $code => $branch) {
            $admin = User::create([
                'branch_id' => $branch->id,
                'name' => "{$branch->name} Branch Admin",
                'email' => strtolower($code).'.admin@tgnc.local',
                'phone' => '+63 900 222 0000',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]);
            $admin->assignRole('Branch Admin');
        }

        $ministryNames = [
            ['Children', 'Next Gen', 'HeartHandshake'],
            ['Youth', 'Next Gen', 'Sparkles'],
            ["Women's", 'Discipleship', 'Users'],
            ["Men's", 'Discipleship', 'Shield'],
            ['Prayer', 'Care', 'HandHeart'],
            ['Media', 'Creative', 'Camera'],
            ['Worship', 'Creative', 'Music'],
            ['Evangelism', 'Outreach', 'Globe2'],
        ];

        foreach ($ministryNames as $index => [$name, $category, $icon]) {
            Ministry::create([
                'branch_id' => null,
                'name' => $name,
                'category' => $category,
                'icon' => $icon,
                'leader_name' => $index % 2 === 0 ? 'Ministry Leader' : 'Volunteer Team',
                'description' => "{$name} ministry serving TGNC families across all branches.",
                'sort_order' => $index + 1,
            ]);
        }

        foreach ($branches as $branch) {
            Family::create([
                'branch_id' => $branch->id,
                'name' => "{$branch->name} Covenant Family",
                'head_name' => 'Juan Dela Cruz',
                'phone' => '+63 917 000 0000',
                'address' => $branch->address,
            ]);

            LifeGroup::create([
                'branch_id' => $branch->id,
                'name' => "{$branch->name} Life Group",
                'leader_name' => 'Life Group Leader',
                'schedule' => 'Friday, 7:00 PM',
                'location' => $branch->address,
                'description' => 'Weekly discipleship, prayer, and care group.',
            ]);

            for ($i = 1; $i <= 5; $i++) {
                $member = Member::create([
                    'branch_id' => $branch->id,
                    'first_name' => fake()->firstName(),
                    'last_name' => fake()->lastName(),
                    'birthday' => now()->subYears(rand(18, 58))->subDays(rand(1, 300)),
                    'gender' => $i % 2 === 0 ? 'Female' : 'Male',
                    'civil_status' => 'Single',
                    'occupation' => fake()->jobTitle(),
                    'phone' => '+63 917 '.rand(100, 999).' '.rand(1000, 9999),
                    'email' => fake()->unique()->safeEmail(),
                    'address' => $branch->address,
                    'emergency_contact' => '+63 918 000 0000',
                    'membership_status' => $i === 5 ? 'care' : 'active',
                    'water_baptism' => $i % 2 === 0,
                    'holy_spirit_baptism' => $i % 3 === 0,
                    'ministry' => $ministryNames[$i % count($ministryNames)][0],
                    'life_group' => "{$branch->name} Life Group",
                ]);

                Attendance::create([
                    'branch_id' => $branch->id,
                    'member_id' => $member->id,
                    'service_type' => ['Sunday Worship', 'Prayer Meeting', 'Bible Study', 'Youth Fellowship'][$i % 4],
                    'attended_at' => now()->subDays($i),
                    'check_in_method' => 'manual',
                ]);
            }

            Visitor::create([
                'branch_id' => $branch->id,
                'name' => fake()->name(),
                'phone' => '+63 919 000 0000',
                'email' => fake()->unique()->safeEmail(),
                'visited_at' => now()->subDays(3),
                'source' => 'Invitation',
                'status' => 'follow-up',
                'notes' => 'Interested in joining a life group.',
            ]);

            $event = ChurchEvent::create([
                'branch_id' => $branch->id,
                'title' => "{$branch->name} Worship Night",
                'starts_at' => now()->addDays(rand(7, 30))->setTime(18, 0),
                'ends_at' => now()->addDays(rand(31, 45))->setTime(20, 0),
                'location' => $branch->address,
                'description' => 'A night of worship, prayer, and encouragement.',
                'capacity' => 120,
                'registration_required' => true,
                'image_url' => 'https://images.unsplash.com/photo-1516450360452-9312f5e86fc7?auto=format&fit=crop&w=1200&q=80',
            ]);

            EventRegistration::create([
                'branch_id' => $branch->id,
                'event_id' => $event->id,
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone' => '+63 920 000 0000',
            ]);

            FinanceRecord::create([
                'branch_id' => $branch->id,
                'type' => 'income',
                'category' => 'Tithes',
                'amount' => rand(5000, 25000),
                'transaction_date' => now()->subDays(rand(1, 15)),
                'source' => 'Sunday Worship',
                'recorded_by' => $superAdmin->id,
            ]);

            PrayerRequest::create([
                'branch_id' => $branch->id,
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'request' => 'Please pray for our family, provision, and spiritual strength.',
                'visibility' => 'pastoral',
                'status' => 'new',
            ]);
        }

        Sermon::insert([
            ['title' => 'Winning the Lost at All Cost', 'speaker' => 'Senior Pastor', 'scripture' => 'Luke 19:10', 'preached_at' => now()->subWeek(), 'video_url' => 'https://www.youtube.com/', 'thumbnail_url' => 'https://images.unsplash.com/photo-1507692049790-de58290a4334?auto=format&fit=crop&w=1200&q=80', 'summary' => 'A call to courageous evangelism and kingdom compassion.', 'status' => 'published', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'A House of Prayer', 'speaker' => 'Associate Pastor', 'scripture' => 'Isaiah 56:7', 'preached_at' => now()->subWeeks(2), 'video_url' => 'https://www.youtube.com/', 'thumbnail_url' => 'https://images.unsplash.com/photo-1519681393784-d120267933ba?auto=format&fit=crop&w=1200&q=80', 'summary' => 'Building a church culture rooted in prayer.', 'status' => 'published', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Rooted in Christ', 'speaker' => 'Senior Pastor', 'scripture' => 'Colossians 2:7', 'preached_at' => now()->subWeeks(3), 'video_url' => 'https://www.youtube.com/', 'thumbnail_url' => 'https://images.unsplash.com/photo-1490730141103-6cac27aaab94?auto=format&fit=crop&w=1200&q=80', 'summary' => 'Discipleship that grows deep and bears fruit.', 'status' => 'published', 'created_at' => now(), 'updated_at' => now()],
        ]);

        GalleryItem::insert([
            ['title' => 'Sunday Worship', 'category' => 'Worship', 'image_url' => 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1200&q=80', 'description' => 'TGNC gathered for worship.', 'taken_at' => now()->subDays(4), 'status' => 'published', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Youth Fellowship', 'category' => 'Youth', 'image_url' => 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80', 'description' => 'Young people growing together.', 'taken_at' => now()->subDays(8), 'status' => 'published', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'Prayer Gathering', 'category' => 'Prayer', 'image_url' => 'https://images.unsplash.com/photo-1491438590914-bc09fcaaf77a?auto=format&fit=crop&w=1200&q=80', 'description' => 'Intercession and encouragement.', 'taken_at' => now()->subDays(12), 'status' => 'published', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Announcement::create([
            'title' => 'Welcome to the TGNC Digital Ministry System',
            'body' => 'This dashboard is seeded with demo branches, members, attendance, finance, and ministry records.',
            'audience' => 'admins',
            'published_at' => now(),
            'status' => 'published',
        ]);

        ChurchDocument::create([
            'title' => 'Membership Covenant',
            'category' => 'Membership',
            'file_url' => '#',
            'status' => 'active',
        ]);

        AuditLog::create([
            'user_id' => $superAdmin->id,
            'action' => 'seed',
            'module' => 'system',
            'description' => 'TGNC demo data and permissions were created.',
        ]);
    }
}
