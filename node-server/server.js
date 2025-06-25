require('dotenv').config();
const express = require('express');
const mysql = require('mysql2/promise');
const bodyParser = require('body-parser');
const cors = require('cors');
const { v4: uuidv4 } = require('uuid');

const app = express();

app.use(cors());
app.use(bodyParser.json());

const db = mysql.createPool({
    host: process.env.DB_HOST,
    user: process.env.DB_USER,
    password: process.env.DB_PASS,
    database: process.env.DB_NAME,
});

app.post('/api/kehadiran', async (req, res) => {
    try {
        const { pendaftaran_event_id, user_id, event_id } = req.body;

        if (!pendaftaran_event_id || !user_id || !event_id) {
            return res.status(400).json({ message: 'Data tidak lengkap!' });
        }

        // Cek apakah kehadiran sudah tercatat
        const [existing] = await db.query(
            'SELECT * FROM kehadiran WHERE pendaftaran_event_id = ?',
            [pendaftaran_event_id]
        );

        if (existing.length > 0) {
            return res.json({ message: 'Kehadiran sudah tercatat.' });
        }

        // Ambil data event
        const [eventRows] = await db.query(
            'SELECT tanggal, waktu, waktu_selesai FROM event WHERE id = ?',
            [event_id]
        );

        if (eventRows.length === 0) {
            return res.status(404).json({ message: 'Event tidak ditemukan.' });
        }

        const { tanggal, waktu, waktu_selesai } = eventRows[0];

        // Buat objek waktu berdasarkan tanggal dan jam
        const waktuMulai = new Date(`${tanggal}T${waktu}:00`);
        const waktuSelesai = new Date(`${tanggal}T${waktu_selesai}:00`);
        const waktuSekarang = new Date();

        // Batas awal kehadiran: 1 jam sebelum mulai
        const waktuMulaiCheckin = new Date(waktuMulai.getTime() - 60 * 60 * 1000);

        if (waktuSekarang < waktuMulaiCheckin || waktuSekarang > waktuSelesai) {
            return res.status(403).json({ 
                message: 'Kehadiran hanya dapat dicatat mulai 1 jam sebelum acara hingga waktu selesai.' 
            });
        }

        await db.query(
            'INSERT INTO kehadiran (id, users_id, pendaftaran_event_id, event_id, waktu_kehadiran) VALUES (?, ?, ?, ?, NOW())',
            [uuidv4(), user_id, pendaftaran_event_id, event_id]
        );

        return res.json({ message: 'Kehadiran berhasil dicatat.' });

    } catch (err) {
        console.error('Error saat proses kehadiran:', err);
        res.status(500).json({ message: 'Terjadi kesalahan pada server.' });
    }
});


app.listen(3000, () => {
    console.log('Node.js API berjalan di http://localhost:3000');
});
