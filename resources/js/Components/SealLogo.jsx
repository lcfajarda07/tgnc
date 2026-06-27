export default function SealLogo({ className = 'h-14 w-14', showText = false }) {
    return (
        <div className="flex items-center gap-3">
            <img src="/images/tgnc-seal.svg?v=faithful" alt="TGNC seal" className={className} />
            {showText && (
                <div className="leading-tight">
                    <div className="font-display text-sm font-extrabold uppercase text-white">TGNC</div>
                    <div className="text-xs font-semibold text-white/70">Global Ministries</div>
                </div>
            )}
        </div>
    );
}
