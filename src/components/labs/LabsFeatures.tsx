import { Sparkles } from "lucide-react";
import ScrollReveal from "@/components/ScrollReveal";
import { useLabsContent } from "@/hooks/useLabsContent";
import { getIcon } from "@/lib/icons";

const LabsFeatures = () => {
  const { settings, features } = useLabsContent();
  const s = settings.features;

  return (
    <section className="py-24 section-teal">
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
          {features.map((it, i) => {
            const Icon = getIcon(it.icon, Sparkles);
            return (
              <ScrollReveal key={i} delay={i * 0.08}>
                <div className="text-center p-6">
                  <div className="w-16 h-16 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center mx-auto mb-5">
                    <Icon className="w-8 h-8 text-primary" />
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

export default LabsFeatures;
