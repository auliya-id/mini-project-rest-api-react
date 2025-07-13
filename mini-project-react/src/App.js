import { BrowserRouter as Router, Routes, Route, Link } from "react-router-dom";
import 'react-loading-skeleton/dist/skeleton.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import LayoutAdmin from "./components/LayoutAdmin";
import Home from "./pages/Home";
// Pelanggan
import Pelanggan from "./pages/Pelanggan";
import PelangganForm from "./components/PelangganForm"; 
// Barang
import Barang from "./pages/Barang";
import BarangForm from "./components/BarangForm";
// Penjualan
import Penjualan from "./pages/Penjualan";
import PenjualanCreate from "./components/PenjualanCreate";
import PenjualanEdit from "./components/PenjualanEdit";

function App() {
    return (
        <Router>
            <LayoutAdmin>
                <Routes>
                    <Route path="/" element={<Home />} />
                    {/* Pelanggan */}
                    <Route path="/pelanggan" element={<Pelanggan />} />
                    <Route path="/pelanggan/create" element={<PelangganForm />} />
                    <Route path="/pelanggan/edit/:id" element={<PelangganForm />} />
                    {/* Barang */}
                    <Route path="/barang" element={<Barang />} />
                    <Route path="/barang/create" element={<BarangForm />} />
                    <Route path="/barang/edit/:id" element={<BarangForm />} />
                    {/* Penjualan */}
                    <Route path="/penjualan" element={<Penjualan />} />
                    <Route path="/penjualan/create" element={<PenjualanCreate />} />
                    <Route path="/penjualan/edit/:id" element={<PenjualanEdit />} />
                </Routes>
            </LayoutAdmin>
        </Router>
    );
}

export default App;
