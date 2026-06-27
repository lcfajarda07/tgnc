import { Head, Link } from '@inertiajs/react';
import { Activity, Banknote, CalendarDays, HeartHandshake, TrendingUp, Users } from 'lucide-react';
import StatCard from '../../Components/StatCard';
import AdminLayout from '../../Layouts/AdminLayout';

const icons = [Users, HeartHandshake, TrendingUp, Banknote, HeartHandshake, CalendarDays];

export default function Dashboard({ stats, branches, moduleCards, recentActivities }) {
    return (
        <AdminLayout title="Dashboard">
            <Head title="Dashboard" />
            <div className="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
                {stats.map((stat, index) => (
                    <StatCard key={stat.label} {...stat} icon={icons[index]} />
                ))}
            </div>

            <div className="mt-8 grid gap-6 xl:grid-cols-[1.2fr_0.8fr]">
                <section className="rounded-lg border border-slate-200 bg-white p-6 premium-shadow">
                    <p className="text-sm font-bold uppercase tracking-[0.16em] text-royal">Branch Comparison</p>
                    <h2 className="mt-2 font-display text-2xl font-extrabold">Global ministry health</h2>
                    <div className="mt-5 overflow-x-auto">
                        <table className="w-full min-w-[720px] text-left text-sm">
                            <thead>
                                <tr className="border-b border-slate-200 text-xs uppercase tracking-wide text-slate-500">
                                    <th className="py-3">Branch</th>
                                    <th>Pastor</th>
                                    <th>Members</th>
                                    <th>Visitors</th>
                                    <th>Events</th>
                                    <th>Prayer</th>
                                </tr>
                            </thead>
                            <tbody>
                                {branches.map((branch) => (
                                    <tr key={branch.id} className="border-b border-slate-100">
                                        <td className="py-4 font-bold">{branch.name}</td>
                                        <td>{branch.pastor_name}</td>
                                        <td>{branch.members_count}</td>
                                        <td>{branch.visitors_count}</td>
                                        <td>{branch.events_count}</td>
                                        <td>{branch.prayer_requests_count}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </section>

                <section className="rounded-lg border border-slate-200 bg-white p-6 premium-shadow">
                    <div className="mb-5 flex items-center gap-3">
                        <Activity className="h-5 w-5 text-royal" />
                        <h2 className="font-display text-2xl font-extrabold">Activity Timeline</h2>
                    </div>
                    <div className="space-y-4">
                        {recentActivities.map((activity) => (
                            <div key={activity.id} className="rounded-lg border border-slate-100 p-4">
                                <p className="text-sm font-bold text-slate-950">{activity.description}</p>
                                <p className="mt-1 text-xs font-semibold uppercase tracking-wide text-slate-400">{activity.module} | {activity.action}</p>
                            </div>
                        ))}
                    </div>
                </section>
            </div>

            <section className="mt-8 rounded-lg border border-slate-200 bg-white p-6 premium-shadow">
                <p className="text-sm font-bold uppercase tracking-[0.16em] text-royal">Modules</p>
                <h2 className="mt-2 font-display text-2xl font-extrabold">CMS workspace</h2>
                <div className="mt-5 grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                    {moduleCards.map((module) => (
                        <Link key={module.slug} href={`/admin/${module.slug}`} className="rounded-lg border border-slate-200 p-5 hover:border-royal hover:bg-royal/5">
                            <p className="text-sm font-bold text-slate-500">{module.title}</p>
                            <p className="mt-3 text-3xl font-extrabold text-slate-950">{module.count}</p>
                        </Link>
                    ))}
                </div>
            </section>
        </AdminLayout>
    );
}
