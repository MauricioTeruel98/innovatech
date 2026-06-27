import { ArrowUpRight, Boxes } from "lucide-react";
import ScrollReveal from "@/components/ScrollReveal";
import { useLabsContent } from "@/hooks/useLabsContent";
import { getIcon } from "@/lib/icons";

const LabsSolutions = () => {
  const { settings, solutions } = useLabsContent();
  const s = settings.solutions;

  return (
    <section id="soluciones" className="py-24 section-blue">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              {s.heading} <span className="gradient-text">{s.heading_highlight}</span>
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">{s.subheading}</p>
          </div>
        </ScrollReveal>

        <div className="grid sm:grid-cols-2 gap-6 max-w-4xl mx-auto">
          {solutions.map((it, i) => {
            const Icon = getIcon(it.icon, Boxes);
            return (
              <ScrollReveal key={i} delay={i * 0.08}>
                <div className="group glass-card p-8 hover-lift h-full flex gap-5 items-start">
                  <div className="w-14 h-14 rounded-xl bg-primary/15 border border-primary/25 flex items-center justify-center shrink-0">
                    <Icon className="w-7 h-7 text-primary" />
                  </div>
                  <div className="flex-1">
                    <div className="flex items-center justify-between gap-2 mb-2">
                      <h3 className="text-lg font-semibold text-foreground">{it.title}</h3>
                      <ArrowUpRight className="w-5 h-5 text-muted-foreground group-hover:text-primary transition-colors" />
                    </div>
                    <p className="text-sm text-muted-foreground leading-relaxed">{it.description}</p>
                  </div>
                </div>
              </ScrollReveal>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default LabsSolutions;
