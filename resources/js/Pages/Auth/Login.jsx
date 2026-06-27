import { Head, Link, useForm } from '@inertiajs/react';
import { LockKeyhole } from 'lucide-react';
import SealLogo from '../../Components/SealLogo';

export default function Login() {
    const { data, setData, post, processing, errors } = useForm({
        email: 'admin@tgnc.local',
        password: 'password',
        remember: true,
    });

    const submit = (event) => {
        event.preventDefault();
        post('/login');
    };

    return (
        <>
            <Head title="Login" />
            <main className="min-h-screen bg-slate-950">
                <div
                    className="flex min-h-screen items-center justify-center bg-cover bg-center px-4 py-12"
                    style={{
                        backgroundImage:
                            "linear-gradient(135deg, rgba(11,61,145,0.9), rgba(15,23,42,0.85)), url('https://images.unsplash.com/photo-1507692049790-de58290a4334?auto=format&fit=crop&w=1800&q=80')",
                    }}
                >
                    <div className="w-full max-w-md rounded-lg bg-white p-8 premium-shadow">
                        <div className="mb-8 flex items-center justify-between">
                            <SealLogo className="h-16 w-16" />
                            <Link href="/" className="text-sm font-bold text-royal">
                                Back to site
                            </Link>
                        </div>

                        <p className="text-xs font-bold uppercase tracking-[0.2em] text-gold">Secure Access</p>
                        <h1 className="mt-2 font-display text-3xl font-extrabold text-slate-950">TGNC Admin Login</h1>
                        <p className="mt-3 text-sm text-slate-500">Use the seeded demo account or your assigned branch administrator credentials.</p>

                        <form onSubmit={submit} className="mt-8 space-y-5">
                            <div>
                                <label className="text-sm font-bold text-slate-700">Email</label>
                                <input
                                    value={data.email}
                                    onChange={(event) => setData('email', event.target.value)}
                                    className="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-royal focus:ring-4 focus:ring-royal/10"
                                    type="email"
                                />
                                {errors.email && <p className="mt-2 text-sm font-semibold text-rose-600">{errors.email}</p>}
                            </div>

                            <div>
                                <label className="text-sm font-bold text-slate-700">Password</label>
                                <input
                                    value={data.password}
                                    onChange={(event) => setData('password', event.target.value)}
                                    className="mt-2 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-royal focus:ring-4 focus:ring-royal/10"
                                    type="password"
                                />
                                {errors.password && <p className="mt-2 text-sm font-semibold text-rose-600">{errors.password}</p>}
                            </div>

                            <label className="flex items-center gap-3 text-sm font-semibold text-slate-600">
                                <input checked={data.remember} onChange={(event) => setData('remember', event.target.checked)} type="checkbox" className="h-4 w-4 rounded border-slate-300 text-royal" />
                                Remember this device
                            </label>

                            <button disabled={processing} className="flex w-full items-center justify-center gap-2 rounded-lg bg-royal px-5 py-3 text-sm font-extrabold text-white shadow-lg shadow-royal/25 hover:bg-blue-900 disabled:opacity-60">
                                <LockKeyhole className="h-4 w-4" />
                                Sign In
                            </button>
                        </form>
                    </div>
                </div>
            </main>
        </>
    );
}
