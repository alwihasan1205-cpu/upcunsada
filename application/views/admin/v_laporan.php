<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header"><strong>Grafik Kunjungan Photobooth (7 Hari Terakhir)</strong></div>
            <div class="card-body">
                <canvas id="dailyChart" style="width: 100%; height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Tabel Statistik Harian</strong>
                <a href="<?= base_url('admin/export_laporan') ?>" class="btn btn-success btn-sm fw-bold px-3">
                    <i class="bi bi-file-earmark-excel"></i> Export Excel
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Tanggal</th>
                                <th class="text-center">Jumlah Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($stats)): ?>
                                <tr><td colspan="2" class="text-center py-4">Belum ada data tersedia</td></tr>
                            <?php endif; ?>
                            <?php foreach($stats as $s): ?>
                            <tr>
                                <td class="ps-3"><?= date('d F Y', strtotime($s->date)) ?></td>
                                <td class="text-center fw-bold text-primary"><?= $s->total ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card mb-4 bg-primary text-white">
            <div class="card-body text-center py-5">
                <i class="bi bi-award-fill fs-1"></i>
                <h2 class="mt-3">Total Foto Terkumpul</h2>
                <div class="display-3 fw-bold"><?= array_sum(array_column($stats, 'total')) ?></div>
                <p class="lead">Momen berharga yang telah diabadikan</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('dailyChart');
        
        // Data dari PHP
        const chartData = [
            <?php 
                $chart_query = $this->db->query("SELECT DATE(created_at) as date, COUNT(*) as count FROM tb_photos GROUP BY DATE(created_at) ORDER BY date DESC LIMIT 7");
                $data_rev = array_reverse($chart_query->result());
                foreach($data_rev as $d) { echo "{ date: '".date('d/m', strtotime($d->date))."', count: ".$d->count." },"; } 
            ?>
        ];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: chartData.map(d => d.date),
                datasets: [{
                    label: 'Jumlah Foto',
                    data: chartData.map(d => d.count),
                    borderColor: '#248afd',
                    backgroundColor: 'rgba(36, 138, 253, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#248afd'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                },
                plugins: {
                    legend: { display: false }
                }
            }
        });
    });
</script>
