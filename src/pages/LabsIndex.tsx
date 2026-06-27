import { useEffect } from "react";
import LabsNavbar from "@/components/labs/LabsNavbar";
import LabsHero from "@/components/labs/LabsHero";
import LabsServices from "@/components/labs/LabsServices";
import LabsSolutions from "@/components/labs/LabsSolutions";
import LabsProcess from "@/components/labs/LabsProcess";
import LabsFeatures from "@/components/labs/LabsFeatures";
import LabsPlans from "@/components/labs/LabsPlans";
import LabsTestimonials from "@/components/labs/LabsTestimonials";
import LabsContact from "@/components/labs/LabsContact";
import LabsFooter from "@/components/labs/LabsFooter";
import { useLabsContent } from "@/hooks/useLabsContent";

const LabsIndex = () => {
  const { settings } = useLabsContent();
  const siteName = settings.general?.site_name || "InnovaLabs";

  // Aplicar el tema oscuro a todo el documento (incluye el fondo del body / overscroll).
  useEffect(() => {
    const html = document.documentElement;
    html.classList.add("labs-theme");
    const prevBodyBg = document.body.style.backgroundColor;
    document.body.style.backgroundColor = "hsl(200 33% 6%)";
    const prevTitle = document.title;
    return () => {
      html.classList.remove("labs-theme");
      document.body.style.backgroundColor = prevBodyBg;
      document.title = prevTitle;
    };
  }, []);

  useEffect(() => {
    document.title = `${siteName} — Desarrollo web & soluciones digitales`;
  }, [siteName]);

  return (
    <div className="labs-theme min-h-screen bg-background text-foreground">
      <LabsNavbar />
      <LabsHero />
      <LabsServices />
      <LabsSolutions />
      <LabsProcess />
      <LabsFeatures />
      <LabsPlans />
      <LabsTestimonials />
      <LabsContact />
      <LabsFooter />
    </div>
  );
};

export default LabsIndex;
