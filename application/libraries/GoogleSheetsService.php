<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once FCPATH . 'vendor/autoload.php';

class GoogleSheetsService {

    protected $client;
    protected $service;
    protected $spreadsheetId;

    public function __construct() {
        $CI =& get_instance();
        
        $this->spreadsheetId = $CI->db->get_where('tb_pengaturan', ['key_setting' => 'google_sheet_id'])->row()->value_setting;
        $credentialsPath = $CI->db->get_where('tb_pengaturan', ['key_setting' => 'google_credentials_path'])->row()->value_setting;
        
        // If not configured, we'll gracefully handle it in the controller
        if (empty($this->spreadsheetId) || empty($credentialsPath) || !file_exists(FCPATH . $credentialsPath)) {
            return;
        }

        $this->client = new \Google\Client();
        $this->client->setApplicationName('RT19 Management System');
        $this->client->setScopes([\Google\Service\Sheets::SPREADSHEETS]);
        $this->client->setAuthConfig(FCPATH . $credentialsPath);
        $this->client->setAccessType('offline');

        $this->service = new \Google\Service\Sheets($this->client);
    }

    public function is_configured() {
        return $this->service !== null;
    }

    public function syncPemasukan($data) {
        if (!$this->is_configured()) return false;
        
        $range = 'Pemasukan!A2:E'; // Asumsi sheet bernama 'Pemasukan'
        
        // Clear old data first (optional but good for complete sync)
        $this->service->spreadsheets_values->clear($this->spreadsheetId, $range, new \Google\Service\Sheets\ClearValuesRequest());

        $values = [];
        foreach ($data as $row) {
            $values[] = [
                $row->tanggal,
                $row->kategori,
                $row->keterangan,
                $row->nominal,
                $row->created_at
            ];
        }

        $body = new \Google\Service\Sheets\ValueRange([
            'values' => $values
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];

        try {
            $result = $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);
            return true;
        } catch (Exception $e) {
            log_message('error', 'Google Sheets Sync Pemasukan Failed: ' . $e->getMessage());
            return false;
        }
    }

    public function syncPengeluaran($data) {
        if (!$this->is_configured()) return false;
        
        $range = 'Pengeluaran!A2:E'; 
        $this->service->spreadsheets_values->clear($this->spreadsheetId, $range, new \Google\Service\Sheets\ClearValuesRequest());

        $values = [];
        foreach ($data as $row) {
            $values[] = [
                $row->tanggal,
                $row->kategori,
                $row->keterangan,
                $row->nominal,
                $row->created_at
            ];
        }

        $body = new \Google\Service\Sheets\ValueRange([
            'values' => $values
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];

        try {
            $result = $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);
            return true;
        } catch (Exception $e) {
            log_message('error', 'Google Sheets Sync Pengeluaran Failed: ' . $e->getMessage());
            return false;
        }
    }

    public function syncKas($total_pemasukan, $total_pengeluaran, $saldo_akhir) {
        if (!$this->is_configured()) return false;
        
        $range = 'Ringkasan!A2:C2'; 

        $values = [
            [$total_pemasukan, $total_pengeluaran, $saldo_akhir]
        ];

        $body = new \Google\Service\Sheets\ValueRange([
            'values' => $values
        ]);

        $params = [
            'valueInputOption' => 'USER_ENTERED'
        ];

        try {
            $result = $this->service->spreadsheets_values->update($this->spreadsheetId, $range, $body, $params);
            return true;
        } catch (Exception $e) {
            log_message('error', 'Google Sheets Sync Kas Failed: ' . $e->getMessage());
            return false;
        }
    }
}
