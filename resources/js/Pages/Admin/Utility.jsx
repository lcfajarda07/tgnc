import { Head } from '@inertiajs/react';
import { CheckCircle2 } from 'lucide-react';
import AdminLayout from '../../Layouts/AdminLayout';

export default function Utility({ title, eyebrow, items }) {
    return (
        <AdminLayout title={title}>
            <Head title={title} />
            <section className="rounded-lg border border-slate-200 bg-white p-6 premium-shadow">
                <p className="text-sm font-bold uppercase tracking-[0.16em] text-royal">{eyebrow}</p>
                <h2 className="mt-2 font-display text-3xl font-extrabold">{title}</h2>
                <p className="mt-3 max-w-3xl text-sm leading-6 text-slate-500">
                    This workspace is prepared for production workflows and will be wired into the full CRUD and reporting services as the system grows.
                </p>
                <div className="mt-8 grid gap-4 md:grid-cols-2">
                    {items.map((item) => (
                        <article key={item.title} className="rounded-lg border border-slate-200 p-5">
                            <CheckCircle2 className="mb-4 h-6 w-6 text-gold" />
                            <h3 className="font-display text-xl font-bold text-slate-950">{item.title}</h3>
                            <p className="mt-3 text-sm leading-6 text-slate-600">{item.body}</p>
                        </article>
                    ))}
                </div>
            </section>
        </AdminLayout>
    );
}
