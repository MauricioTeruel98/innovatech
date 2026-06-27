import { Check } from "lucide-react";
import ScrollReveal from "@/components/ScrollReveal";
import SmartLink from "@/components/SmartLink";
import { useLabsContent } from "@/hooks/useLabsContent";

const LabsPlans = () => {
  const { settings, plans } = useLabsContent();
  const s = settings.plans;

  return (
    <section id="planes" className="py-24 bg-background">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              {s.heading} <span className="gradient-text">{s.heading_highlight}</span>
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">{s.subheading}</p>
          </div>
        </ScrollReveal>

        <div className="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto items-stretch">
          {plans.map((p, i) => (
            <ScrollReveal key={i} delay={i * 0.1}>
              <div className={`glass-card p-8 h-full flex flex-col relative ${p.highlighted ? "ring-2 ring-primary md:-translate-y-3" : ""}`}>
                {p.highlighted && (
                  <span className="absolute -top-3 left-1/2 -translate-x-1/2 px-4 py-1 rounded-full text-xs font-bold gradient-bg text-primary-foreground">
                    Recomendado
                  </span>
                )}
                <h3 className="text-lg font-semibold text-foreground mb-1">{p.name}</h3>
                <p className="text-sm text-muted-foreground mb-5 min-h-[2.5rem]">{p.description}</p>
                <div className="mb-6">
                  <span className="text-3xl font-bold gradient-text">{p.price}</span>
                  {p.period && <span className="text-sm text-muted-foreground"> / {p.period}</span>}
                </div>
                <ul className="space-y-3 mb-8 flex-1">
                  {p.features.map((f, j) => (
                    <li key={j} className="flex items-start gap-2 text-sm text-muted-foreground">
                      <Check className="w-4 h-4 text-primary mt-0.5 shrink-0" /> <span>{f}</span>
                    </li>
                  ))}
                </ul>
                <SmartLink
                  to={p.cta_url || "#contacto"}
                  className={`text-center px-6 py-3 rounded-lg font-semibold text-sm transition-opacity ${p.highlighted ? "gradient-bg text-primary-foreground hover:opacity-90" : "border border-primary text-primary hover:bg-primary hover:text-primary-foreground transition-colors"}`}
                >
                  {p.cta_label || "Cotizar"}
                </SmartLink>
              </div>
            </ScrollReveal>
          ))}
        </div>

        {s.note && (
          <ScrollReveal delay={0.3}>
            <p className="text-center text-sm text-muted-foreground mt-10 max-w-xl mx-auto">{s.note}</p>
          </ScrollReveal>
        )}
      </div>
    </section>
  );
};

export default LabsPlans;
