import logo from "@/assets/logo_innovatech.png";

const Footer = () => {
  return (
    <footer className="py-8 border-t border-border bg-muted/30">
      <div className="container mx-auto px-4">
        <div className="flex flex-col md:flex-row items-center justify-between gap-4">
          <div className="flex items-center">
            <img src={logo} alt="Instituto Innova Tech" className="h-8" />
          </div>
          <p className="text-sm text-muted-foreground">
            © {new Date().getFullYear()} Instituto Innova Tech. Todos los derechos reservados.
          </p>
          <p className="text-sm text-muted-foreground">
            Desarrollado por <span className="gradient-text font-medium">InnovaLabs</span>
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
