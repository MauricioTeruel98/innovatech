import { useQuery } from "@tanstack/react-query";
import { getCourse } from "@/lib/api";

export function useCourse(slug: string) {
  return useQuery({
    queryKey: ["courses", slug],
    queryFn:  () => getCourse(slug),
    enabled:  Boolean(slug),
    staleTime: 1000 * 60 * 5,
  });
}
