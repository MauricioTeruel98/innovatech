import Navbar from "@/components/Navbar";
import Hero from "@/components/Hero";
import InspirationSection from "@/components/InspirationSection";
import CourseTypes from "@/components/CourseTypes";
import AboutSection from "@/components/AboutSection";
import PopularCourses from "@/components/PopularCourses";
import Testimonials from "@/components/Testimonials";
import SoftwareDev from "@/components/SoftwareDev";
import Team from "@/components/Team";
import ContactSection from "@/components/ContactSection";
import Footer from "@/components/Footer";

const Index = () => {
  return (
    <div className="min-h-screen bg-background">
      <Navbar />
      <Hero />
      <InspirationSection />
      <CourseTypes />
      <AboutSection />
      <PopularCourses />
      <Testimonials />
      <SoftwareDev />
      <Team />
      <ContactSection />
      <Footer />
    </div>
  );
};

export default Index;
