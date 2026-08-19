import { Link, Route, Routes } from "react-router";

import Home from "./pages/Home";
import About from "./pages/About";
import Navbar from "./components/Navbar";
import Products from "./pages/Products";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";

export default function App() {
  const queryClient = new QueryClient()
  return (
    <QueryClientProvider client={queryClient}>
      <div className="min-h-screen bg-gray-100">
        <Navbar />        
        <main className="mx-auto max-w-5xl p-8">
          <Routes>
            <Route path="/" element={<Home />} />
            
            <Route path="/about" element={<About />} />
            
            <Route path="/products" element={<Products />} />
          </Routes>
        </main>
      </div>
    </QueryClientProvider>
  );
}
