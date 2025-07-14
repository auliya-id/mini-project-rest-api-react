import { useNavigate, useParams } from "react-router-dom";
import React, { useState, useEffect } from "react";
import Skeleton from "react-loading-skeleton";
import Swal from "sweetalert2";
import api from "../api/api";
import axios from "axios";

const PelangganForm = () => {
    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();
    const { id } = useParams();
    const isEdit = !!id;

    const [form, setForm] = useState({
        nama_pelanggan: "",
        domisili: "",
        alamat: "",
        jenis_kelamin: ""
    });

    useEffect(() => {
        if (isEdit) {
            setLoading(true);
            api.get(`/pelanggan/${id}`)
                .then(res => setForm(res.data))
                .catch(() => {
                    Swal.fire("Error", "Gagal mengambil data pelanggan", "error");
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
                await api.put(`/pelanggan/${id}`, form);
                Swal.fire("Berhasil", "Data berhasil diubah", "success");
            } else {
                await api.post("/pelanggan", form);
                Swal.fire("Berhasil", "Data berhasil ditambahkan", "success");
            }

            navigate("/pelanggan");
        } catch (error) {
            Swal.fire("Error", "Gagal menyimpan data", "error");
            console.error("Gagal simpan data:", error);
        }
    };

    return (
        <div className="container mt-4">
            <div className="card shadow-sm">
                <div className="card-header bg-primary text-white fw-bold">
                    {isEdit ? "Edit Pelanggan" : "Tambah Pelanggan"}
                </div>
                <div className="card-body">
                    <form onSubmit={handleSubmit}>
                        <div className="mb-3">
                            <label htmlFor="nama_pelanggan" className="form-label">Nama Pelanggan</label>
                            {loading ? <Skeleton height={38} /> :
                            <input
                                type="text"
                                className="form-control"
                                id="nama_pelanggan"
                                name="nama_pelanggan"
                                value={form.nama_pelanggan}
                                placeholder="Ex: BUDIONO SIREGAR"
                                onChange={handleChange}
                                required
                            />}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="domisili" className="form-label">Domisili</label>
                            {loading ? <Skeleton height={38} /> :
                            <input
                                type="text"
                                className="form-control"
                                id="domisili"
                                name="domisili"
                                value={form.domisili}
                                placeholder="Ex: JAK-BAR"
                                onChange={handleChange}
                                required
                            />}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="alamat" className="form-label">Alamat</label>
                            {loading ? <Skeleton height={38} /> :
                            <input
                                type="text"
                                className="form-control"
                                id="alamat"
                                name="alamat"
                                value={form.alamat}
                                placeholder="Ex: Jl. In Aja"
                                onChange={handleChange}
                                required
                            />}
                        </div>

                        <div className="mb-3">
                            <label htmlFor="jenis_kelamin" className="form-label">Jenis Kelamin</label>
                            {loading ? <Skeleton height={38} /> :
                            <select
                                className="form-select"
                                id="jenis_kelamin"
                                name="jenis_kelamin"
                                value={form.jenis_kelamin}
                                onChange={handleChange}
                                required
                            >
                                <option value="">-- Pilih Jenis Kelamin --</option>
                                <option value="PRIA">PRIA</option>
                                <option value="WANITA">WANITA</option>
                            </select>}
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

export default PelangganForm;