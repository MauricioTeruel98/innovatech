import { motion } from "framer-motion";
import { ArrowRight, Sparkles } from "lucide-react";
import { Link } from "react-router-dom";
import heroBg from "@/assets/hero-bg.jpg";

const Hero = () => {
  return (
    <section className="relative min-h-screen flex items-center overflow-hidden">
      <div className="absolute inset-0">
        <img src={heroBg} alt="" className="w-full h-full object-cover" width={1920} height={1080} />
        <div className="absolute inset-0 bg-gradient-to-r from-foreground/90 via-foreground/70 to-transparent" />
      </div>

      <div className="container mx-auto px-4 relative z-10 pt-20">
        <div className="max-w-2xl">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.2 }}
            className="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/20 border border-primary/30 mb-8"
          >
            <Sparkles className="w-4 h-4 text-accent" />
            <span className="text-sm text-primary-foreground/80">Formación en tecnología e IA</span>
          </motion.div>

          <motion.h1
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.4 }}
            className="text-4xl md:text-6xl lg:text-7xl font-bold leading-tight mb-6"
          >
            <span className="text-primary-foreground">Impulsa tu futuro con </span>
            <span className="bg-gradient-to-r from-[hsl(200,100%,60%)] to-[hsl(177,83%,50%)] bg-clip-text text-transparent">
              tecnología
            </span>
          </motion.h1>

          <motion.p
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.6 }}
            className="text-lg md:text-xl text-primary-foreground/70 mb-10 max-w-lg"
          >
            Cursos y capacitaciones diseñados para prepararte en las habilidades más demandadas del mercado.
          </motion.p>

          <motion.div
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ delay: 0.8 }}
            className="flex flex-wrap gap-4"
          >
            <Link
              to="/cursos"
              className="inline-flex items-center gap-2 px-8 py-4 rounded-lg gradient-bg text-primary-foreground font-semibold hover:opacity-90 transition-opacity"
            >
              Ver cursos <ArrowRight className="w-4 h-4" />
            </Link>
            <a
              href="#nosotros"
              className="inline-flex items-center gap-2 px-8 py-4 rounded-lg border border-primary-foreground/20 text-primary-foreground font-semibold hover:bg-primary-foreground/10 transition-colors"
            >
              Conocenos
            </a>
          </motion.div>
        </div>
      </div>

    </section>
  );
};

export default Hero;
