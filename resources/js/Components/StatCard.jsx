export default function StatCard({ label, value, trend, icon: Icon }) {
    return (
        <div className="rounded-lg border border-slate-200 bg-white p-5 premium-shadow">
            <div className="flex items-start justify-between gap-4">
                <div>
                    <p className="text-sm font-semibold text-slate-500">{label}</p>
                    <p className="mt-2 text-3xl font-extrabold text-slate-950">{value}</p>
                    <p className="mt-2 text-sm text-slate-500">{trend}</p>
                </div>
                {Icon && (
                    <div className="rounded-lg bg-royal/10 p-3 text-royal">
                        <Icon className="h-5 w-5" />
                    </div>
                )}
            </div>
        </div>
    );
}
