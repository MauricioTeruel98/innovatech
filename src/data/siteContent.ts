/**
 * Tipos y valores por defecto del contenido administrable del sitio.
 *
 * Los `defaults` reflejan exactamente el contenido original hardcodeado. Se usan:
 *   - mientras carga la API (sin parpadeo de contenido vacío),
 *   - si la API falla o el backend no está disponible,
 *   - como respaldo por-clave si faltara algún ajuste en la base de datos.
 *
 * En runtime, el contenido real proviene del endpoint PHP `GET /api/site`.
 */

export interface MenuLink {
  label: string;
  url: string;
  target: string;
  enabled: boolean;
}

export interface TeamMember {
  name: string;
  role: string;
  initials: string;
  photo: string;        // URL absoluta o "" (usar iniciales)
  linkedin_url: string;
}

export interface Testimonial {
  name: string;
  role: string;
  quote: string;
  rating: number;
  photo: string;        // URL absoluta o ""
}

export interface IconCard {
  icon: string;         // nombre de ícono (lucide)
  title: string;
  description: string;
}

/** settings[section][key] = valor (string). Las imágenes vienen como URL o "". */
export type SettingsMap = Record<string, Record<string, string>>;

export interface SiteContent {
  settings: SettingsMap;
  team: TeamMember[];
  testimonials: Testimonial[];
  values: IconCard[];
  modalities: IconCard[];
  menu: Record<string, MenuLink[]>;
}

