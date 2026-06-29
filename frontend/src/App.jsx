import { BrowserRouter, Routes, Route } from "react-router-dom";
import Home from "./pages/Home";
import Observer from "./pages/Observer";
import Judge from "./pages/Judge";

export default function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/observer" element={<Observer />} />
                <Route path="/judge" element={<Judge />} />
            </Routes>
        </BrowserRouter>
    );
}