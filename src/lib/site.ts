export type Site = "institute" | "labs";

/**
 * Determina qué sitio mostrar:
 *  - host `labs.*` (producción: labs.institutoinnovatech.com) → labs
 *  - ruta `/labs` (preview local en innovatech.test/labs)      → labs
 *  - resto                                                      → institute
 */
export function detectSite(): Site {
  if (typeof window === "undefined") return "institute";
  const host = window.location.hostname.toLowerCase();
  if (host.startsWith("labs.")) return "labs";
  const path = window.location.pathname.replace(/^\/+/, "").toLowerCase();
  if (path === "labs" || path.startsWith("labs/")) return "labs";
  return "institute";
}

/** True si el host es el subdominio de Labs (sitio Labs en la raíz). */
export function isLabsHost(): boolean {
  if (typeof window === "undefined") return false;
  return window.location.hostname.toLowerCase().startsWith("labs.");
}
