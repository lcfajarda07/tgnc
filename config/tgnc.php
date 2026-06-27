<?php

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
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

return [
    'church_name' => 'THE GOOD NEWS OF CHRIST GLOBAL MINISTRIES',
    'tagline' => 'Winning the Lost at All Cost',
    'logo_path' => '/images/tgnc-seal.svg?v=faithful',
    'brand' => [
        'primary' => '#0B3D91',
        'secondary' => '#D4AF37',
        'background' => '#F8FAFC',
    ],
    'branches' => [
        ['name' => 'Pasig', 'code' => 'PASIG', 'pastor_name' => 'Senior Pastor', 'address' => 'Pasig City, Metro Manila', 'service_schedule' => 'Sunday Worship, 9:00 AM'],
        ['name' => 'Padilla', 'code' => 'PADILLA', 'pastor_name' => 'Branch Pastor', 'address' => 'Padilla, Rizal', 'service_schedule' => 'Sunday Worship, 9:00 AM'],
        ['name' => 'Montalban', 'code' => 'MONTALBAN', 'pastor_name' => 'Branch Pastor', 'address' => 'Montalban, Rizal', 'service_schedule' => 'Sunday Worship, 10:00 AM'],
        ['name' => 'Antipolo (Calawis)', 'code' => 'CALAWIS', 'pastor_name' => 'Branch Pastor', 'address' => 'Calawis, Antipolo City', 'service_schedule' => 'Sunday Worship, 9:30 AM'],
        ['name' => 'Basay, Negros', 'code' => 'BASAY', 'pastor_name' => 'Branch Pastor', 'address' => 'Basay, Negros Oriental', 'service_schedule' => 'Sunday Worship, 8:30 AM'],
    ],
    'modules' => [
        'branches' => ['title' => 'Branches', 'model' => Branch::class, 'permission' => 'branches.view', 'fields' => ['name', 'code', 'pastor_name', 'address', 'service_schedule', 'status']],
        'users' => ['title' => 'Users', 'model' => User::class, 'permission' => 'users.view', 'fields' => ['name', 'email', 'phone', 'status']],
        'roles' => ['title' => 'Roles', 'model' => Role::class, 'permission' => 'roles.view', 'fields' => ['name', 'guard_name']],
        'permissions' => ['title' => 'Permissions', 'model' => Permission::class, 'permission' => 'permissions.view', 'fields' => ['name', 'guard_name']],
        'members' => ['title' => 'Members', 'model' => Member::class, 'permission' => 'members.view', 'fields' => ['first_name', 'last_name', 'membership_status', 'phone', 'ministry', 'life_group']],
        'visitors' => ['title' => 'Visitors', 'model' => Visitor::class, 'permission' => 'visitors.view', 'fields' => ['name', 'phone', 'email', 'visited_at', 'status']],
        'families' => ['title' => 'Families', 'model' => Family::class, 'permission' => 'families.view', 'fields' => ['name', 'head_name', 'phone', 'address', 'status']],
        'attendance' => ['title' => 'Attendance', 'model' => Attendance::class, 'permission' => 'attendance.view', 'fields' => ['service_type', 'attended_at', 'check_in_method', 'notes']],
        'life-groups' => ['title' => 'Life Groups', 'model' => LifeGroup::class, 'permission' => 'life-groups.view', 'fields' => ['name', 'leader_name', 'schedule', 'location', 'status']],
        'ministries' => ['title' => 'Ministries', 'model' => Ministry::class, 'permission' => 'ministries.view', 'fields' => ['name', 'category', 'leader_name', 'status']],
        'events' => ['title' => 'Events', 'model' => ChurchEvent::class, 'permission' => 'events.view', 'fields' => ['title', 'starts_at', 'location', 'status']],
        'event-registration' => ['title' => 'Event Registration', 'model' => EventRegistration::class, 'permission' => 'event-registration.view', 'fields' => ['name', 'email', 'phone', 'status']],
        'finance' => ['title' => 'Finance', 'model' => FinanceRecord::class, 'permission' => 'finance.view', 'fields' => ['type', 'category', 'amount', 'transaction_date', 'source']],
        'prayer-requests' => ['title' => 'Prayer Requests', 'model' => PrayerRequest::class, 'permission' => 'prayer-requests.view', 'fields' => ['name', 'email', 'visibility', 'status']],
        'sermons' => ['title' => 'Sermons', 'model' => Sermon::class, 'permission' => 'sermons.view', 'fields' => ['title', 'speaker', 'scripture', 'preached_at', 'status']],
        'gallery' => ['title' => 'Gallery', 'model' => GalleryItem::class, 'permission' => 'gallery.view', 'fields' => ['title', 'category', 'taken_at', 'status']],
        'announcements' => ['title' => 'Announcements', 'model' => Announcement::class, 'permission' => 'announcements.view', 'fields' => ['title', 'audience', 'published_at', 'status']],
        'documents' => ['title' => 'Documents', 'model' => ChurchDocument::class, 'permission' => 'documents.view', 'fields' => ['title', 'category', 'file_url', 'status']],
        'audit-logs' => ['title' => 'Audit Logs', 'model' => AuditLog::class, 'permission' => 'audit-logs.view', 'fields' => ['action', 'module', 'description', 'created_at']],
    ],
    'virtual_modules' => [
        'dashboard' => 'Dashboard',
        'reports' => 'Reports',
        'settings' => 'Settings',
    ],
    'roles' => [
        'Super Admin',
        'Branch Admin',
        'Senior Pastor',
        'Associate Pastor',
        'Secretary',
        'Treasurer',
        'Finance Officer',
        'Ministry Leader',
        'Life Group Leader',
        'Media Team',
        'Volunteer',
        'Member',
    ],
];
