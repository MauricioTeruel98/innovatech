import { ArrowRight } from "lucide-react";
import ScrollReveal from "@/components/ScrollReveal";
import SmartLink from "@/components/SmartLink";
import { useLabsContent } from "@/hooks/useLabsContent";

const LabsHero = () => {
  const { settings } = useLabsContent();
  const h = settings.hero;
  const stats = [
    { v: h.stat1_value, l: h.stat1_label },
    { v: h.stat2_value, l: h.stat2_label },
    { v: h.stat3_value, l: h.stat3_label },
  ];

  return (
    <section id="top" className="relative min-h-[92vh] flex items-center overflow-hidden gradient-hero">
      {/* Decoración */}
      <div className="absolute -top-24 -left-24 w-[28rem] h-[28rem] rounded-full bg-primary/20 blur-3xl" />
      <div className="absolute -bottom-24 right-0 w-[26rem] h-[26rem] rounded-full bg-accent/10 blur-3xl" />
      <div
        className="absolute inset-0 opacity-[0.04]"
        style={{ backgroundImage: "linear-gradient(currentColor 1px,transparent 1px),linear-gradient(90deg,currentColor 1px,transparent 1px)", backgroundSize: "44px 44px", color: "#ffffff" }}
      />

      <div className="container mx-auto px-4 relative z-10 pt-24 pb-16">
        <div className="max-w-3xl">
          <ScrollReveal>
            <span className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/15 border border-primary/30 text-sm text-primary mb-6">
              <span className="w-2 h-2 rounded-full bg-accent animate-pulse" /> {h.badge_text}
            </span>
          </ScrollReveal>
          <ScrollReveal delay={0.1}>
            <h1 className="text-4xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6 text-foreground">
              {h.heading_part1}<span className="gradient-text">{h.heading_highlight}</span>
            </h1>
          </ScrollReveal>
          <ScrollReveal delay={0.2}>
            <p className="text-lg md:text-xl text-muted-foreground mb-9 max-w-2xl">{h.subheading}</p>
          </ScrollReveal>
          <ScrollReveal delay={0.3}>
            <div className="flex flex-wrap gap-4 mb-14">
              <SmartLink to={h.primary_cta_url} className="inline-flex items-center gap-2 px-8 py-4 rounded-lg gradient-bg text-primary-foreground font-semibold hover:opacity-90 transition-opacity">
                {h.primary_cta_label} <ArrowRight className="w-4 h-4" />
              </SmartLink>
              <SmartLink to={h.secondary_cta_url} className="inline-flex items-center gap-2 px-8 py-4 rounded-lg border border-border text-foreground font-semibold hover:border-primary hover:text-primary transition-colors">
                {h.secondary_cta_label}
              </SmartLink>
            </div>
          </ScrollReveal>
          <ScrollReveal delay={0.4}>
            <div className="grid grid-cols-3 gap-6 max-w-lg">
              {stats.map((s, i) => (
                <div key={i}>
                  <div className="text-3xl md:text-4xl font-bold gradient-text">{s.v}</div>
                  <div className="text-xs md:text-sm text-muted-foreground mt-1">{s.l}</div>
                </div>
              ))}
            </div>
          </ScrollReveal>
        </div>
      </div>
    </section>
  );
};

export default LabsHero;
