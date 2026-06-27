interface LabsLogoProps {
  height?: number;
  tagline?: string;
  showTagline?: boolean;
  className?: string;
}

/**
 * Logo de InnovaLabs. Basado en el logo del Instituto (ícono + wordmark con
 * degradado y la misma tipografía Space Grotesk), pero con la paleta verde +
 * amarillo y la cabeza reemplazada por un vaso de laboratorio (beaker).
 * SVG inline para que use la fuente de la página y se vea nítido a cualquier tamaño.
 */
const LabsLogo = ({ height = 40, tagline = "Soluciones Digitales", showTagline = true, className }: LabsLogoProps) => {
  // viewBox ajustado al contenido (sin espacio muerto) para que el logo se vea grande.
  const viewBox = "22 28 516 92";
  return (
    <svg
      viewBox={viewBox}
      role="img"
      aria-label="InnovaLabs"
      className={className}
      style={{ height, width: "auto", display: "block" }}
      xmlns="http://www.w3.org/2000/svg"
    >
      <defs>
        <linearGradient id="labGrad" x1="0" y1="0" x2="1" y2="1">
          <stop offset="0" stopColor="#16b364" />
          <stop offset="1" stopColor="#ffd21e" />
        </linearGradient>
        <linearGradient id="labLiquid" x1="0" y1="0" x2="0" y2="1">
          <stop offset="0" stopColor="#1fc977" />
          <stop offset="1" stopColor="#0e9a57" />
        </linearGradient>
        <clipPath id="beakerClip">
          <path d="M40 38 L34 106 a10 10 0 0 0 10 10 h42 a10 10 0 0 0 10 -10 L90 38 Z" />
        </clipPath>
      </defs>

      {/* Líquido (recortado a la forma del vaso) */}
      <g clipPath="url(#beakerClip)">
        <path d="M26 82 q9 -7 19 0 t19 0 t19 0 t19 0 V122 H26 Z" fill="url(#labLiquid)" />
        <circle cx="54" cy="97" r="3.6" fill="#ffe27a" />
        <circle cx="71" cy="103" r="2.6" fill="#fff4c2" />
        <circle cx="62" cy="90" r="2.1" fill="#ffe27a" />
      </g>

      {/* Vidrio del vaso */}
      <g fill="none" stroke="url(#labGrad)" strokeWidth="6" strokeLinecap="round" strokeLinejoin="round">
        <path d="M40 38 L34 106 a10 10 0 0 0 10 10 h42 a10 10 0 0 0 10 -10 L90 38" />
        <path d="M40 38 q-8 0 -12 5" />
        {/* marcas de graduación */}
        <path d="M45 62 h8" strokeWidth="3" opacity="0.85" />
        <path d="M44 76 h8" strokeWidth="3" opacity="0.85" />
      </g>
      {/* Boca del vaso */}
      <ellipse cx="65" cy="38" rx="29" ry="7" fill="none" stroke="url(#labGrad)" strokeWidth="6" />

      {/* Nodos tipo circuito/molécula (vibra "tech", como el cerebro del logo base) */}
      <g stroke="#1fc977" strokeWidth="2.6" fill="#ffd21e" strokeLinecap="round">
        <line x1="52" y1="55" x2="64" y2="61" />
        <line x1="64" y1="61" x2="78" y2="53" />
        <circle cx="52" cy="55" r="3.2" />
        <circle cx="64" cy="61" r="3.2" />
        <circle cx="78" cy="53" r="3.2" />
      </g>

      {/* Wordmark */}
      {showTagline && (
        <text x="150" y="44" fill="#5fcf97" fontFamily="'Space Grotesk', sans-serif"
              fontSize="14" fontWeight="600" letterSpacing="3">
          {tagline.toUpperCase()}
        </text>
      )}
      <text x="148" y="110" fontFamily="'Space Grotesk', sans-serif" fontSize="72" fontWeight="700" letterSpacing="-1.5">
        <tspan fill="#22c780">Innova</tspan><tspan fill="#ffd21e">Labs</tspan>
      </text>
    </svg>
  );
};

export default LabsLogo;
