import { Sparkles } from "lucide-react";
import ScrollReveal from "@/components/ScrollReveal";
import { useLabsContent } from "@/hooks/useLabsContent";
import { getIcon } from "@/lib/icons";

const LabsProcess = () => {
  const { settings, process } = useLabsContent();
  const s = settings.process;

  return (
    <section className="py-24 bg-background">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              {s.heading} <span className="gradient-text">{s.heading_highlight}</span>
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">{s.subheading}</p>
          </div>
        </ScrollReveal>

        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {process.map((it, i) => {
            const Icon = getIcon(it.icon, Sparkles);
            return (
              <ScrollReveal key={i} delay={i * 0.1}>
                <div className="relative glass-card p-7 hover-lift h-full">
                  <span className="absolute top-5 right-6 text-4xl font-bold text-primary/15 select-none">{it.extra || String(i + 1).padStart(2, "0")}</span>
                  <div className="w-12 h-12 rounded-xl gradient-bg flex items-center justify-center mb-5">
                    <Icon className="w-6 h-6 text-primary-foreground" />
                  </div>
                  <h3 className="text-lg font-semibold text-foreground mb-2">{it.title}</h3>
                  <p className="text-sm text-muted-foreground leading-relaxed">{it.description}</p>
                </div>
              </ScrollReveal>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default LabsProcess;
