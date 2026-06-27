import { Link } from "react-router-dom";
import type { ReactNode } from "react";

interface SmartLinkProps {
  to: string;
  className?: string;
  children: ReactNode;
  onClick?: () => void;
}

/**
 * Renderiza el elemento de enlace correcto según el destino:
 *   - URL externa (http/https/mailto/tel) → <a target="_blank">
 *   - Ancla (#seccion)                     → <a href="#...">
 *   - Ruta interna (/...)                  → <Link> de react-router
 *   - Vacío                                → <span> (sin enlace, ej. "próximamente")
 */
export function SmartLink({ to, className, children, onClick }: SmartLinkProps) {
  if (!to) {
    return <span className={className}>{children}</span>;
  }

  const isExternal = /^(https?:\/\/|mailto:|tel:)/i.test(to);
  if (isExternal) {
    return (
      <a href={to} target="_blank" rel="noopener noreferrer" className={className} onClick={onClick}>
        {children}
      </a>
    );
  }

  if (to.startsWith("#")) {
    return (
      <a href={to} className={className} onClick={onClick}>
        {children}
      </a>
    );
  }

  return (
    <Link to={to} className={className} onClick={onClick}>
      {children}
    </Link>
  );
}

export default SmartLink;
