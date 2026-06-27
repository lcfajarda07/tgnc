import { Link, router, usePage } from '@inertiajs/react';
import {
    Activity,
    Banknote,
    BookOpen,
    CalendarDays,
    Church,
    ClipboardList,
    FileText,
    GalleryHorizontal,
    Gauge,
    HeartHandshake,
    LogOut,
    Megaphone,
    ScrollText,
    Settings,
    ShieldCheck,
    Users,
} from 'lucide-react';
import SealLogo from '../Components/SealLogo';

const navigation = [
    ['Dashboard', '/admin', Gauge],
    ['Branches', '/admin/branches', Church],
    ['Users', '/admin/users', Users],
    ['Roles', '/admin/roles', ShieldCheck],
    ['Members', '/admin/members', Users],
    ['Visitors', '/admin/visitors', HeartHandshake],
    ['Attendance', '/admin/attendance', ClipboardList],
    ['Life Groups', '/admin/life-groups', HeartHandshake],
    ['Ministries', '/admin/ministries', Church],
    ['Events', '/admin/events', CalendarDays],
    ['Finance', '/admin/finance', Banknote],
    ['Prayer', '/admin/prayer-requests', HeartHandshake],
    ['Sermons', '/admin/sermons', BookOpen],
    ['Gallery', '/admin/gallery', GalleryHorizontal],
    ['Announcements', '/admin/announcements', Megaphone],
    ['Documents', '/admin/documents', FileText],
    ['Audit Logs', '/admin/audit-logs', Activity],
    ['Reports', '/admin/reports', ScrollText],
    ['Settings', '/admin/settings', Settings],
];

export default function AdminLayout({ title, children }) {
    const { auth, flash } = usePage().props;
    const path = window.location.pathname;

    return (
        <div className="min-h-screen bg-slate-100">
            <aside className="fixed inset-y-0 left-0 z-30 hidden w-72 flex-col bg-slate-950 text-white lg:flex">
                <div className="border-b border-white/10 p-6">
                    <SealLogo showText />
                    <div className="mt-5 rounded-lg bg-white/8 p-4">
                        <p className="text-sm font-semibold">{auth.user.name}</p>
                        <p className="mt-1 text-xs text-white/60">{auth.user.branch?.name ?? 'Global Dashboard'}</p>
                    </div>
                </div>
                <nav className="flex-1 overflow-y-auto px-4 py-5">
                    {navigation.map(([label, href, Icon]) => {
                        const active = path === href;

                        return (
                            <Link
                                key={href}
                                href={href}
                                className={`mb-1 flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-semibold transition ${
                                    active ? 'bg-white text-slate-950' : 'text-white/70 hover:bg-white/10 hover:text-white'
                                }`}
                            >
                                <Icon className="h-4 w-4" />
                                {label}
                            </Link>
                        );
                    })}
                </nav>
                <button
                    onClick={() => router.post('/logout')}
                    className="m-4 flex items-center gap-3 rounded-lg border border-white/10 px-3 py-3 text-left text-sm font-semibold text-white/75 hover:bg-white/10"
                >
                    <LogOut className="h-4 w-4" />
                    Logout
                </button>
            </aside>

            <main className="lg:pl-72">
                <header className="sticky top-0 z-20 border-b border-slate-200 bg-white/85 px-4 py-4 backdrop-blur md:px-8">
                    <div className="flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <p className="text-xs font-bold uppercase tracking-[0.2em] text-royal">TGNC CMS</p>
                            <h1 className="font-display text-2xl font-extrabold text-slate-950">{title}</h1>
                        </div>
                        <Link href="/" className="rounded-lg border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 hover:border-royal hover:text-royal">
                            View Website
                        </Link>
                    </div>
                </header>

                {flash.success && <div className="mx-4 mt-4 rounded-lg bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-700 md:mx-8">{flash.success}</div>}
                {flash.error && <div className="mx-4 mt-4 rounded-lg bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 md:mx-8">{flash.error}</div>}

                <div className="px-4 py-6 md:px-8">{children}</div>
            </main>
        </div>
    );
}
