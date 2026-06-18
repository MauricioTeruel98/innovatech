import { useQuery } from "@tanstack/react-query";
import { getCourses } from "@/lib/api";

export function useCourses() {
  return useQuery({
    queryKey: ["courses"],
    queryFn:  getCourses,
    staleTime: 1000 * 60 * 5, // 5 minutos de caché
  });
}
