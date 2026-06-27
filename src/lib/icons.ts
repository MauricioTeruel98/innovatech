/**
 * Mapa de nombres de íconos (los que ofrece el panel) a componentes de lucide-react.
 * Debe mantenerse sincronizado con backend/lib/icons.php (icon_options()).
 */
import {
  Sparkles, Rocket, GraduationCap, BookOpen, Award, Trophy,
  Lightbulb, Target, TrendingUp, Compass, Star, Heart,
  Code2, Cpu, Database, Cloud, Shield, ShieldCheck,
  Globe, Zap, Layers, Settings, Terminal, Braces,
  Users, User, UserCheck, Monitor, Radio, Building2,
  Briefcase, Smartphone, Wifi, Video, Presentation, MessagesSquare,
  BarChart3, PieChart, LineChart, PenTool, Palette, Figma,
  ArrowRight, ArrowUpRight, CheckCircle2, Clock, Calendar,
  MapPin, Mail, Phone, Send, Megaphone,
  type LucideIcon,
} from "lucide-react";

export const iconMap: Record<string, LucideIcon> = {
  Sparkles, Rocket, GraduationCap, BookOpen, Award, Trophy,
  Lightbulb, Target, TrendingUp, Compass, Star, Heart,
  Code2, Cpu, Database, Cloud, Shield, ShieldCheck,
  Globe, Zap, Layers, Settings, Terminal, Braces,
  Users, User, UserCheck, Monitor, Radio, Building2,
  Briefcase, Smartphone, Wifi, Video, Presentation, MessagesSquare,
  BarChart3, PieChart, LineChart, PenTool, Palette, Figma,
  ArrowRight, ArrowUpRight, CheckCircle2, Clock, Calendar,
  MapPin, Mail, Phone, Send, Megaphone,
};

/**
 * Devuelve el componente de ícono para un nombre dado.
 * Si no existe (o está vacío), devuelve `fallback` (por defecto un ícono neutro).
 */
export function getIcon(name?: string | null, fallback: LucideIcon = Sparkles): LucideIcon {
  if (name && iconMap[name]) return iconMap[name];
  return fallback;
}
