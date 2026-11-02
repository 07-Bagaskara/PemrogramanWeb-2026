-- Jobsheet 12: tabel sewa, menghubungkan alat_kemah dan penyewa
-- Jalankan di Supabase: SQL Editor -> tempel isi file ini -> Run

CREATE TABLE IF NOT EXISTS sewa (
    id SERIAL PRIMARY KEY,
    alat_id INTEGER NOT NULL REFERENCES alat_kemah(id),
    penyewa_id INTEGER NOT NULL REFERENCES penyewa(id),
    jumlah INTEGER NOT NULL DEFAULT 1 CHECK (jumlah > 0),
    tanggal_sewa DATE NOT NULL DEFAULT CURRENT_DATE,
    tanggal_kembali DATE,
    status VARCHAR(20) NOT NULL DEFAULT 'disewa'
        CHECK (status IN ('disewa', 'dikembalikan'))
);

-- Mempercepat query "daftar sewa yang masih aktif"
CREATE INDEX IF NOT EXISTS idx_sewa_status ON sewa(status);
