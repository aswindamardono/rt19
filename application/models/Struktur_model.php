<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Struktur_model extends CI_Model {

    private $table = 'tb_struktur';

    /**
     * Auto-buat tabel & migrasi kolom parent_id jika belum ada.
     * Disebut tiap model dipanggil — idempotent.
     */
    public function ensure_table() {
        // (1) Buat tabel kalau belum ada
        if (!$this->db->table_exists($this->table)) {
            $this->db->query("
                CREATE TABLE IF NOT EXISTS `{$this->table}` (
                  `id` int(11) NOT NULL AUTO_INCREMENT,
                  `parent_id` int(11) DEFAULT NULL,
                  `jabatan` varchar(100) NOT NULL,
                  `nama` varchar(150) DEFAULT NULL,
                  `no_hp` varchar(20) DEFAULT NULL,
                  `foto` varchar(150) DEFAULT NULL,
                  `deskripsi` text DEFAULT NULL,
                  `urutan` int(11) NOT NULL DEFAULT 0,
                  `is_active` tinyint(1) NOT NULL DEFAULT 1,
                  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                  PRIMARY KEY (`id`),
                  KEY `idx_parent` (`parent_id`),
                  KEY `idx_urutan` (`urutan`),
                  KEY `idx_active` (`is_active`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
            ");
            $this->_seed_default();
            return;
        }

        // (2) Tabel ada — pastikan parent_id kolomnya ada
        if (!$this->db->field_exists('parent_id', $this->table)) {
            $this->db->query("ALTER TABLE `{$this->table}` ADD COLUMN `parent_id` INT(11) NULL DEFAULT NULL AFTER `id`");
            $this->db->query("ALTER TABLE `{$this->table}` ADD KEY `idx_parent` (`parent_id`)");
            $this->_apply_default_hierarchy();
        }

        // (3) Tabel kosong → seed
        if ($this->db->count_all($this->table) === 0) {
            $this->_seed_default();
        }
    }

    /** Seed 13 jabatan default + hierarki */
    private function _seed_default() {
        $defaults = [
            ['Ketua RT',                    null, 1],
            ['Wakil Ketua RT',              null, 2],
            ['Bendahara 1',                 null, 3],
            ['Bendahara 2',                 null, 4],
            ['Sekretaris 1',                null, 5],
            ['Sekretaris 2',                null, 6],
            ['SIE Pembangunan',             null, 7],
            ['SIE Keamanan',                null, 8],
            ['SIE Konsumsi',                null, 9],
            ['SIE Seni & Olahraga',         null, 10],
            ['SIE Pendataan',               null, 11],
            ['SIE Pendanaan',               null, 12],
            ['SIE Perlengkapan & Humas',    null, 13],
        ];
        foreach ($defaults as $d) {
            $this->db->insert($this->table, [
                'jabatan' => $d[0],
                'parent_id' => $d[1],
                'urutan'  => $d[2],
            ]);
        }
        $this->_apply_default_hierarchy();
    }

    /**
     * Set default parent_id untuk hirarki tipikal RT:
     *   Ketua RT (root)
     *     ├── Wakil Ketua RT
     *     ├── Bendahara 1 ─ Bendahara 2
     *     ├── Sekretaris 1 ─ Sekretaris 2
     *     └── SIE * (semua di bawah Ketua)
     */
    private function _apply_default_hierarchy() {
        $rows = $this->db->get($this->table)->result();
        if (!$rows) return;

        // Index by jabatan (case-insensitive)
        $by_jabatan = [];
        foreach ($rows as $r) {
            $by_jabatan[strtolower(trim($r->jabatan))] = $r;
        }

        $ketua = $by_jabatan['ketua rt'] ?? null;
        if (!$ketua) return;

        // Mapping subordinasi
        $sub_to_super = [
            'bendahara 2'  => 'bendahara 1',
            'sekretaris 2' => 'sekretaris 1',
        ];

        foreach ($rows as $r) {
            if ($r->id == $ketua->id) continue;          // Ketua = root
            if ($r->parent_id !== null) continue;        // Sudah ada parent → skip

            $key = strtolower(trim($r->jabatan));
            $pid = $ketua->id;
            if (isset($sub_to_super[$key]) && isset($by_jabatan[$sub_to_super[$key]])) {
                $pid = $by_jabatan[$sub_to_super[$key]]->id;
            }
            $this->db->where('id', $r->id)->update($this->table, ['parent_id' => $pid]);
        }
    }

    public function get_all($only_active = false) {
        $this->ensure_table();
        if ($only_active) $this->db->where('is_active', 1);
        $this->db->order_by('urutan', 'ASC');
        $this->db->order_by('id', 'ASC');
        return $this->db->get($this->table)->result();
    }

    /** Untuk dropdown parent (semua kecuali diri sendiri & turunannya) */
    public function get_parent_options($exclude_id = null) {
        $all = $this->get_all(false);
        if (!$exclude_id) return $all;

        // Cari semua descendant dari $exclude_id supaya tidak bisa dipilih sebagai parent
        $banned = [(int)$exclude_id];
        $changed = true;
        while ($changed) {
            $changed = false;
            foreach ($all as $r) {
                if (in_array($r->id, $banned)) continue;
                if ($r->parent_id !== null && in_array((int)$r->parent_id, $banned)) {
                    $banned[] = (int)$r->id;
                    $changed = true;
                }
            }
        }

        return array_values(array_filter($all, function($r) use ($banned) {
            return !in_array((int)$r->id, $banned);
        }));
    }

    public function get_by_id($id) {
        $this->ensure_table();
        return $this->db->where('id', (int)$id)->get($this->table)->row();
    }

    public function insert($data) {
        $this->ensure_table();
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->ensure_table();
        $this->db->where('id', (int)$id)->update($this->table, $data);
        return $this->db->affected_rows();
    }

    public function delete($id) {
        $this->ensure_table();
        $row = $this->get_by_id($id);
        if ($row && !empty($row->foto)) {
            $path = FCPATH.'uploads/struktur/'.$row->foto;
            if (is_file($path)) @unlink($path);
        }
        // Promote anak-anak ke parent dari node yang dihapus
        if ($row) {
            $this->db->where('parent_id', (int)$id)
                     ->update($this->table, ['parent_id' => $row->parent_id]);
        }
        return $this->db->where('id', (int)$id)->delete($this->table);
    }

    public function next_urutan() {
        $this->ensure_table();
        $row = $this->db->select_max('urutan')->get($this->table)->row();
        return ((int)($row->urutan ?? 0)) + 1;
    }
}
