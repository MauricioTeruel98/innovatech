import { useState } from "react";
import { Link, useLocation } from "react-router-dom";
import { Menu, X, ChevronDown } from "lucide-react";
import { motion, AnimatePresence } from "framer-motion";
import logo from "@/assets/logo_innovatech.png";

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false);
  const [coursesOpen, setCoursesOpen] = useState(false);
  const location = useLocation();

  const isActive = (path: string) => location.pathname === path;

  return (
    <nav className="fixed top-0 left-0 right-0 z-50 bg-background/80 backdrop-blur-lg border-b border-border">
      <div className="container mx-auto px-4">
        <div className="flex items-center justify-between h-16">
          <Link to="/" className="flex items-center">
            <img src={logo} alt="Instituto Innova Tech" className="h-10" />
          </Link>

          {/* Desktop Nav */}
          <div className="hidden md:flex items-center gap-8">
            <Link to="/" className={`text-sm font-medium transition-colors hover:text-primary ${isActive("/") ? "text-primary" : "text-muted-foreground"}`}>
              Inicio
            </Link>

            <div className="relative" onMouseEnter={() => setCoursesOpen(true)} onMouseLeave={() => setCoursesOpen(false)}>
              <button className="flex items-center gap-1 text-sm font-medium transition-colors hover:text-primary">
                Cursos <ChevronDown className="w-3 h-3" />
              </button>
              <AnimatePresence>
                {coursesOpen && (
                  <motion.div
                    initial={{ opacity: 0, y: 8 }}
                    animate={{ opacity: 1, y: 0 }}
                    exit={{ opacity: 0, y: 8 }}
                    className="absolute top-full left-0 mt-2 w-48 bg-card rounded-lg shadow-lg border border-border overflow-hidden"
                  >
                    <Link to="/cursos" onClick={() => setCoursesOpen(false)} className="block px-4 py-3 text-sm hover:bg-muted hover:text-primary transition-colors">
                      A distancia
                    </Link>
                    <span className="block px-4 py-3 text-sm cursor-not-allowed">
                      En vivo (próximamente)
                    </span>
                    <span className="block px-4 py-3 text-sm cursor-not-allowed">
                      Presencial (próximamente)
                    </span>
                    <span className="block px-4 py-3 text-sm cursor-not-allowed">
                      Para empresas (próximamente)
                    </span>
                  </motion.div>
                )}
              </AnimatePresence>
            </div>

            <a href="#nosotros" className="text-sm font-medium transition-colors hover:text-primary">
              Quiénes somos
            </a>
            <a href="https://example.com" target="_blank" rel="noopener noreferrer" className="text-sm font-medium transition-colors hover:text-primary">
              Desarrollo de software
            </a>
            <a href="#contacto" className="text-sm font-medium transition-colors hover:text-primary">
              Contacto
            </a>
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
                <Link to="/" onClick={() => setIsOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">Inicio</Link>
                <Link to="/cursos" onClick={() => setIsOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">Cursos a distancia</Link>
                <a href="#nosotros" onClick={() => setIsOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">Quiénes somos</a>
                <a href="https://example.com" target="_blank" rel="noopener noreferrer" className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">Desarrollo de software</a>
                <a href="#contacto" onClick={() => setIsOpen(false)} className="text-sm font-medium text-muted-foreground hover:text-primary px-2 py-1">Contacto</a>
              </div>
            </motion.div>
          )}
        </AnimatePresence>
      </div>
    </nav>
  );
};

export default Navbar;
