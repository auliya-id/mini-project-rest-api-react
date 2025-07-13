import { useNavigate } from "react-router-dom";
import Skeleton from 'react-loading-skeleton';
import { useEffect, useState } from "react";
import Swal from 'sweetalert2';
import api from "../api/api";
import axios from "axios";

export default function Penjualan() {
    const [loading, setLoading] = useState(true);
    const [data, setData] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        try {
            setLoading(true);
            const res = await api.get("/penjualan");
            setData(res.data);
        } catch (err) {
            console.error("Gagal mengambil data:", err);
        } finally {
            setLoading(false);
        }
    };

    const handleDelete = async (id) => {
        const confirm = await Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: "Data ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal',
        });

        if (!confirm.isConfirmed) return;

        try {
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            
            const response = await api.delete(`/penjualan/${id}`);

            if (response.data.success === false) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: response.data.message,
                });
                return;
            }

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil dihapus.',
            });

            fetchData(); // refresh data

        } catch (error) {
            const errorMsg = error.response?.data?.message || "Terjadi kesalahan saat menghapus data.";
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMsg,
            });
            console.error(error);
        }
    };

    return (
        <div className="container mt-4">
            <div className="d-flex justify-content-between align-items-center mb-4">
                <h2 className="fw-bold">Daftar Transaksi Penjualan</h2>
                <button onClick={() => navigate("/penjualan/create")} className="btn btn-primary">
                    <i className="bi bi-plus-lg me-1"></i> Tambah Transaksi
                </button>
            </div>

            <div className="row">
                {loading ? (
                    // Tampilkan 2 skeleton card saat loading
                    [...Array(2)].map((_, i) => (
                        <div className="col-md-6 mb-4" key={i}>
                            <div className="card p-3 shadow-sm">
                                <Skeleton height={24} width="60%" className="mb-2" />
                                <Skeleton height={20} width="40%" className="mb-2" />
                                <Skeleton count={3} className="mb-1" />
                                <div className="d-flex justify-content-end mt-3 gap-2">
                                    <Skeleton width={80} height={32} />
                                    <Skeleton width={80} height={32} />
                                </div>
                            </div>
                        </div>
                    ))
                ) : (
                    data.map((transaksi) => (
                        <div key={transaksi.id} className="col-md-6 mb-4">
                            <div className="card shadow-sm h-100 border-0">
                                <div className="card-body">
                                    <h5 className="card-title fw-semibold mb-2">
                                        {transaksi.nama_pelanggan} ({transaksi.kode_pelanggan})
                                    </h5>
                                    <p className="mb-1 text-muted">Kode Nota: {transaksi.kode_nota}</p>
                                    <p className="mb-1 text-muted">Tanggal: {transaksi.tanggal}</p>
                                    <p className="mb-2">
                                        Subtotal: <strong>{parseFloat(transaksi.subtotal).toLocaleString("id-ID", { style: "currency", currency: "IDR" })}</strong>
                                    </p>
                                    <div>
                                        <strong>Item Barang:</strong>
                                        <ul className="mb-3">
                                            {transaksi.items.map((item, i) => (
                                                <li key={i}>
                                                    {item.nama_barang} ({item.kode_barang}): {parseFloat(item.harga).toLocaleString("id-ID", { style: "currency", currency: "IDR" })} * Qty: {item.qty} =&nbsp;
                                                    {parseFloat(item.harga * item.qty).toLocaleString("id-ID", { style: "currency", currency: "IDR" })}
                                                </li>
                                            ))}
                                        </ul>
                                    </div>
                                    <div className="d-flex justify-content-end gap-2">
                                        <button onClick={() => navigate(`/penjualan/edit/${transaksi.id}`)} className="btn btn-sm btn-outline-primary">
                                            <i className="bi bi-pencil-square me-1"></i>Edit
                                        </button>
                                        <button onClick={() => handleDelete(transaksi.id)} className="btn btn-sm btn-outline-danger">
                                            <i className="bi bi-trash me-1"></i>Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ))
                )}

                {!loading && data.length === 0 && (
                    <div className="col-12 text-center text-muted py-5">
                        <i className="bi bi-cart-x fs-1 mb-3"></i>
                        <p className="fs-5">Belum ada transaksi penjualan</p>
                    </div>
                )}
            </div>
        </div>
    );
}
