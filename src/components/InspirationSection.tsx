import ScrollReveal from "./ScrollReveal";
import aiLearning from "@/assets/ai-learning.jpg";

const InspirationSection = () => {
  return (
    <section className="py-24 bg-background">
      <div className="container mx-auto px-4">
        <div className="grid md:grid-cols-2 gap-12 items-center">
          <ScrollReveal direction="left">
            <div>
              <div className="w-12 h-1 gradient-bg rounded-full mb-6" />
              <h2 className="text-3xl md:text-4xl font-bold mb-6 text-foreground">
                <span className="gradient-text">La IA está transformando el mundo.</span>{" "}
                ¿Estás preparado para el cambio?
              </h2>
              <p className="text-lg text-muted-foreground leading-relaxed mb-6">
                «El futuro pertenece a quienes se preparan hoy. La inteligencia artificial no reemplaza personas, 
                reemplaza a quienes no se adaptan.»
              </p>
              <p className="text-muted-foreground leading-relaxed">
                En Instituto Innova Tech creemos que la educación tecnológica es la herramienta más poderosa 
                para construir un futuro profesional sólido. Nuestros cursos están diseñados para que domines 
                las tecnologías que están redefiniendo las industrias.
              </p>
            </div>
          </ScrollReveal>

          <ScrollReveal direction="right" delay={0.2}>
            <div className="relative">
              <div className="absolute -inset-4 gradient-bg rounded-2xl opacity-10 blur-xl" />
              <img
                src={aiLearning}
                alt="Estudiante aprendiendo con inteligencia artificial"
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
