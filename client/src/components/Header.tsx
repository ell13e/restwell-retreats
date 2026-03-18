import { useState } from "react";
import { Link, useLocation } from "wouter";
import { NAV_LINKS } from "@/lib/constants";
import { Menu, X } from "lucide-react";
import InfinityLogo from "./InfinityLogo";

export default function Header() {
  const [location] = useLocation();
  const [mobileOpen, setMobileOpen] = useState(false);

  return (
    <header className="sticky top-0 z-50 bg-white/95 backdrop-blur-sm border-b border-[#E8DFD0]">
      <div className="container flex items-center justify-between py-3">
        {/* Logo */}
        <Link href="/" className="flex items-center gap-3 no-underline group" aria-label="Restwell Retreats home">
          <InfinityLogo size={42} />
          <div className="flex flex-col leading-tight">
            <span className="text-[#1B4D5C] font-semibold text-lg tracking-tight" style={{ fontFamily: "'Inter', sans-serif" }}>
              Restwell Retreats
            </span>
            <span className="text-[#D4A853] text-[10px] font-medium uppercase tracking-[0.25em]" style={{ fontFamily: "'Inter', sans-serif" }}>
              Rest Easy.
            </span>
          </div>
        </Link>

        {/* Desktop Nav */}
        <nav className="hidden lg:flex items-center gap-1" aria-label="Main navigation">
          {NAV_LINKS.map((link) => {
            const isActive = location === link.path;
            return (
              <Link
                key={link.path}
                href={link.path}
                className={`px-3 py-2 rounded-full text-sm font-medium transition-colors duration-300 no-underline ${
                  isActive
                    ? "bg-[#1B4D5C] text-white"
                    : "text-[#1B4D5C] hover:bg-[#A8D5D0]/30"
                }`}
                aria-current={isActive ? "page" : undefined}
              >
                {link.label}
              </Link>
            );
          })}
        </nav>

        {/* Mobile Menu Button */}
        <button
          className="lg:hidden p-2 rounded-lg text-[#1B4D5C] hover:bg-[#A8D5D0]/30 transition-colors"
          onClick={() => setMobileOpen(!mobileOpen)}
          aria-expanded={mobileOpen}
          aria-controls="mobile-nav"
          aria-label={mobileOpen ? "Close menu" : "Open menu"}
        >
          {mobileOpen ? <X size={24} /> : <Menu size={24} />}
        </button>
      </div>

      {/* Mobile Nav */}
      {mobileOpen && (
        <nav
          id="mobile-nav"
          className="lg:hidden border-t border-[#E8DFD0] bg-white"
          aria-label="Mobile navigation"
        >
          <div className="container py-4 flex flex-col gap-1">
            {NAV_LINKS.map((link) => {
              const isActive = location === link.path;
              return (
                <Link
                  key={link.path}
                  href={link.path}
                  className={`px-4 py-3 rounded-lg text-base font-medium transition-colors duration-200 no-underline ${
                    isActive
                      ? "bg-[#1B4D5C] text-white"
                      : "text-[#1B4D5C] hover:bg-[#A8D5D0]/20"
                  }`}
                  aria-current={isActive ? "page" : undefined}
                  onClick={() => setMobileOpen(false)}
                >
                  {link.label}
                </Link>
              );
            })}
          </div>
        </nav>
      )}
    </header>
  );
}