export const defaultContent: SiteContent = {
  settings: {
    general: {
      site_name: "Instituto Innova Tech",
      logo: "",
      logo_alt: "Instituto Innova Tech",
    },
    hero: {
      badge_text: "Formación en tecnología e IA",
      heading_part1: "Impulsa tu futuro con ",
      heading_highlight: "tecnología",
      subheading: "Cursos y capacitaciones diseñados para prepararte en las habilidades más demandadas del mercado.",
      primary_cta_label: "Ver cursos",
      primary_cta_url: "/cursos",
      secondary_cta_label: "Conocenos",
      secondary_cta_url: "#nosotros",
      background_image: "",
    },
    inspiration: {
      title_highlight: "La IA está transformando el mundo.",
      title_rest: "¿Estás preparado para el cambio?",
      quote: "«El futuro pertenece a quienes se preparan hoy. La inteligencia artificial no reemplaza personas, reemplaza a quienes no se adaptan.»",
      body_paragraph: "En Instituto Innova Tech creemos que la educación tecnológica es la herramienta más poderosa para construir un futuro profesional sólido. Nuestros cursos están diseñados para que domines las tecnologías que están redefiniendo las industrias.",
      image: "",
      image_alt: "Estudiante aprendiendo con inteligencia artificial",
    },
    modalities: {
      heading_highlight: "Modalidades",
      heading_rest: "de estudio",
      subheading: "Elegí la forma de aprender que mejor se adapte a tu estilo de vida y objetivos profesionales.",
    },
    about: {
      heading: "Sobre",
      heading_highlight: "nosotros",
      subheading: "Somos un instituto especializado en formación tecnológica, comprometidos con la excelencia educativa y el desarrollo profesional de cada estudiante.",
    },
    popular: {
      badge_text: "Los más elegidos",
      heading: "Cursos más",
      heading_highlight: "demandados",
      subheading: "Descubrí los cursos que más eligen nuestros estudiantes para impulsar su carrera en tecnología.",
      cta_label: "Ver todos los cursos",
    },
    testimonials: {
      heading: "Lo que dicen nuestros",
      heading_highlight: "estudiantes",
    },
    team: {
      heading: "Nuestro",
      heading_highlight: "equipo",
      subheading: "Profesionales apasionados por la educación y la tecnología.",
    },
    softwaredev: {
      icon: "Code2",
      heading: "Desarrollo de Software a medida",
      description: "Además de la formación, ofrecemos servicios profesionales de desarrollo de software. Creamos soluciones digitales personalizadas para tu negocio: aplicaciones web, móviles, sistemas de gestión y más.",
      cta_label: "Conocer más",
      cta_url: "https://example.com",
    },
    navbar: {
      home_label: "Inicio",
      home_url: "/",
      courses_label: "Cursos",
      about_label: "Quiénes somos",
      about_url: "#nosotros",
      software_label: "Desarrollo de software",
      software_url: "https://example.com",
      contact_label: "Contacto",
      contact_url: "#contacto",
    },
    contact: {
      heading: "Contacto",
      subheading: "¿Tenés alguna consulta? Escribinos y te responderemos a la brevedad.",
      address: "Tucumán, Argentina",
      email: "info@institutoinnovatech.com",
      phone: "+54 381 465 3130",
      map_embed_url: "",
      success_message: "Mensaje enviado. ¡Gracias por contactarnos!",
      form_name_label: "Nombre",
      form_email_label: "Email",
      form_message_label: "Mensaje",
      form_submit_label: "Enviar mensaje",
    },
    footer: {
      copyright_text: "Instituto Innova Tech. Todos los derechos reservados.",
      developed_by_label: "Desarrollado por",
      developed_by_name: "InnovaLabs",
    },
  },
  team: [
    { name: "Alejandro Ruiz", role: "Director General", initials: "AR", photo: "", linkedin_url: "" },
    { name: "Sofía Torres", role: "Directora Académica", initials: "ST", photo: "", linkedin_url: "" },
    { name: "Martín López", role: "Lead Instructor", initials: "ML", photo: "", linkedin_url: "" },
    { name: "Valentina Díaz", role: "Coordinadora de Cursos", initials: "VD", photo: "", linkedin_url: "" },
  ],
  testimonials: [
    { name: "María González", role: "Desarrolladora Web", quote: "Gracias a Innova Tech pude hacer la transición a tecnología. Los cursos son prácticos y los instructores excelentes.", rating: 5, photo: "" },
    { name: "Carlos Méndez", role: "Data Analyst", quote: "La calidad del contenido y el acompañamiento de los profesores superaron mis expectativas. 100% recomendado.", rating: 5, photo: "" },
    { name: "Laura Fernández", role: "UX Designer", quote: "Empecé sin conocimientos técnicos y hoy trabajo en lo que me apasiona. El instituto me dio las herramientas que necesitaba.", rating: 5, photo: "" },
    { name: "Diego Ramírez", role: "Cloud Engineer", quote: "El curso de DevOps me permitió certificarme y conseguir un ascenso en menos de 6 meses. Totalmente vale la pena.", rating: 5, photo: "" },
    { name: "Ana Torres", role: "Data Scientist", quote: "Python para Ciencia de Datos cambió mi carrera. Los proyectos prácticos me dieron la confianza para aplicar a empresas top.", rating: 5, photo: "" },
  ],
  values: [
    { icon: "Target", title: "Misión", description: "Democratizar el acceso a educación tecnológica de calidad, preparando profesionales competitivos para el mercado actual." },
    { icon: "Lightbulb", title: "Innovación", description: "Actualizamos constantemente nuestros programas para incluir las últimas tendencias y herramientas del sector." },
    { icon: "TrendingUp", title: "Resultados", description: "Nuestros egresados aplican lo aprendido desde el primer día, con proyectos reales y habilidades demandadas." },
  ],
  modalities: [
    { icon: "Monitor", title: "Online", description: "Aprende a tu ritmo desde cualquier lugar con acceso 24/7 a todo el material del curso." },
    { icon: "Users", title: "Presenciales", description: "Clases prácticas con interacción directa y seguimiento personalizado de tu progreso." },
    { icon: "Radio", title: "En vivo", description: "Sesiones en tiempo real con instructores expertos. Resuelve tus dudas al instante." },
    { icon: "Building2", title: "Para empresas", description: "Programas de capacitación a medida para equipos corporativos y organizaciones." },
  ],
  menu: {
    navbar_dropdown: [
      { label: "A distancia", url: "/cursos", target: "_self", enabled: true },
      { label: "En vivo (próximamente)", url: "", target: "_self", enabled: false },
      { label: "Presencial (próximamente)", url: "", target: "_self", enabled: false },
      { label: "Para empresas (próximamente)", url: "", target: "_self", enabled: false },
    ],
    social: [
      { label: "Instagram", url: "#", target: "_blank", enabled: true },
      { label: "LinkedIn", url: "#", target: "_blank", enabled: true },
      { label: "YouTube", url: "#", target: "_blank", enabled: true },
    ],
  },
};

/** Combina la respuesta de la API sobre los defaults (respaldo por-sección y por-clave). */
export function mergeContent(data?: Partial<SiteContent> | null): SiteContent {
  if (!data) return defaultContent;

  const settings: SettingsMap = {};
  const sections = new Set([
    ...Object.keys(defaultContent.settings),
    ...Object.keys(data.settings ?? {}),
  ]);
  for (const sec of sections) {
    settings[sec] = {
      ...(defaultContent.settings[sec] ?? {}),
      ...((data.settings ?? {})[sec] ?? {}),
    };
  }

  return {
    settings,
    team: data.team ?? defaultContent.team,
    testimonials: data.testimonials ?? defaultContent.testimonials,
    values: data.values ?? defaultContent.values,
    modalities: data.modalities ?? defaultContent.modalities,
    menu: {
      ...defaultContent.menu,
      ...(data.menu ?? {}),
    },
  };
}
