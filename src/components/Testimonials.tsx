import { Star, ChevronLeft, ChevronRight } from "lucide-react";
import ScrollReveal from "./ScrollReveal";
import {
  Carousel,
  CarouselContent,
  CarouselItem,
  CarouselPrevious,
  CarouselNext,
} from "@/components/ui/carousel";

const testimonials = [
  { name: "María González", role: "Desarrolladora Web", text: "Gracias a Innova Tech pude hacer la transición a tecnología. Los cursos son prácticos y los instructores excelentes." },
  { name: "Carlos Méndez", role: "Data Analyst", text: "La calidad del contenido y el acompañamiento de los profesores superaron mis expectativas. 100% recomendado." },
  { name: "Laura Fernández", role: "UX Designer", text: "Empecé sin conocimientos técnicos y hoy trabajo en lo que me apasiona. El instituto me dio las herramientas que necesitaba." },
  { name: "Diego Ramírez", role: "Cloud Engineer", text: "El curso de DevOps me permitió certificarme y conseguir un ascenso en menos de 6 meses. Totalmente vale la pena." },
  { name: "Ana Torres", role: "Data Scientist", text: "Python para Ciencia de Datos cambió mi carrera. Los proyectos prácticos me dieron la confianza para aplicar a empresas top." },
];

const Testimonials = () => {
  return (
    <section className="py-24 section-teal">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              Lo que dicen nuestros <span className="gradient-text">estudiantes</span>
            </h2>
          </div>
        </ScrollReveal>

        <ScrollReveal>
          <Carousel opts={{ align: "start", loop: true }} className="w-full max-w-5xl mx-auto">
            <CarouselContent className="-ml-4">
              {testimonials.map((t) => (
                <CarouselItem key={t.name} className="pl-4 md:basis-1/2 lg:basis-1/3">
                  <div className="glass-card p-8 hover-lift h-full flex flex-col">
                    <div className="flex gap-1 mb-4">
                      {[...Array(5)].map((_, j) => (
                        <Star key={j} className="w-4 h-4 fill-accent text-accent" />
                      ))}
                    </div>
                    <p className="text-muted-foreground mb-6 flex-1 italic">"{t.text}"</p>
                    <div>
                      <p className="font-semibold text-foreground">{t.name}</p>
                      <p className="text-sm text-muted-foreground">{t.role}</p>
                    </div>
                  </div>
                </CarouselItem>
              ))}
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
