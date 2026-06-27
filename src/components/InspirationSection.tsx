import ScrollReveal from "./ScrollReveal";
import aiLearning from "@/assets/ai-learning.jpg";
import { useSiteContent } from "@/hooks/useSiteContent";

const InspirationSection = () => {
  const { settings } = useSiteContent();
  const s = settings.inspiration;
  const image = s.image || aiLearning;

  return (
    <section className="py-24 bg-background">
      <div className="container mx-auto px-4">
        <div className="grid md:grid-cols-2 gap-12 items-center">
          <ScrollReveal direction="left">
            <div>
              <div className="w-12 h-1 gradient-bg rounded-full mb-6" />
              <h2 className="text-3xl md:text-4xl font-bold mb-6 text-foreground">
                <span className="gradient-text">{s.title_highlight}</span>{" "}
                {s.title_rest}
              </h2>
              <p className="text-lg text-muted-foreground leading-relaxed mb-6">
                {s.quote}
              </p>
              <p className="text-muted-foreground leading-relaxed">
                {s.body_paragraph}
              </p>
            </div>
          </ScrollReveal>

          <ScrollReveal direction="right" delay={0.2}>
            <div className="relative">
              <div className="absolute -inset-4 gradient-bg rounded-2xl opacity-10 blur-xl" />
              <img
                src={image}
                alt={s.image_alt}
                className="relative rounded-2xl w-full object-cover shadow-lg"
                loading="lazy"
                width={800}
                height={1024}
              />
              <div className="absolute -bottom-4 -left-4 w-24 h-24 rounded-xl gradient-bg opacity-20 animate-float" />
              <div className="absolute -top-4 -right-4 w-16 h-16 rounded-full bg-accent opacity-30 animate-float" style={{ animationDelay: "1.5s" }} />
            </div>
          </ScrollReveal>
        </div>
      </div>
    </section>
  );
};

export default InspirationSection;
