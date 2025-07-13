import { Link, useLocation } from "react-router-dom";
import "bootstrap/dist/css/bootstrap.min.css";
import api from "../api/api";
import React from "react";

const LayoutAdmin = ({ children }) => {
    const location = useLocation();

    const navItems = [
        { path: "/pelanggan", label: "Pelanggan" },
        { path: "/barang", label: "Barang" },
        { path: "/penjualan", label: "Penjualan" },
    ];

    return (
        <div className="d-flex" style={{ minHeight: "100vh" }}>
            {/* Sidebar */}
            <nav className="bg-green text-white p-3" style={{ width: "220px" }}>
                <Link to="/" className="no-underline">
                    <h4 className="text-center mb-4 text-white">
                        Mini Admin
                    </h4>
                </Link>
                <ul className="nav flex-column">
                    {navItems.map((item) => (
                        <li className="nav-item" key={item.path}>
                            <Link
                                to={item.path}
                                className={`nav-link text-white ${
                                location.pathname.startsWith(item.path) ? "active bg-black-soft rounded" : ""
                                }`}
                            >
                                {item.label}
                            </Link>
                        </li>
                    ))}
                </ul>
            </nav>

            {/* Main Content */}
            <div className="flex-grow-1 bg-secondary-soft p-4">
                {children}
            </div>
        </div>
    );
};

export default LayoutAdmin;
