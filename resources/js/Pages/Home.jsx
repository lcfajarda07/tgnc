import { Head, Link, useForm, usePage } from '@inertiajs/react';
import { motion } from 'framer-motion';
import {
    ArrowRight,
    Banknote,
    CalendarDays,
    Camera,
    CheckCircle2,
    Church,
    Clock,
    HeartHandshake,
    MapPin,
    Music,
    Navigation,
    Play,
    Send,
    Users,
} from 'lucide-react';
import SealLogo from '../Components/SealLogo';

const nav = ['About', 'Branches', 'Ministries', 'Sermons', 'Events', 'Gallery', 'Prayer', 'Give', 'Contact'];

const iconMap = {
    Children: HeartHandshake,
    Youth: Users,
    "Women's": Users,
    "Men's": Users,
    Prayer: HeartHandshake,
    Media: Camera,
    Worship: Music,
    Evangelism: Navigation,
};

export default function Home({ church, branches, ministries, sermons, events, gallery }) {
    const { flash } = usePage().props;
    const prayer = useForm({
        name: '',
        email: '',
        phone: '',
        branch_id: branches[0]?.id ?? '',
        request: '',
        visibility: 'pastoral',
    });

    const submitPrayer = (event) => {
        event.preventDefault();
        prayer.post('/prayer-requests', {
            preserveScroll: true,
            onSuccess: () => prayer.reset('name', 'email', 'phone', 'request'),
        });
    };

    return (
        <>
            <Head title="Home" />
            <main className="bg-cloud text-slate-950">
                <header className="fixed inset-x-0 top-0 z-50 border-b border-white/10 bg-slate-950/45 backdrop-blur-xl">
                    <div className="mx-auto flex max-w-7xl items-center justify-between px-4 py-4 lg:px-8">
                        <a href="#home" className="flex items-center gap-3">
                            <SealLogo className="h-12 w-12" />
                            <div className="hidden leading-tight text-white sm:block">
                                <p className="font-display text-sm font-extrabold">TGNC</p>
                                <p className="text-xs font-semibold text-white/70">Global Ministries</p>
                            </div>
                        </a>
                        <nav className="hidden items-center gap-5 xl:flex">
                            {nav.map((item) => (
                                <a key={item} href={`#${item.toLowerCase().replace(' ', '-')}`} className="text-sm font-bold text-white/75 hover:text-white">
                                    {item}
                                </a>
                            ))}
                        </nav>
                        <Link href="/login" className="rounded-lg bg-white px-4 py-2 text-sm font-extrabold text-royal hover:bg-gold hover:text-slate-950">
                            Login
                        </Link>
                    </div>
                </header>

                <section
                    id="home"
                    className="relative min-h-[92vh] overflow-hidden bg-cover bg-center pt-28 text-white"
                    style={{
                        backgroundImage:
                            "linear-gradient(120deg, rgba(2,6,23,0.86), rgba(11,61,145,0.65)), url('https://images.unsplash.com/photo-1507692049790-de58290a4334?auto=format&fit=crop&w=2200&q=80')",
                    }}
                >
                    <div className="absolute inset-x-0 bottom-0 h-32 bg-gradient-to-t from-cloud to-transparent" />
                    <div className="mx-auto grid max-w-7xl items-center gap-12 px-4 pb-28 pt-20 lg:grid-cols-[1.1fr_0.9fr] lg:px-8">
                        <motion.div initial={{ opacity: 0, y: 24 }} animate={{ opacity: 1, y: 0 }} transition={{ duration: 0.7 }}>
                            <p className="text-sm font-extrabold uppercase tracking-[0.28em] text-gold">{church.tagline}</p>
                            <h1 className="mt-5 max-w-4xl font-display text-5xl font-extrabold leading-tight text-balance md:text-7xl">
                                THE GOOD NEWS OF CHRIST
                            </h1>
                            <p className="mt-6 max-w-2xl text-lg leading-8 text-white/78">
                                A multi-branch church family proclaiming Jesus, discipling believers, and serving communities with excellence.
                            </p>
                            <div className="mt-9 flex flex-wrap gap-4">
                                <a href="#contact" className="inline-flex items-center gap-2 rounded-lg bg-gold px-6 py-3 text-sm font-extrabold text-slate-950 shadow-xl shadow-black/20">
                                    Join Us <ArrowRight className="h-4 w-4" />
                                </a>
                                <a href="#sermons" className="inline-flex items-center gap-2 rounded-lg border border-white/25 bg-white/10 px-6 py-3 text-sm font-extrabold text-white backdrop-blur hover:bg-white/20">
                                    <Play className="h-4 w-4" /> Watch Live
                                </a>
                            </div>
                        </motion.div>

                        <motion.div initial={{ opacity: 0, scale: 0.96 }} animate={{ opacity: 1, scale: 1 }} transition={{ duration: 0.7, delay: 0.2 }} className="glass-panel rounded-lg p-6 text-slate-950">
                            <div className="grid gap-4 sm:grid-cols-2">
                                {[
                                    ['Sunday Worship', '9:00 AM'],
                                    ['Prayer Meeting', 'Wednesday 7:00 PM'],
                                    ['Bible Study', 'Friday 7:00 PM'],
                                    ['Youth Fellowship', 'Saturday 4:00 PM'],
                                ].map(([title, time]) => (
                                    <div key={title} className="rounded-lg bg-white p-5">
                                        <Clock className="mb-4 h-6 w-6 text-royal" />
                                        <h3 className="font-display text-lg font-bold">{title}</h3>
                                        <p className="mt-1 text-sm font-semibold text-slate-500">{time}</p>
                                    </div>
                                ))}
                            </div>
                        </motion.div>
                    </div>
                </section>

                <section id="about" className="mx-auto max-w-7xl px-4 py-20 lg:px-8">
                    <div className="grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
                        <div>
                            <SealLogo className="mb-7 h-40 w-40 drop-shadow-xl md:h-52 md:w-52" />
                            <p className="text-sm font-extrabold uppercase tracking-[0.2em] text-royal">Welcome</p>
                            <h2 className="mt-4 font-display text-4xl font-extrabold text-slate-950">A church built for worship, discipleship, and mission.</h2>
                        </div>
                        <div className="grid gap-4 md:grid-cols-3">
                            {[
                                ['Mission', 'Reach the lost, disciple believers, and raise leaders for Christ.'],
                                ['Vision', 'A global family of branches carrying the good news with excellence.'],
                                ['Call', 'Find your branch, join a service, and grow in community.'],
                            ].map(([title, body]) => (
                                <div key={title} className="rounded-lg border border-slate-200 bg-white p-6 premium-shadow">
                                    <CheckCircle2 className="mb-4 h-6 w-6 text-gold" />
                                    <h3 className="font-display text-xl font-bold">{title}</h3>
                                    <p className="mt-3 text-sm leading-6 text-slate-600">{body}</p>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                <section id="branches" className="bg-white py-20">
                    <div className="mx-auto max-w-7xl px-4 lg:px-8">
                        <p className="text-sm font-extrabold uppercase tracking-[0.2em] text-royal">Branches</p>
                        <h2 className="mt-3 font-display text-4xl font-extrabold">One ministry, many communities.</h2>
                        <div className="mt-10 grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                            {branches.map((branch) => (
                                <article key={branch.id} className="overflow-hidden rounded-lg border border-slate-200 bg-cloud">
                                    <img className="h-48 w-full object-cover" src={branch.photo_url} alt={`${branch.name} branch`} />
                                    <div className="p-6">
                                        <h3 className="font-display text-2xl font-bold">{branch.name}</h3>
                                        <p className="mt-2 text-sm font-semibold text-royal">{branch.pastor_name}</p>
                                        <p className="mt-4 flex gap-2 text-sm text-slate-600"><MapPin className="h-4 w-4 shrink-0 text-gold" /> {branch.address}</p>
                                        <p className="mt-3 flex gap-2 text-sm text-slate-600"><Clock className="h-4 w-4 shrink-0 text-gold" /> {branch.service_schedule}</p>
                                        <a className="mt-5 inline-flex items-center gap-2 text-sm font-extrabold text-royal" href={`https://maps.google.com/?q=${encodeURIComponent(branch.address)}`}>
                                            Directions <Navigation className="h-4 w-4" />
                                        </a>
                                    </div>
                                </article>
                            ))}
                        </div>
                    </div>
                </section>

                <section id="ministries" className="mx-auto max-w-7xl px-4 py-20 lg:px-8">
                    <p className="text-sm font-extrabold uppercase tracking-[0.2em] text-royal">Ministries</p>
                    <h2 className="mt-3 font-display text-4xl font-extrabold">Serve with your gifts.</h2>
                    <div className="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        {ministries.map((ministry) => {
                            const Icon = iconMap[ministry.name] ?? Church;
                            return (
                                <div key={ministry.id} className="rounded-lg border border-slate-200 bg-white p-6 premium-shadow">
                                    <div className="mb-5 inline-flex rounded-lg bg-royal/10 p-3 text-royal"><Icon className="h-6 w-6" /></div>
                                    <h3 className="font-display text-xl font-bold">{ministry.name}</h3>
                                    <p className="mt-2 text-sm font-semibold text-gold">{ministry.category}</p>
                                    <p className="mt-3 text-sm leading-6 text-slate-600">{ministry.description}</p>
                                </div>
                            );
                        })}
                    </div>
                </section>

                <section id="sermons" className="bg-slate-950 py-20 text-white">
                    <div className="mx-auto max-w-7xl px-4 lg:px-8">
                        <p className="text-sm font-extrabold uppercase tracking-[0.2em] text-gold">Sermons</p>
                        <h2 className="mt-3 font-display text-4xl font-extrabold">Latest messages</h2>
                        <div className="mt-10 grid gap-5 md:grid-cols-3">
                            {sermons.map((sermon) => (
                                <article key={sermon.id} className="overflow-hidden rounded-lg bg-white/8">
                                    <img className="h-56 w-full object-cover" src={sermon.thumbnail_url} alt={sermon.title} />
                                    <div className="p-6">
                                        <p className="text-sm font-semibold text-gold">{sermon.scripture}</p>
                                        <h3 className="mt-2 font-display text-2xl font-bold">{sermon.title}</h3>
                                        <p className="mt-2 text-sm text-white/60">{sermon.speaker}</p>
                                        <a href={sermon.video_url} className="mt-5 inline-flex items-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-extrabold text-slate-950">
                                            Watch <Play className="h-4 w-4" />
                                        </a>
                                    </div>
                                </article>
                            ))}
                        </div>
                    </div>
                </section>

                <section id="events" className="mx-auto max-w-7xl px-4 py-20 lg:px-8">
                    <p className="text-sm font-extrabold uppercase tracking-[0.2em] text-royal">Events</p>
                    <h2 className="mt-3 font-display text-4xl font-extrabold">Upcoming gatherings</h2>
                    <div className="mt-10 grid gap-4 lg:grid-cols-2">
                        {events.map((event) => (
                            <article key={event.id} className="grid overflow-hidden rounded-lg border border-slate-200 bg-white md:grid-cols-[220px_1fr]">
                                <img className="h-full min-h-56 w-full object-cover" src={event.image_url} alt={event.title} />
                                <div className="p-6">
                                    <p className="inline-flex items-center gap-2 rounded-full bg-gold/15 px-3 py-1 text-xs font-extrabold text-slate-800"><CalendarDays className="h-3 w-3" /> {new Date(event.starts_at).toLocaleDateString()}</p>
                                    <h3 className="mt-4 font-display text-2xl font-bold">{event.title}</h3>
                                    <p className="mt-3 text-sm leading-6 text-slate-600">{event.description}</p>
                                    <button className="mt-5 rounded-lg bg-royal px-4 py-2 text-sm font-extrabold text-white">Register</button>
                                </div>
                            </article>
                        ))}
                    </div>
                </section>

                <section id="gallery" className="bg-white py-20">
                    <div className="mx-auto max-w-7xl px-4 lg:px-8">
                        <p className="text-sm font-extrabold uppercase tracking-[0.2em] text-royal">Gallery</p>
                        <h2 className="mt-3 font-display text-4xl font-extrabold">Life at TGNC</h2>
                        <div className="mt-10 columns-1 gap-4 sm:columns-2 lg:columns-3">
                            {gallery.map((item) => (
                                <img key={item.id} src={item.image_url} alt={item.title} className="mb-4 w-full break-inside-avoid rounded-lg object-cover premium-shadow" />
                            ))}
                        </div>
                    </div>
                </section>

                <section id="prayer" className="mx-auto grid max-w-7xl gap-8 px-4 py-20 lg:grid-cols-[0.8fr_1.2fr] lg:px-8">
                    <div>
                        <p className="text-sm font-extrabold uppercase tracking-[0.2em] text-royal">Prayer Request</p>
                        <h2 className="mt-3 font-display text-4xl font-extrabold">We would be honored to pray with you.</h2>
                        <p className="mt-5 text-slate-600">Share your request with the pastoral team. Requests are routed to the selected branch.</p>
                        {flash.success && <p className="mt-6 rounded-lg bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">{flash.success}</p>}
                    </div>
                    <form onSubmit={submitPrayer} className="rounded-lg bg-white p-6 premium-shadow">
                        <div className="grid gap-4 md:grid-cols-2">
                            <input value={prayer.data.name} onChange={(e) => prayer.setData('name', e.target.value)} className="rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-royal" placeholder="Your name" />
                            <input value={prayer.data.email} onChange={(e) => prayer.setData('email', e.target.value)} className="rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-royal" placeholder="Email" />
                            <input value={prayer.data.phone} onChange={(e) => prayer.setData('phone', e.target.value)} className="rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-royal" placeholder="Phone" />
                            <select value={prayer.data.branch_id} onChange={(e) => prayer.setData('branch_id', e.target.value)} className="rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-royal">
                                {branches.map((branch) => <option key={branch.id} value={branch.id}>{branch.name}</option>)}
                            </select>
                        </div>
                        <textarea value={prayer.data.request} onChange={(e) => prayer.setData('request', e.target.value)} className="mt-4 min-h-36 w-full rounded-lg border border-slate-200 px-4 py-3 text-sm outline-none focus:border-royal" placeholder="How can we pray for you?" />
                        <button disabled={prayer.processing} className="mt-4 inline-flex items-center gap-2 rounded-lg bg-royal px-5 py-3 text-sm font-extrabold text-white">
                            Send Request <Send className="h-4 w-4" />
                        </button>
                    </form>
                </section>

                <section id="give" className="bg-royal py-20 text-white">
                    <div className="mx-auto grid max-w-7xl gap-6 px-4 lg:grid-cols-3 lg:px-8">
                        <div>
                            <p className="text-sm font-extrabold uppercase tracking-[0.2em] text-gold">Give</p>
                            <h2 className="mt-3 font-display text-4xl font-extrabold">Partner with the mission.</h2>
                        </div>
                        {[
                            ['GCash', 'Send to TGNC ministry account.'],
                            ['Bank', 'Bank transfer details can be configured in Settings.'],
                            ['Mission Giving', 'Support outreach, branches, and discipleship.'],
                        ].map(([title, body]) => (
                            <div key={title} className="rounded-lg bg-white/10 p-6">
                                <Banknote className="mb-4 h-6 w-6 text-gold" />
                                <h3 className="font-display text-xl font-bold">{title}</h3>
                                <p className="mt-3 text-sm text-white/70">{body}</p>
                            </div>
                        ))}
                    </div>
                </section>

                <footer id="contact" className="bg-slate-950 px-4 py-14 text-white lg:px-8">
                    <div className="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-8">
                        <div>
                            <SealLogo showText />
                            <p className="mt-4 max-w-xl text-sm leading-6 text-white/60">Phone: +63 900 000 0000 | Email: hello@tgnc.local | Facebook and Messenger links can be configured in Settings.</p>
                        </div>
                        <a href="#home" className="rounded-lg bg-white px-4 py-2 text-sm font-extrabold text-slate-950">Back to top</a>
                    </div>
                </footer>
            </main>
        </>
    );
}
