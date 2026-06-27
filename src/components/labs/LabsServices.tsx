import { Code2 } from "lucide-react";
import ScrollReveal from "@/components/ScrollReveal";
import { useLabsContent } from "@/hooks/useLabsContent";
import { getIcon } from "@/lib/icons";

const LabsServices = () => {
  const { settings, services } = useLabsContent();
  const s = settings.services;

  return (
    <section id="servicios" className="py-24 bg-background">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              {s.heading} <span className="gradient-text">{s.heading_highlight}</span>
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">{s.subheading}</p>
          </div>
        </ScrollReveal>

        <div className="grid md:grid-cols-3 gap-6">
          {services.map((it, i) => {
            const Icon = getIcon(it.icon, Code2);
            return (
              <ScrollReveal key={i} delay={i * 0.1}>
                <div className="glass-card p-8 hover-lift h-full">
                  <div className="w-14 h-14 rounded-xl gradient-bg flex items-center justify-center mb-5">
                    <Icon className="w-7 h-7 text-primary-foreground" />
                  </div>
                  <h3 className="text-xl font-semibold text-foreground mb-3">{it.title}</h3>
                  <p className="text-muted-foreground leading-relaxed">{it.description}</p>
                </div>
              </ScrollReveal>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default LabsServices;
