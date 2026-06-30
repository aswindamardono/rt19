<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Dashboard_model');
    }

    public function index() {
        $data['title'] = 'Dashboard';
        
        // Statistics
        $data['total_warga'] = $this->Dashboard_model->get_total_warga();
        $data['total_kas'] = $this->Dashboard_model->get_total_kas();
        $data['total_pemasukan'] = $this->Dashboard_model->get_total_pemasukan();
        $data['total_pengeluaran'] = $this->Dashboard_model->get_total_pengeluaran();
        $data['total_tunggakan'] = $this->Dashboard_model->get_total_tunggakan();
        
        // Arrears list
        $data['warga_menunggak'] = $this->Dashboard_model->get_warga_menunggak();

        // Chart Data (6 months)
        $data['chart_labels'] = [];
        $data['chart_pemasukan'] = [];
        $data['chart_pengeluaran'] = [];

        for ($i = 5; $i >= 0; $i--) {
            $month = date('m', strtotime("-$i months"));
            $year = date('Y', strtotime("-$i months"));
            $month_name = date('M Y', strtotime("-$i months"));
            
            $data['chart_labels'][] = $month_name;
            $data['chart_pemasukan'][] = $this->Dashboard_model->get_monthly_pemasukan($month, $year);
            $data['chart_pengeluaran'][] = $this->Dashboard_model->get_monthly_pengeluaran($month, $year);
        }

        $chart_labels_json = json_encode($data['chart_labels']);
        $chart_pemasukan_json = json_encode($data['chart_pemasukan']);
        $chart_pengeluaran_json = json_encode($data['chart_pengeluaran']);

        $data['custom_js'] = "
        <script>
            var ctx = document.getElementById('keuanganChart').getContext('2d');
            var keuanganChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {$chart_labels_json},
                    datasets: [
                        {
                            label: 'Pemasukan',
                            backgroundColor: 'rgba(16, 185, 129, 0.85)',
                            borderColor: '#059669',
                            borderWidth: 1,
                            borderRadius: 6,
                            data: {$chart_pemasukan_json}
                        },
                        {
                            label: 'Pengeluaran',
                            backgroundColor: 'rgba(239, 68, 68, 0.85)',
                            borderColor: '#dc2626',
                            borderWidth: 1,
                            borderRadius: 6,
                            data: {$chart_pengeluaran_json}
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: { font: { family: 'Inter, sans-serif', size: 12, weight: '600' }, color: '#064e3b' }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(16,185,129,0.08)' },
                            ticks: { color: '#64748b', font: { family: 'Inter, sans-serif' },
                                callback: function(v){ return 'Rp ' + Number(v).toLocaleString('id-ID'); } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { color: '#64748b', font: { family: 'Inter, sans-serif' } }
                        }
                    }
                }
            });
        </script>
        ";

        $this->render('dashboard/index', $data);
    }
}
