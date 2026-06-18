import { Code2, ArrowUpRight } from "lucide-react";
import ScrollReveal from "./ScrollReveal";

const SoftwareDev = () => {
  return (
    <section className="py-24 bg-background">
      <div className="container mx-auto px-4">
        <div className="relative overflow-hidden rounded-2xl gradient-hero p-12 md:p-16">
          <div className="absolute top-0 right-0 w-64 h-64 bg-accent/10 rounded-full blur-3xl" />
          <div className="relative z-10 max-w-2xl">
            <ScrollReveal>
              <div className="w-14 h-14 rounded-xl bg-primary-foreground/10 flex items-center justify-center mb-6">
                <Code2 className="w-7 h-7 text-primary-foreground" />
              </div>
              <h2 className="text-3xl md:text-4xl font-bold text-primary-foreground mb-4">
                Desarrollo de Software a medida
              </h2>
              <p className="text-primary-foreground/70 text-lg mb-8 leading-relaxed">
                Además de la formación, ofrecemos servicios profesionales de desarrollo de software. 
                Creamos soluciones digitales personalizadas para tu negocio: aplicaciones web, móviles, 
                sistemas de gestión y más.
              </p>
              <a
                href="https://example.com"
                target="_blank"
                rel="noopener noreferrer"
                className="inline-flex items-center gap-2 px-8 py-4 rounded-lg bg-primary-foreground text-primary font-semibold hover:bg-primary-foreground/90 transition-colors"
              >
                Conocer más <ArrowUpRight className="w-4 h-4" />
              </a>
            </ScrollReveal>
          </div>
        </div>
      </div>
    </section>
  );
};

export default SoftwareDev;
