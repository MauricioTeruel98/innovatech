import { useQuery } from "@tanstack/react-query";
import { getLabsContent } from "@/lib/api";
import { mergeLabsContent, type LabsContent } from "@/data/labsContent";

/** Contenido de InnovaLabs combinado con los valores por defecto (siempre usable). */
export function useLabsContent(): LabsContent {
  const { data } = useQuery({
    queryKey: ["labs-site"],
    queryFn: getLabsContent,
    staleTime: 1000 * 60 * 5,
  });
  return mergeLabsContent(data);
}
