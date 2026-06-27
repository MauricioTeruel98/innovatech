import { QueryClient, QueryClientProvider } from "@tanstack/react-query";
import { BrowserRouter, Route, Routes } from "react-router-dom";
import { Toaster as Sonner } from "@/components/ui/sonner";
import { Toaster } from "@/components/ui/toaster";
import { TooltipProvider } from "@/components/ui/tooltip";
import Index from "./pages/Index.tsx";
import Cursos from "./pages/Cursos.tsx";
import CursoDetalle from "./pages/CursoDetalle.tsx";
import LabsIndex from "./pages/LabsIndex.tsx";
import NotFound from "./pages/NotFound.tsx";
import { isLabsHost } from "@/lib/site";

const queryClient = new QueryClient();

// En el subdominio labs.* el sitio de InnovaLabs ocupa la raíz.
// En el sitio del instituto, /labs sirve como preview local de InnovaLabs.
const labsHost = isLabsHost();

const App = () => (
  <QueryClientProvider client={queryClient}>
    <TooltipProvider>
      <Toaster />
      <Sonner />
      <BrowserRouter>
        <Routes>
          {labsHost ? (
            <Route path="*" element={<LabsIndex />} />
          ) : (
            <>
              <Route path="/" element={<Index />} />
              <Route path="/cursos" element={<Cursos />} />
              <Route path="/cursos/:id" element={<CursoDetalle />} />
              <Route path="/labs" element={<LabsIndex />} />
              <Route path="*" element={<NotFound />} />
            </>
          )}
        </Routes>
      </BrowserRouter>
    </TooltipProvider>
  </QueryClientProvider>
);

export default App;
