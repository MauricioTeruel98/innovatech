import { Star, Quote } from "lucide-react";
import ScrollReveal from "@/components/ScrollReveal";
import { useLabsContent } from "@/hooks/useLabsContent";

const LabsTestimonials = () => {
  const { settings, testimonials } = useLabsContent();
  const s = settings.testimonials;

  if (!testimonials.length) return null;

  return (
    <section className="py-24 section-blue">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              {s.heading} <span className="gradient-text">{s.heading_highlight}</span>
            </h2>
          </div>
        </ScrollReveal>

        <div className="grid md:grid-cols-3 gap-6 max-w-5xl mx-auto">
          {testimonials.map((t, i) => {
            const stars = Math.max(0, Math.min(5, t.rating || 5));
            return (
              <ScrollReveal key={i} delay={i * 0.1}>
                <div className="glass-card p-8 hover-lift h-full flex flex-col">
                  <Quote className="w-8 h-8 text-primary/40 mb-4" />
                  <div className="flex gap-1 mb-4">
                    {[...Array(stars)].map((_, j) => (
                      <Star key={j} className="w-4 h-4 fill-accent text-accent" />
                    ))}
                  </div>
                  <p className="text-muted-foreground italic mb-6 flex-1">"{t.quote}"</p>
                  <div className="flex items-center gap-3">
                    {t.photo
                      ? <img src={t.photo} alt={t.name} className="w-10 h-10 rounded-full object-cover" />
                      : <div className="w-10 h-10 rounded-full gradient-bg flex items-center justify-center text-primary-foreground font-bold text-sm">{t.name.charAt(0)}</div>}
                    <div>
                      <p className="font-semibold text-foreground">{t.name}</p>
                      <p className="text-sm text-muted-foreground">{t.role}</p>
                    </div>
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

export default LabsTestimonials;
