import ScrollReveal from "./ScrollReveal";
import { useSiteContent } from "@/hooks/useSiteContent";
import { getIcon } from "@/lib/icons";
import { Monitor } from "lucide-react";

const CourseTypes = () => {
  const { settings, modalities } = useSiteContent();
  const s = settings.modalities;

  return (
    <section className="py-24 section-blue">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              <span className="gradient-text">{s.heading_highlight}</span> {s.heading_rest}
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              {s.subheading}
            </p>
          </div>
        </ScrollReveal>

        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {modalities.map((type, i) => {
            const Icon = getIcon(type.icon, Monitor);
            return (
              <ScrollReveal key={`${type.title}-${i}`} delay={i * 0.1}>
                <div className="glass-card p-8 text-center hover-lift h-full">
                  <div className="w-14 h-14 rounded-xl gradient-bg flex items-center justify-center mx-auto mb-5">
                    <Icon className="w-7 h-7 text-primary-foreground" />
                  </div>
                  <h3 className="text-xl font-semibold mb-3 text-foreground">{type.title}</h3>
                  <p className="text-sm text-muted-foreground leading-relaxed">{type.description}</p>
                </div>
              </ScrollReveal>
            );
          })}
        </div>
      </div>
    </section>
  );
};

export default CourseTypes;
