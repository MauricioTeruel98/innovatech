import { Monitor, Users, Radio, Building2 } from "lucide-react";
import ScrollReveal from "./ScrollReveal";

const types = [
  {
    icon: Monitor,
    title: "Online",
    description: "Aprende a tu ritmo desde cualquier lugar con acceso 24/7 a todo el material del curso.",
  },
  {
    icon: Users,
    title: "Presenciales",
    description: "Clases prácticas con interacción directa y seguimiento personalizado de tu progreso.",
  },
  {
    icon: Radio,
    title: "En vivo",
    description: "Sesiones en tiempo real con instructores expertos. Resuelve tus dudas al instante.",
  },
  {
    icon: Building2,
    title: "Para empresas",
    description: "Programas de capacitación a medida para equipos corporativos y organizaciones.",
  },
];

const CourseTypes = () => {
  return (
    <section className="py-24 section-blue">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              <span className="gradient-text">Modalidades</span> de estudio
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Elegí la forma de aprender que mejor se adapte a tu estilo de vida y objetivos profesionales.
            </p>
          </div>
        </ScrollReveal>

        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {types.map((type, i) => (
            <ScrollReveal key={type.title} delay={i * 0.1}>
              <div className="glass-card p-8 text-center hover-lift h-full">
                <div className="w-14 h-14 rounded-xl gradient-bg flex items-center justify-center mx-auto mb-5">
                  <type.icon className="w-7 h-7 text-primary-foreground" />
                </div>
                <h3 className="text-xl font-semibold mb-3 text-foreground">{type.title}</h3>
                <p className="text-sm text-muted-foreground leading-relaxed">{type.description}</p>
              </div>
            </ScrollReveal>
          ))}
        </div>
      </div>
    </section>
  );
};

export default CourseTypes;
