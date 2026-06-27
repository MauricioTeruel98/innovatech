import logoDefault from "@/assets/logo_innovatech.png";
import { useSiteContent } from "@/hooks/useSiteContent";

const Footer = () => {
  const { settings } = useSiteContent();
  const g = settings.general;
  const f = settings.footer;
  const logoSrc = g.logo || logoDefault;

  return (
    <footer className="py-8 border-t border-border bg-muted/30">
      <div className="container mx-auto px-4">
        <div className="flex flex-col md:flex-row items-center justify-between gap-4">
          <div className="flex items-center">
            <img src={logoSrc} alt={g.logo_alt || "Instituto Innova Tech"} className="h-8" />
          </div>
          <p className="text-sm text-muted-foreground">
            © {new Date().getFullYear()} {f.copyright_text}
          </p>
          <p className="text-sm text-muted-foreground">
            {f.developed_by_label} <span className="gradient-text font-medium">{f.developed_by_name}</span>
          </p>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
