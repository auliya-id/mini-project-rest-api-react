import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import Swal from "sweetalert2";
import api from "../api/api";
import axios from "axios";

export default function PenjualanCreate() {
    const [items, setItems] = useState([{ id_barang: "", qty: 1 }]);
    const [pelangganList, setPelangganList] = useState([]);
    const [idPelanggan, setIdPelanggan] = useState("");
    const [barangList, setBarangList] = useState([]);
    const [loading, setLoading] = useState(false);
    const [tanggal, setTanggal] = useState("");
    const navigate = useNavigate();

    useEffect(() => {
        api.get("/pelanggan").then((res) => setPelangganList(res.data));
        api.get("/barang").then((res) => setBarangList(res.data));
    }, []);

    const handleItemChange = (index, field, value) => {
        const updated = [...items];
        updated[index][field] = value;
        setItems(updated);
    };

    const addItem = () => {
        setItems([...items, { id_barang: "", qty: 1 }]);
    };

    const removeItem = (index) => {
        const updated = items.filter((_, i) => i !== index);
        setItems(updated);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        setLoading(true);
        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading(),
        });

        try {
        await api.post("/penjualan", {
            id_pelanggan: idPelanggan,
            tanggal: tanggal,
            items: items,
        });

        Swal.fire("Berhasil!", "Transaksi berhasil disimpan", "success");
        navigate("/penjualan");

        } catch (err) {
            console.error(err);
            Swal.fire("Gagal", "Gagal menyimpan transaksi", "error");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="container mt-4">
            <div className="card shadow-sm">
                <div className="card-body">
                    <h3 className="card-title mb-4">Form Transaksi Penjualan</h3>

                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label className="form-label">Pelanggan</label>
                            <select className="form-select" value={idPelanggan} onChange={(e) => setIdPelanggan(e.target.value)} required>
                                <option value="">-- Pilih Pelanggan --</option>
                                {pelangganList.map((p) => (
                                    <option key={p.id} value={p.id}>{p.nama_pelanggan}</option>
                                ))}
                            </select>
                        </div>

                        <div className="mb-3">
                            <label className="form-label">Tanggal</label>
                            <input type="date" className="form-control" value={tanggal} onChange={(e) => setTanggal(e.target.value)} required />
                        </div>

                        <h5 className="mt-4">Daftar Barang</h5>
                        {items.map((item, index) => (
                            <div className="row mb-2" key={index}>
                                <div className="col-md-6">
                                    <select
                                        className="form-select"
                                        value={item.id_barang}
                                        onChange={(e) => handleItemChange(index, "id_barang", e.target.value)}
                                        required
                                    >
                                        <option value="">-- Pilih Barang --</option>
                                        {barangList.map((b) => (
                                            <option key={b.id} value={b.id}>{b.nama_barang}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-md-3">
                                    <input
                                        type="number"
                                        min="1"
                                        className="form-control"
                                        placeholder="Quantity"
                                        value={item.qty}
                                        onChange={(e) => handleItemChange(index, "qty", e.target.value)}
                                        required
                                    />
                                </div>
                                <div className="col-md-3">
                                    <button
                                        type="button"
                                        className="btn btn-danger w-100"
                                        onClick={() => removeItem(index)}
                                        disabled={items.length === 1}
                                    >
                                        Hapus
                                    </button>
                                </div>
                            </div>
                        ))}

                        <div className="mb-3">
                            <button type="button" className="btn btn-secondary" onClick={addItem}>
                                + Tambah Barang
                            </button>
                        </div>

                        <button type="submit" className="btn btn-primary" disabled={loading}>
                            <i className="bi bi-send-check me-2"></i>
                            {loading ? "Menyimpan..." : "Simpan Transaksi"}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );
}
