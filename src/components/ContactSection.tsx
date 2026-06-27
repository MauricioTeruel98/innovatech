import { useState } from "react";
import { Send, MapPin, Mail, Phone } from "lucide-react";
import { toast } from "sonner";
import ScrollReveal from "./ScrollReveal";
import { useSiteContent } from "@/hooks/useSiteContent";
import { sendContact } from "@/lib/api";

const ContactSection = () => {
  const { settings, menu } = useSiteContent();
  const s = settings.contact;
  const socials = (menu.social ?? []).filter((l) => l.enabled);

  const [formData, setFormData] = useState({ name: "", email: "", message: "" });
  const [website, setWebsite] = useState(""); // honeypot anti-spam
  const [submitting, setSubmitting] = useState(false);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (submitting) return;
    setSubmitting(true);
    try {
      const res = await sendContact({ ...formData, website });
      toast.success(res.message || s.success_message);
      setFormData({ name: "", email: "", message: "" });
    } catch (err) {
      toast.error(err instanceof Error ? err.message : "No se pudo enviar el mensaje. Probá de nuevo.");
    } finally {
      setSubmitting(false);
    }
  };

  return (
    <section id="contacto" className="py-24 bg-background">
      <div className="container mx-auto px-4">
        <ScrollReveal>
          <div className="text-center mb-16">
            <h2 className="text-3xl md:text-4xl font-bold mb-4">
              <span className="gradient-text">{s.heading}</span>
            </h2>
            <p className="text-muted-foreground max-w-2xl mx-auto">
              {s.subheading}
            </p>
          </div>
        </ScrollReveal>

        <div className="grid lg:grid-cols-2 gap-12">
          {/* Map & Info */}
          <ScrollReveal direction="left">
            <div className="space-y-6">
              {s.map_embed_url && (
                <div className="rounded-2xl overflow-hidden border border-border h-64">
                  <iframe
                    src={s.map_embed_url}
                    width="100%"
                    height="100%"
                    style={{ border: 0 }}
                    allowFullScreen
                    loading="lazy"
                    title="Ubicación"
                  />
                </div>
              )}

              <div className="space-y-4">
                {s.address && (
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                      <MapPin className="w-5 h-5 text-primary" />
                    </div>
                    <p className="text-muted-foreground text-sm">{s.address}</p>
                  </div>
                )}
                {s.email && (
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                      <Mail className="w-5 h-5 text-primary" />
                    </div>
                    <a href={`mailto:${s.email}`} className="text-muted-foreground text-sm hover:text-primary transition-colors">{s.email}</a>
                  </div>
                )}
                {s.phone && (
                  <div className="flex items-center gap-3">
                    <div className="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center shrink-0">
                      <Phone className="w-5 h-5 text-primary" />
                    </div>
                    <a href={`tel:${s.phone.replace(/\s+/g, "")}`} className="text-muted-foreground text-sm hover:text-primary transition-colors">{s.phone}</a>
                  </div>
                )}
              </div>

              {/* Social */}
              {socials.length > 0 && (
                <div className="flex gap-3 flex-wrap">
                  {socials.map((social, i) => (
                    <a
                      key={`${social.label}-${i}`}
                      href={social.url || "#"}
                      target={social.target === "_blank" ? "_blank" : undefined}
                      rel={social.target === "_blank" ? "noopener noreferrer" : undefined}
                      className="px-4 py-2 rounded-lg border border-border text-sm text-muted-foreground hover:text-primary hover:border-primary transition-colors"
                    >
                      {social.label}
                    </a>
                  ))}
                </div>
              )}
            </div>
          </ScrollReveal>

          {/* Form */}
          <ScrollReveal direction="right" delay={0.2}>
            <form onSubmit={handleSubmit} className="glass-card p-8 space-y-6">
              {/* Honeypot anti-spam: oculto para usuarios reales */}
              <input
                type="text"
                name="website"
                value={website}
                onChange={(e) => setWebsite(e.target.value)}
                tabIndex={-1}
                autoComplete="off"
                aria-hidden="true"
                style={{ position: "absolute", left: "-9999px", width: 1, height: 1, opacity: 0 }}
              />
              <div>
                <label className="block text-sm font-medium text-foreground mb-2">{s.form_name_label}</label>
                <input
                  type="text"
                  required
                  value={formData.name}
                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  className="w-full px-4 py-3 rounded-lg border border-border bg-background text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors"
                  placeholder="Tu nombre"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-foreground mb-2">{s.form_email_label}</label>
                <input
                  type="email"
                  required
                  value={formData.email}
                  onChange={(e) => setFormData({ ...formData, email: e.target.value })}
                  className="w-full px-4 py-3 rounded-lg border border-border bg-background text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors"
                  placeholder="tu@email.com"
                />
              </div>
              <div>
                <label className="block text-sm font-medium text-foreground mb-2">{s.form_message_label}</label>
                <textarea
                  required
                  rows={4}
                  value={formData.message}
                  onChange={(e) => setFormData({ ...formData, message: e.target.value })}
                  className="w-full px-4 py-3 rounded-lg border border-border bg-background text-foreground placeholder:text-muted-foreground focus:outline-none focus:ring-2 focus:ring-primary/30 focus:border-primary transition-colors resize-none"
                  placeholder="¿En qué podemos ayudarte?"
                />
              </div>
              <button
                type="submit"
                disabled={submitting}
                className="w-full inline-flex items-center justify-center gap-2 px-8 py-4 rounded-lg gradient-bg text-primary-foreground font-semibold hover:opacity-90 transition-opacity disabled:opacity-60"
              >
                {submitting ? "Enviando…" : s.form_submit_label} <Send className="w-4 h-4" />
              </button>
            </form>
          </ScrollReveal>
        </div>
      </div>
    </section>
  );
};

export default ContactSection;
