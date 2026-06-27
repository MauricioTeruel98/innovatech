/**
 * Tipos y valores por defecto del contenido de InnovaLabs (site = 'labs').
 * Igual que el sitio del instituto, los `defaults` reflejan el contenido inicial
 * y sirven de respaldo mientras carga la API o si el backend no responde.
 */
import type { Testimonial, MenuLink, SettingsMap } from "./siteContent";

export interface LabBlock {
  icon: string;
  title: string;
  description: string;
  extra: string;
}

export interface LabPlan {
  name: string;
  price: string;
  period: string;
  description: string;
  features: string[];
  highlighted: boolean;
  cta_label: string;
  cta_url: string;
}

export interface LabsContent {
  settings: SettingsMap;
  services: LabBlock[];
  solutions: LabBlock[];
  process: LabBlock[];
  features: LabBlock[];
  plans: LabPlan[];
  testimonials: Testimonial[];
  menu: Record<string, MenuLink[]>;
}

export const defaultLabsContent: LabsContent = {
  settings: {
    general: { site_name: "InnovaLabs", tagline: "Soluciones Digitales", logo: "", logo_alt: "InnovaLabs" },
    navbar: {
      services_label: "Servicios", solutions_label: "Soluciones", plans_label: "Planes",
      contact_label: "Contacto", cta_label: "Cotizar proyecto", cta_url: "#contacto",
    },
    hero: {
      badge_text: "Desarrollo web & soluciones digitales",
      heading_part1: "Construimos la web que tu ",
      heading_highlight: "negocio necesita",
      subheading: "Diseñamos, desarrollamos y mantenemos sitios web, tiendas online y plataformas a medida. Hosting, soporte y todo lo que necesitás, en un solo lugar.",
      primary_cta_label: "Cotizar mi proyecto", primary_cta_url: "#contacto",
      secondary_cta_label: "Ver servicios", secondary_cta_url: "#servicios",
      stat1_value: "+120", stat1_label: "Proyectos entregados",
      stat2_value: "99.9%", stat2_label: "Uptime de hosting",
      stat3_value: "24/7", stat3_label: "Soporte técnico",
    },
    services: { heading: "Nuestros", heading_highlight: "servicios", subheading: "Todo lo que tu presencia digital necesita, de principio a fin." },
    solutions: { heading: "Soluciones a", heading_highlight: "tu medida", subheading: "Desarrollamos el tipo de plataforma que tu proyecto necesita." },
    process: { heading: "Cómo", heading_highlight: "trabajamos", subheading: "Un proceso claro y colaborativo, de la idea al lanzamiento." },
    features: { heading: "¿Por qué", heading_highlight: "InnovaLabs?", subheading: "Tecnología moderna, diseño cuidado y soporte real." },
    plans: { heading: "Planes y", heading_highlight: "precios", subheading: "Opciones flexibles que se adaptan a cada etapa de tu negocio.", note: "¿Necesitás algo a medida? Escribinos y armamos una propuesta para vos." },
    testimonials: { heading: "Lo que dicen nuestros", heading_highlight: "clientes" },
    contact: {
      heading: "¿Listo para", heading_highlight: "empezar?",
      subheading: "Contanos sobre tu proyecto y te enviamos una propuesta sin compromiso.",
      address: "Tucumán, Argentina", email: "labs@institutoinnovatech.com", phone: "+54 381 465 3130",
      whatsapp: "5493814653130", success_message: "¡Gracias! Te contactaremos a la brevedad.",
      form_name_label: "Nombre", form_email_label: "Email",
      form_message_label: "Contanos sobre tu proyecto", form_submit_label: "Enviar consulta",
    },
    footer: {
      about_text: "Estudio de desarrollo web del Instituto InnovaTech. Creamos soluciones digitales modernas para empresas y emprendedores.",
      copyright_text: "InnovaLabs — Instituto InnovaTech. Todos los derechos reservados.",
      developed_by_label: "Parte de", developed_by_name: "Instituto InnovaTech",
      parent_url: "https://institutoinnovatech.com",
    },
  },
  services: [
    { icon: "Code2", title: "Desarrollo Web", description: "Sitios y aplicaciones web rápidos, seguros y a medida, con las últimas tecnologías.", extra: "" },
    { icon: "Server", title: "Hosting Web", description: "Alojamiento confiable con certificado SSL, copias de seguridad y 99.9% de uptime.", extra: "" },
    { icon: "Wrench", title: "Mantenimiento", description: "Actualizaciones, soporte, monitoreo y mejoras continuas para que tu web nunca pare.", extra: "" },
  ],
  solutions: [
    { icon: "Rocket", title: "Landing Pages", description: "Páginas de alto impacto orientadas a conversión para campañas y lanzamientos.", extra: "" },
    { icon: "ShoppingCart", title: "Tiendas Online", description: "Ecommerce completo con pasarelas de pago, gestión de productos y envíos.", extra: "" },
    { icon: "Building2", title: "Webs Institucionales", description: "Sitios corporativos profesionales que transmiten confianza y posicionan tu marca.", extra: "" },
    { icon: "GraduationCap", title: "Aulas Virtuales", description: "Plataformas de e-learning con Moodle para capacitaciones y cursos online.", extra: "" },
  ],
  process: [
    { icon: "Search", title: "Análisis", description: "Entendemos tu negocio, objetivos y público para definir la mejor solución.", extra: "01" },
    { icon: "PenTool", title: "Diseño", description: "Creamos una propuesta visual moderna, alineada a la identidad de tu marca.", extra: "02" },
    { icon: "Code2", title: "Desarrollo", description: "Programamos tu plataforma con código limpio, rápido y escalable.", extra: "03" },
    { icon: "Rocket", title: "Lanzamiento", description: "Publicamos, optimizamos y te acompañamos con soporte continuo.", extra: "04" },
  ],
  features: [
    { icon: "Smartphone", title: "Diseño responsive", description: "Se ve perfecto en celulares, tablets y computadoras.", extra: "" },
    { icon: "Gauge", title: "Velocidad y SEO", description: "Optimizado para cargar rápido y posicionar en Google.", extra: "" },
    { icon: "ShieldCheck", title: "Seguridad", description: "SSL, copias de seguridad y buenas prácticas para proteger tu sitio.", extra: "" },
    { icon: "Headphones", title: "Soporte real", description: "Te respondemos rápido, con personas, no con bots.", extra: "" },
  ],
  plans: [
    { name: "Landing Page", price: "Consultar", period: "pago único", description: "Ideal para campañas y presencia inicial.",
      features: ["1 página optimizada", "Diseño responsive", "Formulario de contacto", "SEO básico", "Publicación incluida"], highlighted: false, cta_label: "Cotizar", cta_url: "#contacto" },
    { name: "Sitio Profesional", price: "Consultar", period: "pago único", description: "Para empresas que quieren destacar.",
      features: ["Hasta 6 secciones", "Diseño a medida", "Blog / novedades", "SEO + Analytics", "3 meses de soporte"], highlighted: true, cta_label: "Cotizar", cta_url: "#contacto" },
    { name: "Hosting + Mantenimiento", price: "Consultar", period: "por mes", description: "Mantené tu web online y al día.",
      features: ["Hosting SSD + SSL", "Copias de seguridad", "Actualizaciones", "Monitoreo 24/7", "Soporte prioritario"], highlighted: false, cta_label: "Contratar", cta_url: "#contacto" },
  ],
  testimonials: [
    { name: "Marcos Giordano", role: "Dueño de tienda online", quote: "Mi ecommerce vende todos los días. El equipo entendió justo lo que necesitaba y lo entregó en tiempo.", rating: 5, photo: "" },
    { name: "Lucía Fernández", role: "Directora de Marketing", quote: "La landing que armaron triplicó nuestras conversiones en la campaña. Diseño impecable.", rating: 5, photo: "" },
    { name: "Esteban Ríos", role: "Coordinador académico", quote: "El aula virtual en Moodle nos permitió escalar los cursos online sin complicaciones.", rating: 5, photo: "" },
  ],
  menu: {
    social: [
      { label: "Instagram", url: "#", target: "_blank", enabled: true },
      { label: "LinkedIn", url: "#", target: "_blank", enabled: true },
      { label: "WhatsApp", url: "https://wa.me/5493814653130", target: "_blank", enabled: true },
    ],
  },
};

export function mergeLabsContent(data?: Partial<LabsContent> | null): LabsContent {
  if (!data) return defaultLabsContent;

  const settings: SettingsMap = {};
  const sections = new Set([
    ...Object.keys(defaultLabsContent.settings),
    ...Object.keys(data.settings ?? {}),
  ]);
  for (const sec of sections) {
    settings[sec] = { ...(defaultLabsContent.settings[sec] ?? {}), ...((data.settings ?? {})[sec] ?? {}) };
  }

  const nonEmpty = <T,>(arr: T[] | undefined, fallback: T[]) => (arr && arr.length ? arr : fallback);

  return {
    settings,
    services: nonEmpty(data.services, defaultLabsContent.services),
    solutions: nonEmpty(data.solutions, defaultLabsContent.solutions),
    process: nonEmpty(data.process, defaultLabsContent.process),
    features: nonEmpty(data.features, defaultLabsContent.features),
    plans: nonEmpty(data.plans, defaultLabsContent.plans),
    testimonials: nonEmpty(data.testimonials, defaultLabsContent.testimonials),
    menu: { ...defaultLabsContent.menu, ...(data.menu ?? {}) },
  };
}
