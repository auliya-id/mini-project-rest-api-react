import React from 'react';

export default function Home() {
    return (
        <div className="container text-center">
            <img
                src="/banner.png"
                alt="Banner Awal"
                style={{ height: "600px", objectFit: "cover" }}
            />
            <h2 className="mt-3">Selamat Datang di Mini Admin</h2>
        </div>
    );
}