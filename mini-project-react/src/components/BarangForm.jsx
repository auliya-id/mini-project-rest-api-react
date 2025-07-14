import { useNavigate, useParams } from "react-router-dom";
import React, { useState, useEffect } from "react";
import Skeleton from "react-loading-skeleton";
import Swal from "sweetalert2";
import api from "../api/api";
import axios from "axios";

const BarangForm = () => {
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();
    const { id } = useParams();
    const isEdit = !!id;

    const [form, setForm] = useState({
        nama_barang: "",
        warna: ""
    });

    useEffect(() => {
        if (isEdit) {
            setLoading(true);
            api.get(`/barang/${id}`)
                .then(res => setForm(res.data))
                .catch(() => {
                    Swal.fire("Error", "Gagal mengambil data barang", "error");
                })
                .finally(() => setLoading(false));
        }
    }, [id, isEdit]);

    const handleChange = (e) => {
        setForm({ ...form, [e.target.name]: e.target.value });
    };

    const handleSubmit = async (e) => {
        e.preventDefault();

        try {
            Swal.fire({
                title: 'Menyimpan...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });

            if (isEdit) {
                await api.put(`/barang/${id}`, form);
                Swal.fire("Berhasil", "Data berhasil diubah", "success");
            } else {
                await api.post("/barang", form);
                Swal.fire("Berhasil", "Data berhasil ditambahkan", "success");
            }

            navigate("/barang");
        } catch (error) {
            Swal.fire("Error", "Gagal menyimpan data", "error");
            console.error("Gagal simpan data:", error);
        }
    };

    return (
        <div className="container mt-4">
            <div className="card shadow-sm">
                <div className="card-header bg-primary text-white fw-bold">
                    {isEdit ? "Edit Barang" : "Tambah Barang"}
                </div>
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="nama_barang" className="form-label">Nama Barang</label>
                            {loading ? <Skeleton height={38} /> :
                            <input
                                type="text"
                                className="form-control"
                                id="nama_barang"
                                name="nama_barang"
                                value={form.nama_barang}
                                placeholder="Ex: HARDDISK"
                                onChange={handleChange}
                                required
                            />}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="kategori" className="form-label">Kategori</label>
                            {loading ? <Skeleton height={38} /> :
                            <input
                                type="text"
                                className="form-control"
                                id="kategori"
                                name="kategori"
                                value={form.kategori}
                                placeholder="Ex: ELEKTRONIK"
                                onChange={handleChange}
                                required
                            />}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="harga" className="form-label">Harga</label>
                            {loading ? <Skeleton height={38} /> :
                            <input
                                type="number"
                                className="form-control"
                                id="harga"
                                name="harga"
                                value={form.harga}
                                placeholder="Ex: 12000"
                                onChange={handleChange}
                                required
                            />}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="warna" className="form-label">Warna Barang</label>
                            {loading ? <Skeleton height={38} /> :
                            <input
                                type="text"
                                className="form-control"
                                id="warna"
                                name="warna"
                                value={form.warna}
                                placeholder="Ex: HIJAU"
                                onChange={handleChange}
                                required
                            />}
                        </div>

                        <div className="d-flex justify-content-end">
                            {!loading && (
                                <button type="submit" className="btn btn-success">
                                    <i className="bi bi-send-check me-2"></i>
                                    {isEdit ? "Update" : "Simpan"}
                                </button>
                            )}
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

export default BarangForm;