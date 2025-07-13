import { useNavigate, useParams } from "react-router-dom";
import React, { useEffect, useState } from "react";
import Swal from "sweetalert2";
import api from "../api/api";
import axios from "axios";

export default function PenjualanEdit() {
    const [pelangganList, setPelangganList] = useState([]);
    const [idPelanggan, setIdPelanggan] = useState("");
    const [barangList, setBarangList] = useState([]);
    const [loading, setLoading] = useState(true);
    const [subtotal, setSubtotal] = useState(0);
    const [tanggal, setTanggal] = useState("");
    const [items, setItems] = useState([]);
    const navigate = useNavigate();
    const { id } = useParams();

    useEffect(() => {
        const fetchData = async () => {
            try {
                const [pelangganRes, barangRes, penjualanRes] = await Promise.all([
                    api.get("/pelanggan"),
                    api.get("/barang"),
                    api.get(`/penjualan/${id}`)
                ]);

                setPelangganList(pelangganRes.data);
                setBarangList(barangRes.data);

                const trx = penjualanRes.data;
                setTanggal(trx.tanggal);
                setIdPelanggan(trx.id_pelanggan);
                setItems(trx.items.map((item) => ({
                    id_barang: item.id_barang,
                    qty: item.qty
                })));
            } catch (error) {
                console.error("Gagal fetch data:", error);
                Swal.fire("Error", "Gagal mengambil data untuk edit.", "error");
            } finally {
                setLoading(false);
            }
        };

        fetchData();
    }, [id]);

    useEffect(() => {
        let total = 0;
        items.forEach((item) => {
            const barang = barangList.find((b) => b.id === parseInt(item.id_barang));
            if (barang) {
                total += barang.harga * item.qty;
            }
        });
        setSubtotal(total);
    }, [items, barangList]);

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
        Swal.fire({
            title: 'Menyimpan perubahan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            await api.put(`/penjualan/${id}`, {
                id_pelanggan: idPelanggan,
                tanggal,
                subtotal,
                items
            });

            Swal.fire("Berhasil!", "Transaksi berhasil diperbarui", "success");
            navigate("/penjualan");
        } catch (err) {
            console.error(err);
            Swal.fire("Gagal", "Terjadi kesalahan saat menyimpan", "error");
        }
    };

    if (loading) {
        return (
            <div className="container mt-4">
                <div className="card">
                    <div className="card-body">
                        <h4 className="placeholder-glow">
                            <span className="placeholder col-6"></span>
                        </h4>
                        <div className="placeholder-glow">
                            <p className="placeholder col-4"></p>
                            <p className="placeholder col-3"></p>
                            <p className="placeholder col-2"></p>
                            <p className="placeholder col-5"></p>
                        </div>
                    </div>
                </div>
            </div>
        );
    }

    return (
        <div className="container mt-4">
            <div className="card shadow-sm">
                <div className="card-body">
                    <h3 className="card-title mb-4">Edit Transaksi Penjualan</h3>

                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label className="form-label">Tanggal</label>
                            <input type="date" className="form-control" value={tanggal} onChange={(e) => setTanggal(e.target.value)} required />
                        </div>

                        <div className="mb-3">
                            <label className="form-label">Pelanggan</label>
                            <select className="form-select" value={idPelanggan} onChange={(e) => setIdPelanggan(e.target.value)} required>
                                <option value="">-- Pilih Pelanggan --</option>
                                {pelangganList.map((p) => (
                                    <option key={p.id} value={p.id}>{p.nama_pelanggan}</option>
                                ))}
                            </select>
                        </div>

                        <h5 className="mt-4">Daftar Barang</h5>
                        {items.map((item, index) => (
                            <div className="row mb-2" key={index}>
                                <div className="col-md-6">
                                    <select className="form-select" value={item.id_barang} onChange={(e) => handleItemChange(index, "id_barang", e.target.value)} required>
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
                                        value={item.qty}
                                        onChange={(e) => handleItemChange(index, "qty", parseInt(e.target.value))}
                                        required
                                    />
                                </div>
                                <div className="col-md-3">
                                    <button type="button" className="btn btn-danger w-100" onClick={() => removeItem(index)} disabled={items.length === 1}>Hapus</button>
                                </div>
                            </div>
                        ))}

                        <div className="mb-3">
                            <button type="button" className="btn btn-secondary" onClick={addItem}>+ Tambah Barang</button>
                        </div>

                        <div className="mb-3">
                            <strong>Subtotal: Rp {subtotal.toLocaleString()}</strong>
                        </div>

                        <button type="submit" className="btn btn-primary">
                            <i className="bi bi-send-check me-2"></i>
                            Update Transaksi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    );
}