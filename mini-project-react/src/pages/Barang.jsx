import { Link, useNavigate } from "react-router-dom";
import DataTable from "react-data-table-component";
import 'bootstrap-icons/font/bootstrap-icons.css';
import Skeleton from "react-loading-skeleton";
import { useEffect, useState } from "react";
import { saveAs } from "file-saver";
import Swal from 'sweetalert2';
import * as XLSX from "xlsx";
import api from "../api/api";
import axios from "axios";

export default function Barang() {
    const [filterText, setFilterText] = useState("");
    const [loading, setLoading] = useState(true);
    const [data, setData] = useState([]);
    const navigate = useNavigate();

    useEffect(() => {
        fetchData();
    }, []);

    const fetchData = async () => {
        setLoading(true);
        try {
            const res = await api.get("/barang");
            setData(res.data);
        } catch (err) {
            console.error("Error ambil data", err);
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
            
            const response = await api.delete(`/barang/${id}`);

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

    const filteredData = data.filter(item =>
        item.nama_barang?.toLowerCase().includes(filterText.toLowerCase()) ||
        item.kode_barang?.toLowerCase().includes(filterText.toLowerCase())
    );

    const columns = [
        { name: "No", selector: (row, index) => index + 1, sortable: false, width: "70px" },
        { name: "Kode Barang", selector: row => row.kode_barang, sortable: true },
        { name: "Nama Barang", selector: row => row.nama_barang, sortable: true },
        { name: "Kategori", selector: row => row.kategori, sortable: true },
        { name: "Warna", selector: row => row.warna, sortable: true },
        { name: "Harga", selector: row => formatRupiah(row.harga), sortable: true },
        { name: "Aksi",
            cell: (row) => (
                <div className="dropdown">
                    <button className="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i className="bi bi-three-dots-vertical"></i>
                    </button>
                    <ul className="dropdown-menu">
                        <li>
                            <button className="dropdown-item" onClick={() => navigate(`/barang/edit/${row.id}`)}>
                                <i className="bi bi-pencil me-2"></i>Edit
                            </button>
                        </li>
                        <li>
                            <button className="dropdown-item text-danger" onClick={() => handleDelete(row.id)}>
                                <i className="bi bi-trash me-2"></i>Hapus
                            </button>
                        </li>
                    </ul>
                </div>
            ),
            ignoreRowClick: true,
            allowOverflow: true,
            button: true,
        },
    ];

    const customStyles = {
        headCells: {
            style: {
                backgroundColor: '#01c3c9',
                color: '#333',
                fontWeight: 'bold',
                fontSize: '14px',
            },
        },
        header: {
            style: {
                minHeight: '56px',
            },
        },
    };

    const formatRupiah = (number) => {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        }).format(number);
    };
    
    const handleExport = () => {
        const ws = XLSX.utils.json_to_sheet(filteredData);
        const wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, "Barang");
        const excelBuffer = XLSX.write(wb, { bookType: "xlsx", type: "array" });
        const blob = new Blob([excelBuffer], { type: "application/octet-stream" });
        saveAs(blob, "barang.xlsx");
    };

    return (
        <div className="container shadow-sm rounded bg-white">
            <h2 className="mb-4 pt-3 fw-bold">Daftar Barang</h2>

            <div className="d-flex justify-content-between my-3">
                <input type="text" className="form-control w-25" placeholder="Cari nama / kode" value={filterText} onChange={(e) => setFilterText(e.target.value)} />
                <div>
                    <Link to="/barang/create" className="btn btn-primary me-2">
                        <i className="bi bi-person-add"></i> Tambah
                    </Link>
                    <button className="btn btn-success" onClick={handleExport}>
                        <i className="bi bi-file-earmark-excel"></i> Export
                    </button>
                </div>
            </div>

            {loading ? (
                <div>
                    <Skeleton height={40} count={5} style={{ marginBottom: '10px' }} />
                </div>
            ) : (
                <DataTable
                    columns={columns}
                    data={filteredData}
                    pagination
                    highlightOnHover
                    responsive
                    striped
                    noHeader
                    customStyles={customStyles}
                />
            )}
        </div>
    );
}
