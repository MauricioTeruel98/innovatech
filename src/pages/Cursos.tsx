import { Link } from "react-router-dom";
import { Clock, Users, ArrowRight } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import ScrollReveal from "@/components/ScrollReveal";
import { useCourses } from "@/hooks/useCourses";

const Cursos = () => {
  const { data: courses, isLoading, isError } = useCourses();

  return (
    <div className="min-h-screen bg-background">
      <Navbar />

      {/* Header */}
      <section className="pt-28 pb-16 gradient-hero">
        <div className="container mx-auto px-4">
          <ScrollReveal>
            <div className="text-center">
              <h1 className="text-4xl md:text-5xl font-bold text-primary-foreground mb-4">
                Cursos a distancia
              </h1>
              <p className="text-primary-foreground/70 text-lg max-w-2xl mx-auto">
                Formación online de calidad con acompañamiento docente y certificación al finalizar.
              </p>
            </div>
          </ScrollReveal>
        </div>
      </section>

      {/* Course Grid */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          {isLoading && (
            <div className="text-center py-20 text-muted-foreground">Cargando cursos…</div>
          )}
          {isError && (
            <div className="text-center py-20 text-destructive">
              No se pudieron cargar los cursos. Verificá la conexión con la API.
            </div>
          )}
          {courses && (
            <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
              {courses.map((course, i) => (
                <ScrollReveal key={course.id} delay={i * 0.08}>
                  <div className="glass-card overflow-hidden hover-lift h-full flex flex-col">
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
                        <span className="flex items-center gap-1"><Clock className="w-4 h-4" /> {course.duration}</span>
                        <span className="flex items-center gap-1"><Users className="w-4 h-4" /> {course.students}</span>
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
          )}
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default Cursos;
