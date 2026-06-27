import { useState } from "react";
import { Menu, X } from "lucide-react";
import { useLabsContent } from "@/hooks/useLabsContent";
import SmartLink from "@/components/SmartLink";
import LabsLogo from "./LabsLogo";

const LabsNavbar = () => {
  const { settings } = useLabsContent();
  const n = settings.navbar;
  const logo = settings.general.logo;
  const logoAlt = settings.general.logo_alt || "InnovaLabs";
  const [open, setOpen] = useState(false);

  const links = [
    { label: n.services_label, href: "#servicios" },
    { label: n.solutions_label, href: "#soluciones" },
    { label: n.plans_label, href: "#planes" },
    { label: n.contact_label, href: "#contacto" },
  ];

  return (
    <nav className="fixed top-0 inset-x-0 z-50 bg-background/80 backdrop-blur-lg border-b border-border">
      <div className="container mx-auto px-4">
        <div className="flex items-center justify-between h-16">
          <a href="#top" className="flex items-center">
            {logo
              ? <img src={logo} alt={logoAlt} className="h-11 w-auto" />
              : <LabsLogo height={44} />}
          </a>

          <div className="hidden md:flex items-center gap-8">
            {links.map((l) => (
              <a key={l.href} href={l.href} className="text-sm font-medium text-muted-foreground hover:text-primary transition-colors">{l.label}</a>
            ))}
            <SmartLink to={n.cta_url} className="px-5 py-2 rounded-lg gradient-bg text-primary-foreground font-semibold text-sm hover:opacity-90 transition-opacity">
              {n.cta_label}
            </SmartLink>
          </div>

          <button className="md:hidden text-foreground" onClick={() => setOpen(!open)} aria-label="Menú">
            {open ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>
        </div>

        {open && (
          <div className="md:hidden border-t border-border py-4 flex flex-col gap-3">
            {links.map((l) => (
              <a key={l.href} href={l.href} onClick={() => setOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">{l.label}</a>
            ))}
            <SmartLink to={n.cta_url} onClick={() => setOpen(false)} className="mt-1 px-5 py-2 rounded-lg gradient-bg text-primary-foreground font-semibold text-sm text-center">
              {n.cta_label}
            </SmartLink>
          </div>
        )}
      </div>
    </nav>
  );
};

export default LabsNavbar;
