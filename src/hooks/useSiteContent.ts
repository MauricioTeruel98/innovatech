import { useQuery } from "@tanstack/react-query";
import { getSiteContent } from "@/lib/api";
import { mergeContent, type SiteContent } from "@/data/siteContent";

/**
 * Devuelve el contenido del sitio combinado con los valores por defecto.
 * Siempre retorna un objeto usable: mientras carga (o si la API falla) usa los
 * defaults, por lo que los componentes pueden renderizar sin estados de carga.
 */
export function useSiteContent(): SiteContent {
  const { data } = useQuery({
    queryKey: ["site"],
    queryFn: getSiteContent,
    staleTime: 1000 * 60 * 5,
  });
  return mergeContent(data);
}
