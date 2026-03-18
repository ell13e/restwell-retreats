import { Link } from "wouter";
import { NAV_LINKS } from "@/lib/constants";
import InfinityLogo from "./InfinityLogo";

export default function Footer() {
  return (
    <footer className="bg-[#1B4D5C] text-[#F5EDE0]" role="contentinfo">
      <div className="container py-16">
        <div className="grid grid-cols-1 md:grid-cols-3 gap-12">
          {/* Brand */}
          <div className="space-y-4">
            <div className="flex items-center gap-2">
              <InfinityLogo color="#F5EDE0" size={36} />
              <div className="flex flex-col leading-tight">
                <span className="text-[#F5EDE0] font-semibold text-base tracking-tight" style={{ fontFamily: "'Inter', sans-serif" }}>
                  Restwell Retreats
                </span>
                <span className="text-[#D4A853] text-[9px] font-medium uppercase tracking-[0.25em]" style={{ fontFamily: "'Inter', sans-serif" }}>
                  Rest Easy.
                </span>
              </div>
            </div>
            <p className="text-sm text-[#A8D5D0] leading-relaxed max-w-xs">
              A Restwell Retreats property, by Continuity of Care Services.
            </p>
            <p className="text-sm text-[#A8D5D0]">
              Care provided by Continuity of Care Services.
            </p>
          </div>

          {/* Navigation */}
          <div>
            <h3 className="text-[#D4A853] text-sm font-semibold uppercase tracking-wider mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
              Explore
            </h3>
            <nav aria-label="Footer navigation">
              <ul className="space-y-2">
                {NAV_LINKS.map((link) => (
                  <li key={link.path}>
                    <Link
                      href={link.path}
                      className="text-sm text-[#A8D5D0] hover:text-white transition-colors duration-200 no-underline"
                    >
                      {link.label}
                    </Link>
                  </li>
                ))}
              </ul>
            </nav>
          </div>

          {/* Contact */}
          <div>
            <h3 className="text-[#D4A853] text-sm font-semibold uppercase tracking-wider mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
              Get in Touch
            </h3>
            <div className="space-y-3 text-sm text-[#A8D5D0]">
              <p>
                <span className="text-[#F5EDE0] font-medium">Email:</span>{" "}
                <span className="italic text-[#8B8B7A]">PLACEHOLDER – Email to be confirmed</span>
              </p>
              <p>
                <span className="text-[#F5EDE0] font-medium">Phone:</span>{" "}
                <span className="italic text-[#8B8B7A]">PLACEHOLDER – Phone to be confirmed</span>
              </p>
              <div className="flex gap-4 pt-2">
                <span className="text-xs text-[#8B8B7A] italic">PLACEHOLDER – Social links</span>
              </div>
            </div>
          </div>
        </div>

        <div className="border-t border-[#A8D5D0]/20 mt-12 pt-8 text-center text-xs text-[#8B8B7A]">
          <p>&copy; {new Date().getFullYear()} Restwell Retreats. All rights reserved.</p>
        </div>
      </div>
    </footer>
  );
}
