import { useLabsContent } from "@/hooks/useLabsContent";
import LabsLogo from "./LabsLogo";

const LabsFooter = () => {
  const { settings, menu } = useLabsContent();
  const f = settings.footer;
  const logo = settings.general.logo;
  const logoAlt = settings.general.logo_alt || "InnovaLabs";
  const socials = (menu.social ?? []).filter((l) => l.enabled);

  return (
    <footer className="pt-16 pb-8 border-t border-border bg-muted/20">
      <div className="container mx-auto px-4">
        <div className="grid md:grid-cols-2 gap-8 items-start mb-10">
          <div>
            {logo
              ? <img src={logo} alt={logoAlt} className="h-12 w-auto" />
              : <LabsLogo height={52} />}
            <p className="text-sm text-muted-foreground mt-4 max-w-md leading-relaxed">{f.about_text}</p>
          </div>
          <div className="md:text-right">
            {socials.length > 0 && (
              <div className="flex gap-3 md:justify-end flex-wrap">
                {socials.map((soc, i) => (
                  <a key={i} href={soc.url || "#"} target={soc.target === "_blank" ? "_blank" : undefined} rel={soc.target === "_blank" ? "noopener noreferrer" : undefined}
                     className="px-4 py-2 rounded-lg border border-border text-sm text-muted-foreground hover:text-primary hover:border-primary transition-colors">
                    {soc.label}
                  </a>
                ))}
              </div>
            )}
          </div>
        </div>

        <div className="flex flex-col md:flex-row items-center justify-between gap-3 pt-6 border-t border-border">
          <p className="text-sm text-muted-foreground">© {new Date().getFullYear()} {f.copyright_text}</p>
          <p className="text-sm text-muted-foreground">
            {f.developed_by_label}{" "}
            <a href={f.parent_url || "#"} target="_blank" rel="noopener noreferrer" className="gradient-text font-medium">{f.developed_by_name}</a>
          </p>
        </div>
      </div>
    </footer>
  );
};

export default LabsFooter;
