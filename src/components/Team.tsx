import { Linkedin } from "lucide-react";
import ScrollReveal from "./ScrollReveal";

const team = [
  { name: "Alejandro Ruiz", role: "Director General", initials: "AR" },
  { name: "Sofía Torres", role: "Directora Académica", initials: "ST" },
  { name: "Martín López", role: "Lead Instructor", initials: "ML" },
  { name: "Valentina Díaz", role: "Coordinadora de Cursos", initials: "VD" },
];

const Team = () => {
  return (
    <section className="py-24 section-blue">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              Nuestro <span className="gradient-text">equipo</span>
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              Profesionales apasionados por la educación y la tecnología.
            </p>
          </div>
        </ScrollReveal>

        <div className="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
          {team.map((member, i) => (
            <ScrollReveal key={member.name} delay={i * 0.1}>
              <div className="glass-card p-8 text-center hover-lift">
                <div className="w-20 h-20 rounded-full gradient-bg flex items-center justify-center mx-auto mb-5">
                  <span className="text-2xl font-bold text-primary-foreground">{member.initials}</span>
                </div>
                <h3 className="text-lg font-semibold text-foreground mb-1">{member.name}</h3>
                <p className="text-sm text-muted-foreground mb-4">{member.role}</p>
                <button className="text-primary hover:text-secondary transition-colors">
                  <Linkedin className="w-5 h-5 mx-auto" />
                </button>
              </div>
            </ScrollReveal>
          ))}
        </div>
      </div>
    </section>
  );
};

export default Team;
