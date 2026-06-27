import { Head, Link, router } from '@inertiajs/react';
import { Download, FileText, Printer, Search, SlidersHorizontal } from 'lucide-react';
import AdminLayout from '../../Layouts/AdminLayout';

export default function Module({ module, rows, filters, branches }) {
    const applyFilter = (event) => {
        event.preventDefault();
        const form = new FormData(event.currentTarget);
        router.get(`/admin/${module.slug}`, Object.fromEntries(form.entries()), { preserveState: true, replace: true });
    };

    return (
        <AdminLayout title={module.title}>
            <Head title={module.title} />
            <section className="rounded-lg border border-slate-200 bg-white p-6 premium-shadow">
                <div className="mb-6 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p className="text-sm font-bold uppercase tracking-[0.16em] text-royal">CMS Module</p>
                        <h2 className="mt-2 font-display text-3xl font-extrabold">{module.title}</h2>
                        <p className="mt-2 text-sm text-slate-500">Server-side pagination, search, filters, exports, and branch-aware data.</p>
                    </div>
                    <div className="flex flex-wrap gap-2">
                        <a href={`/admin/${module.slug}/export/csv`} className="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 hover:border-royal hover:text-royal">
                            <Download className="h-4 w-4" /> CSV
                        </a>
                        <a href={`/admin/${module.slug}/export/pdf`} className="inline-flex items-center gap-2 rounded-lg border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 hover:border-royal hover:text-royal">
                            <FileText className="h-4 w-4" /> PDF
                        </a>
                        <a href={`/admin/${module.slug}/export/print`} className="inline-flex items-center gap-2 rounded-lg bg-royal px-4 py-2 text-sm font-bold text-white">
                            <Printer className="h-4 w-4" /> Print
                        </a>
                    </div>
                </div>

                <form onSubmit={applyFilter} className="mb-6 grid gap-3 rounded-lg bg-slate-50 p-4 md:grid-cols-[1fr_220px_180px_auto]">
                    <label className="relative">
                        <Search className="pointer-events-none absolute left-3 top-3.5 h-4 w-4 text-slate-400" />
                        <input name="search" defaultValue={filters.search ?? ''} className="w-full rounded-lg border border-slate-200 py-3 pl-10 pr-4 text-sm outline-none focus:border-royal" placeholder="Search records" />
                    </label>
                    <select name="branch_id" defaultValue={filters.branch_id ?? ''} className="rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-royal">
                        <option value="">All branches</option>
                        {branches.map((branch) => <option key={branch.id} value={branch.id}>{branch.name}</option>)}
                    </select>
                    <select name="status" defaultValue={filters.status ?? ''} className="rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-royal">
                        <option value="">Any status</option>
                        <option value="active">Active</option>
                        <option value="published">Published</option>
                        <option value="new">New</option>
                        <option value="draft">Draft</option>
                    </select>
                    <button className="inline-flex items-center justify-center gap-2 rounded-lg bg-slate-950 px-4 py-3 text-sm font-extrabold text-white">
                        <SlidersHorizontal className="h-4 w-4" /> Filter
                    </button>
                </form>

                <div className="overflow-x-auto">
                    <table className="w-full min-w-[860px] text-left text-sm">
                        <thead>
                            <tr className="border-b border-slate-200 bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
                                {module.fields.map((field) => (
                                    <th key={field} className="px-4 py-3">{field.replaceAll('_', ' ')}</th>
                                ))}
                                <th className="px-4 py-3">Created</th>
                                <th className="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {rows.data.map((row) => (
                                <tr key={row.id} className="border-b border-slate-100">
                                    {module.fields.map((field) => (
                                        <td key={field} className="px-4 py-4 text-slate-700">{row[field] ?? '-'}</td>
                                    ))}
                                    <td className="px-4 py-4 text-slate-500">{row.created_at}</td>
                                    <td className="px-4 py-4 text-right">
                                        <button className="rounded-lg border border-slate-200 px-3 py-1.5 text-xs font-bold text-slate-600">View</button>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>

                <div className="mt-6 flex flex-wrap gap-2">
                    {rows.links.map((link, index) => (
                        <Link
                            key={`${link.label}-${index}`}
                            href={link.url ?? '#'}
                            preserveScroll
                            className={`rounded-lg border px-3 py-2 text-sm font-bold ${
                                link.active ? 'border-royal bg-royal text-white' : 'border-slate-200 text-slate-600 hover:border-royal'
                            } ${!link.url ? 'pointer-events-none opacity-40' : ''}`}
                            dangerouslySetInnerHTML={{ __html: link.label }}
                        />
                    ))}
                </div>
            </section>
        </AdminLayout>
    );
}
