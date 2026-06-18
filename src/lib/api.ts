import type { Course } from "@/data/courses";

const BASE = import.meta.env.VITE_API_URL ?? "http://localhost/innova-backend/api";

async function fetchJSON<T>(path: string): Promise<T> {
  const res = await fetch(`${BASE}/${path}`);
  if (!res.ok) throw new Error(`API error ${res.status}: ${path}`);
  const json = await res.json();
  return json.data as T;
}

// Normaliza los campos de la API al tipo Course del frontend
function normalize(raw: Record<string, unknown>): Course {
  return {
    id:              String(raw.slug ?? raw.id),
    title:           String(raw.title ?? ""),
    description:     String(raw.description ?? ""),
    longDescription: String(raw.long_description ?? ""),
    duration:        String(raw.duration ?? ""),
    students:        String(raw.students ?? ""),
    level:           String(raw.level ?? ""),
    tag:             String(raw.tag ?? ""),
    popular:         Boolean(raw.popular),
    instructor:      String(raw.instructor ?? ""),
    price:           String(raw.price ?? "Consultar"),
    syllabus:        Array.isArray(raw.syllabus) ? (raw.syllabus as string[]) : [],
  };
}

export async function getCourses(): Promise<Course[]> {
  const data = await fetchJSON<Record<string, unknown>[]>("courses");
  return data.map(normalize);
}

export async function getCourse(slug: string): Promise<Course> {
  const data = await fetchJSON<Record<string, unknown>>(`courses/${slug}`);
  return normalize(data);
}
