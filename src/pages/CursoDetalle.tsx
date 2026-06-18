import { useParams, Link } from "react-router-dom";
import { Clock, Users, ArrowLeft, BookOpen, User, CheckCircle2 } from "lucide-react";
import Navbar from "@/components/Navbar";
import Footer from "@/components/Footer";
import ScrollReveal from "@/components/ScrollReveal";
import { useCourse } from "@/hooks/useCourse";

const CursoDetalle = () => {
  const { id } = useParams<{ id: string }>();
  const { data: course, isLoading, isError } = useCourse(id ?? "");

  if (isLoading) {
    return (
      <div className="min-h-screen bg-background">
        <Navbar />
        <div className="pt-28 pb-16 text-center container mx-auto px-4 text-muted-foreground">
          Cargando curso…
        </div>
        <Footer />
      </div>
    );
  }

  if (isError || !course) {
    return (
      <div className="min-h-screen bg-background">
        <Navbar />
        <div className="pt-28 pb-16 text-center container mx-auto px-4">
          <h1 className="text-3xl font-bold text-foreground mb-4">Curso no encontrado</h1>
          <p className="text-muted-foreground mb-8">El curso que buscás no existe o fue removido.</p>
          <Link to="/cursos" className="inline-flex items-center gap-2 px-6 py-3 rounded-lg gradient-bg text-primary-foreground font-semibold">
            <ArrowLeft className="w-4 h-4" /> Volver a cursos
          </Link>
        </div>
        <Footer />
      </div>
    );
  }

  return (
    <div className="min-h-screen bg-background">
      <Navbar />

      {/* Header */}
      <section className="pt-28 pb-16 gradient-hero">
        <div className="container mx-auto px-4">
          <ScrollReveal>
            <Link to="/cursos" className="inline-flex items-center gap-2 text-primary-foreground/70 hover:text-primary-foreground transition-colors mb-8">
              <ArrowLeft className="w-4 h-4" /> Volver a cursos
            </Link>
            <div className="max-w-3xl">
              <span className="inline-block px-3 py-1 rounded-full text-xs font-medium bg-accent text-accent-foreground mb-4">
                {course.tag}
              </span>
              <h1 className="text-3xl md:text-5xl font-bold text-primary-foreground mb-4">
                {course.title}
              </h1>
              <p className="text-primary-foreground/70 text-lg mb-8">
                {course.description}
              </p>
              <div className="flex flex-wrap items-center gap-6 text-primary-foreground/80 text-sm">
                <span className="flex items-center gap-2">
                  <Clock className="w-4 h-4" /> {course.duration}
                </span>
                <span className="flex items-center gap-2">
                  <Users className="w-4 h-4" /> {course.students} estudiantes
                </span>
                <span className="flex items-center gap-2">
                  <BookOpen className="w-4 h-4" /> {course.level}
                </span>
                <span className="flex items-center gap-2">
                  <User className="w-4 h-4" /> {course.instructor}
                </span>
              </div>
            </div>
          </ScrollReveal>
        </div>
      </section>

      {/* Content */}
      <section className="py-16">
        <div className="container mx-auto px-4">
          <div className="grid lg:grid-cols-3 gap-12">
            {/* Main content */}
            <div className="lg:col-span-2 space-y-12">
              <ScrollReveal>
                <div>
                  <h2 className="text-2xl font-bold text-foreground mb-4">Sobre el curso</h2>
                  <p className="text-muted-foreground leading-relaxed">{course.longDescription}</p>
                </div>
              </ScrollReveal>

              <ScrollReveal delay={0.1}>
                <div>
                  <h2 className="text-2xl font-bold text-foreground mb-6">Temario</h2>
                  <div className="space-y-3">
                    {course.syllabus.map((item, i) => (
                      <div key={i} className="flex items-start gap-3 p-4 rounded-lg bg-muted/50 border border-border">
                        <CheckCircle2 className="w-5 h-5 text-secondary mt-0.5 shrink-0" />
                        <span className="text-foreground">{item}</span>
                      </div>
                    ))}
                  </div>
                </div>
              </ScrollReveal>
            </div>

            {/* Sidebar */}
            <div>
              <ScrollReveal delay={0.2}>
                <div className="glass-card p-8 sticky top-24">
                  <div className="text-center mb-6">
                    <p className="text-sm text-muted-foreground mb-1">Inversión</p>
                    <p className="text-3xl font-bold gradient-text">{course.price}</p>
                  </div>

                  <div className="space-y-4 mb-8">
                    <div className="flex items-center gap-3 text-sm text-muted-foreground">
                      <Clock className="w-4 h-4 text-primary" />
                      <span>Duración: {course.duration}</span>
                    </div>
                    <div className="flex items-center gap-3 text-sm text-muted-foreground">
                      <BookOpen className="w-4 h-4 text-primary" />
                      <span>Nivel: {course.level}</span>
                    </div>
                    <div className="flex items-center gap-3 text-sm text-muted-foreground">
                      <User className="w-4 h-4 text-primary" />
                      <span>Instructor: {course.instructor}</span>
                    </div>
                    <div className="flex items-center gap-3 text-sm text-muted-foreground">
                      <Users className="w-4 h-4 text-primary" />
                      <span>{course.students} estudiantes inscriptos</span>
                    </div>
                  </div>

                  <a
                    href="#contacto"
                    className="block w-full text-center px-6 py-4 rounded-lg gradient-bg text-primary-foreground font-semibold hover:opacity-90 transition-opacity mb-3"
                  >
                    Inscribirme
                  </a>
                  <p className="text-xs text-muted-foreground text-center">
                    Modalidad 100% online con certificación
                  </p>
                </div>
              </ScrollReveal>
            </div>
          </div>
        </div>
      </section>

      <Footer />
    </div>
  );
};

export default CursoDetalle;
