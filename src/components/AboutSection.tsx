import { Target, Lightbulb, TrendingUp } from "lucide-react";
import ScrollReveal from "./ScrollReveal";

const values = [
  { icon: Target, title: "Misión", text: "Democratizar el acceso a educación tecnológica de calidad, preparando profesionales competitivos para el mercado actual." },
  { icon: Lightbulb, title: "Innovación", text: "Actualizamos constantemente nuestros programas para incluir las últimas tendencias y herramientas del sector." },
  { icon: TrendingUp, title: "Resultados", text: "Nuestros egresados aplican lo aprendido desde el primer día, con proyectos reales y habilidades demandadas." },
];

const AboutSection = () => {
  return (
    <section id="nosotros" className="py-24 bg-background">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              Sobre <span className="gradient-text">nosotros</span>
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Somos un instituto especializado en formación tecnológica, comprometidos con la excelencia educativa
              y el desarrollo profesional de cada estudiante.
            </p>
          </div>
        </ScrollReveal>

        <div className="grid md:grid-cols-3 gap-8">
          {values.map((v, i) => (
            <ScrollReveal key={v.title} delay={i * 0.15}>
              <div className="text-center p-6">
                <div className="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-5">
                  <v.icon className="w-8 h-8 text-primary" />
                </div>
                <h3 className="text-xl font-semibold mb-3 text-foreground">{v.title}</h3>
                <p className="text-muted-foreground leading-relaxed">{v.text}</p>
              </div>
            </ScrollReveal>
          ))}
        </div>
      </div>
    </section>
  );
};

export default AboutSection;
