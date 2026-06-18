import { Link } from "react-router-dom";
import { Clock, Users, ArrowRight, TrendingUp } from "lucide-react";
import ScrollReveal from "./ScrollReveal";
import { useCourses } from "@/hooks/useCourses";

const PopularCourses = () => {
  const { data: courses, isLoading } = useCourses();
  const popular = courses?.filter((c) => c.popular) ?? [];

  if (isLoading) {
    return (
      <section className="py-24 section-blue">
        <div className="container mx-auto px-4 text-center text-muted-foreground">
          Cargando cursos destacados…
        </div>
      </section>
    );
  }

  if (popular.length === 0) return null;

  return (
    <section className="py-24 section-blue">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <div className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 border border-primary/20 mb-6">
              <TrendingUp className="w-4 h-4 text-primary" />
              <span className="text-sm font-medium text-primary">Los más elegidos</span>
            </div>
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              Cursos más <span className="gradient-text">demandados</span>
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Descubrí los cursos que más eligen nuestros estudiantes para impulsar su carrera en tecnología.
            </p>
          </div>
        </ScrollReveal>

        <div className="grid md:grid-cols-3 gap-8">
          {popular.map((course, i) => (
            <ScrollReveal key={course.id} delay={i * 0.12}>
              <div className="glass-card overflow-hidden hover-lift h-full flex flex-col">
                <div className="h-2 gradient-bg" />
                <div className="p-6 flex-1 flex flex-col">
                  <div className="flex items-center justify-between mb-4">
                    <span className="px-3 py-1 rounded-full text-xs font-medium gradient-bg text-primary-foreground">
                      {course.tag}
                    </span>
                    <span className="text-xs text-muted-foreground">{course.level}</span>
                  </div>
                  <h3 className="text-lg font-semibold text-foreground mb-3">{course.title}</h3>
                  <p className="text-sm text-muted-foreground mb-6 flex-1">{course.description}</p>
                  <div className="flex items-center gap-4 mb-6 text-sm text-muted-foreground">
                    <span className="flex items-center gap-1">
                      <Clock className="w-4 h-4" /> {course.duration}
                    </span>
                    <span className="flex items-center gap-1">
                      <Users className="w-4 h-4" /> {course.students}
                    </span>
                  </div>
                  <Link
                    to={`/cursos/${course.id}`}
                    className="inline-flex items-center justify-center gap-2 w-full px-4 py-3 rounded-lg border border-primary text-primary font-medium text-sm hover:bg-primary hover:text-primary-foreground transition-colors"
                  >
                    Ver curso <ArrowRight className="w-4 h-4" />
                  </Link>
                </div>
              </div>
            </ScrollReveal>
          ))}
        </div>

        <ScrollReveal delay={0.3}>
          <div className="text-center mt-12">
            <Link
              to="/cursos"
              className="inline-flex items-center gap-2 px-8 py-4 rounded-lg gradient-bg text-primary-foreground font-semibold hover:opacity-90 transition-opacity"
            >
              Ver todos los cursos <ArrowRight className="w-4 h-4" />
            </Link>
          </div>
        </ScrollReveal>
      </div>
    </section>
  );
};

export default PopularCourses;
