import { Star } from "lucide-react";
import ScrollReveal from "./ScrollReveal";
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselPrevious,
  CarouselNext,
} from "@/components/ui/carousel";
import { useSiteContent } from "@/hooks/useSiteContent";

const Testimonials = () => {
  const { settings, testimonials } = useSiteContent();
  const s = settings.testimonials;

  return (
    <section className="py-24 section-teal">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              {s.heading} <span className="gradient-text">{s.heading_highlight}</span>
            </h2>
          </div>
        </ScrollReveal>

        <ScrollReveal>
          <Carousel opts={{ align: "start", loop: true }} className="w-full max-w-5xl mx-auto">
            <CarouselContent className="-ml-4">
              {testimonials.map((t, idx) => {
                const stars = Math.max(0, Math.min(5, t.rating || 5));
                return (
                  <CarouselItem key={`${t.name}-${idx}`} className="pl-4 md:basis-1/2 lg:basis-1/3">
                    <div className="glass-card p-8 hover-lift h-full flex flex-col">
                      <div className="flex gap-1 mb-4">
                        {[...Array(stars)].map((_, j) => (
                          <Star key={j} className="w-4 h-4 fill-accent text-accent" />
                        ))}
                      </div>
                      <p className="text-muted-foreground mb-6 flex-1 italic">"{t.quote}"</p>
                      <div className="flex items-center gap-3">
                        {t.photo && (
                          <img src={t.photo} alt={t.name} className="w-10 h-10 rounded-full object-cover" />
                        )}
                        <div>
                          <p className="font-semibold text-foreground">{t.name}</p>
                          <p className="text-sm text-muted-foreground">{t.role}</p>
                        </div>
                      </div>
                    </div>
                  </CarouselItem>
                );
              })}
            </CarouselContent>
            <CarouselPrevious className="hidden md:flex" />
            <CarouselNext className="hidden md:flex" />
          </Carousel>
        </ScrollReveal>
      </div>
    </section>
  );
};

export default Testimonials;
