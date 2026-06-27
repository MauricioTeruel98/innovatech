import { useState } from "react";
import { Link, useLocation } from "react-router-dom";
import { Menu, X, ChevronDown } from "lucide-react";
import { motion, AnimatePresence } from "framer-motion";
import logoDefault from "@/assets/logo_innovatech.png";
import { useSiteContent } from "@/hooks/useSiteContent";
import SmartLink from "./SmartLink";

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false);
  const [coursesOpen, setCoursesOpen] = useState(false);
  const location = useLocation();

  const { settings, menu } = useSiteContent();
  const nav = settings.navbar;
  const logoSrc = settings.general.logo || logoDefault;
  const logoAlt = settings.general.logo_alt || "Instituto Innova Tech";
  const dropdown = menu.navbar_dropdown ?? [];
  const enabledDropdown = dropdown.filter((d) => d.enabled);

  const isActive = (path: string) => location.pathname === path;

  return (
    <nav className="fixed top-0 left-0 right-0 z-50 bg-background/80 backdrop-blur-lg border-b border-border">
      <div className="container mx-auto px-4">
        <div className="flex items-center justify-between h-16">
          <Link to="/" className="flex items-center">
            <img src={logoSrc} alt={logoAlt} className="h-10" />
          </Link>

          {/* Desktop Nav */}
          <div className="hidden md:flex items-center gap-8">
            <Link to={nav.home_url || "/"} className={`text-sm font-medium transition-colors hover:text-primary ${isActive(nav.home_url || "/") ? "text-primary" : "text-muted-foreground"}`}>
              {nav.home_label}
            </Link>

            <div className="relative" onMouseEnter={() => setCoursesOpen(true)} onMouseLeave={() => setCoursesOpen(false)}>
              <button className="flex items-center gap-1 text-sm font-medium transition-colors hover:text-primary">
                {nav.courses_label} <ChevronDown className="w-3 h-3" />
              </button>
              <AnimatePresence>
                {coursesOpen && dropdown.length > 0 && (
                  <motion.div
                    initial={{ opacity: 0, y: 8 }}
                    animate={{ opacity: 1, y: 0 }}
                    exit={{ opacity: 0, y: 8 }}
                    className="absolute top-full left-0 mt-2 w-48 bg-card rounded-lg shadow-lg border border-border overflow-hidden"
                  >
                    {dropdown.map((item, i) =>
                      item.enabled ? (
                        <SmartLink
                          key={`${item.label}-${i}`}
                          to={item.url}
                          onClick={() => setCoursesOpen(false)}
                          className="block px-4 py-3 text-sm hover:bg-muted hover:text-primary transition-colors"
                        >
                          {item.label}
                        </SmartLink>
                      ) : (
                        <span key={`${item.label}-${i}`} className="block px-4 py-3 text-sm cursor-not-allowed text-muted-foreground">
                          {item.label}
                        </span>
                      )
                    )}
                  </motion.div>
                )}
              </AnimatePresence>
            </div>

            <SmartLink to={nav.about_url} className="text-sm font-medium transition-colors hover:text-primary text-muted-foreground">
              {nav.about_label}
            </SmartLink>
            <SmartLink to={nav.software_url} className="text-sm font-medium transition-colors hover:text-primary text-muted-foreground">
              {nav.software_label}
            </SmartLink>
            <SmartLink to={nav.contact_url} className="text-sm font-medium transition-colors hover:text-primary text-muted-foreground">
              {nav.contact_label}
            </SmartLink>
          </div>

          {/* Mobile toggle */}
          <button onClick={() => setIsOpen(!isOpen)} className="md:hidden text-foreground">
            {isOpen ? <X className="w-6 h-6" /> : <Menu className="w-6 h-6" />}
          </button>
        </div>

        {/* Mobile Nav */}
        <AnimatePresence>
          {isOpen && (
            <motion.div
              initial={{ height: 0, opacity: 0 }}
              animate={{ height: "auto", opacity: 1 }}
              exit={{ height: 0, opacity: 0 }}
              className="md:hidden overflow-hidden border-t border-border"
            >
              <div className="py-4 flex flex-col gap-3">
                <Link to={nav.home_url || "/"} onClick={() => setIsOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">{nav.home_label}</Link>
                {enabledDropdown.map((item, i) => (
                  <SmartLink key={`${item.label}-${i}`} to={item.url} onClick={() => setIsOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">
                    {item.label}
                  </SmartLink>
                ))}
                <SmartLink to={nav.about_url} onClick={() => setIsOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">{nav.about_label}</SmartLink>
                <SmartLink to={nav.software_url} onClick={() => setIsOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">{nav.software_label}</SmartLink>
                <SmartLink to={nav.contact_url} onClick={() => setIsOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">{nav.contact_label}</SmartLink>
              </div>
            </motion.div>
          )}
        </AnimatePresence>
      </div>
    </nav>
  );
};

export default Navbar;
